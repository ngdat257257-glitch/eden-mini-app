<?php
// api/wallet.php
require_once __DIR__ . '/../config/db.php';

$pdo = getDb();
$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? 'summary';
$input = json_decode(file_get_contents('php://input'), true) ?? $_POST;

// 1. Wallet Summary
if ($action === 'summary' && $method === 'GET') {
    $user = requireAuth($pdo);
    $settings = getSettings($pdo);

    jsonResponse([
        'usdt_balance' => round((float)$user['usdt_balance'], 4),
        'coin_balance' => round((float)$user['coin_balance'], 6),
        'coin_price_usdt' => (float)($settings['coin_price_usdt'] ?? 0.001),
        'coin_symbol' => $settings['coin_symbol'] ?? 'MNX',
        'coin_name' => $settings['coin_name'] ?? 'Minex Coin',
        'deposit_address' => $settings['usdt_deposit_address'] ?? '0x596b41afd2b5f6336a3171898752c2265ae86878',
        'network' => $settings['network'] ?? 'USDT (BEP20)',
        'min_deposit' => (float)($settings['min_deposit'] ?? 10),
        'min_withdraw' => (float)($settings['min_withdraw'] ?? 15),
        'withdraw_fee_percent' => (float)($settings['withdraw_fee_percent'] ?? 2.5)
    ]);
}

// 2. Submit Deposit
if ($action === 'deposit' && $method === 'POST') {
    $user = requireAuth($pdo);
    $settings = getSettings($pdo);

    $amount = (float)($input['amount'] ?? 0);
    $minDeposit = (float)($settings['min_deposit'] ?? 10);

    if ($amount < $minDeposit) {
        jsonResponse(['error' => "Số tiền nạp tối thiểu là {$minDeposit} USDT"], 400);
    }

    $txHash = trim($input['txHash'] ?? '') ?: 'tx_demo_' . substr(bin2hex(random_bytes(6)), 0, 12);
    $txId = 'dep_' . time() . '_' . substr(bin2hex(random_bytes(3)), 0, 4);

    $stmt = $pdo->prepare("INSERT INTO transactions (id, user_id, type, amount, currency, detail, status, created_at) VALUES (?, ?, 'deposit', ?, 'USDT', ?, 'pending', ?)");
    $stmt->execute([
        $txId,
        $user['id'],
        $amount,
        json_encode([
            'network' => $settings['network'] ?? 'USDT (TRC20)',
            'tx_hash' => $txHash,
            'deposit_address' => $settings['usdt_deposit_address'] ?? ''
        ]),
        date('c')
    ]);

    jsonResponse([
        'message' => 'Lệnh nạp USDT đã được tạo thành công! Lệnh đang chờ hệ thống/Admin kiểm tra và phê duyệt.',
        'transaction' => [
            'id' => $txId,
            'amount' => $amount,
            'status' => 'pending'
        ]
    ], 201);
}

// 3. Submit Withdrawal
if ($action === 'withdraw' && $method === 'POST') {
    $user = requireAuth($pdo);
    $settings = getSettings($pdo);

    $amount = (float)($input['amount'] ?? 0);
    $address = trim($input['address'] ?? '');
    $minWithdraw = (float)($settings['min_withdraw'] ?? 15);
    $feePercent = (float)($settings['withdraw_fee_percent'] ?? 2.5);

    if ($amount < $minWithdraw) {
        jsonResponse(['error' => "Số tiền rút tối thiểu là {$minWithdraw} USDT"], 400);
    }

    if (empty($address) || strlen($address) < 10) {
        jsonResponse(['error' => 'Địa chỉ ví nhận USDT không hợp lệ'], 400);
    }

    $currentUsdt = (float)$user['usdt_balance'];
    if ($currentUsdt < $amount) {
        jsonResponse(['error' => "Số dư không đủ. Bạn có " . number_format($currentUsdt, 2) . " USDT"], 400);
    }

    $fee = round($amount * ($feePercent / 100), 4);
    $netAmount = max(0, round($amount - $fee, 4));

    $pdo->beginTransaction();
    try {
        $newBalance = round($currentUsdt - $amount, 4);
        $updUser = $pdo->prepare("UPDATE users SET usdt_balance = ? WHERE id = ?");
        $updUser->execute([$newBalance, $user['id']]);

        $txId = 'wd_' . time() . '_' . substr(bin2hex(random_bytes(3)), 0, 4);
        $stmt = $pdo->prepare("INSERT INTO transactions (id, user_id, type, amount, currency, detail, status, created_at) VALUES (?, ?, 'withdraw', ?, 'USDT', ?, 'pending', ?)");
        $stmt->execute([
            $txId,
            $user['id'],
            $amount,
            json_encode([
                'recipient_address' => $address,
                'network' => $settings['network'] ?? 'USDT (TRC20)',
                'fee_percent' => $feePercent,
                'fee_amount' => $fee,
                'net_amount' => $netAmount
            ]),
            date('c')
        ]);

        $pdo->commit();

        jsonResponse([
            'message' => "Lệnh rút {$amount} USDT (thực nhận: {$netAmount} USDT) đã được gửi và đang chờ xét duyệt!",
            'usdt_balance' => $newBalance
        ]);
    } catch (Exception $e) {
        $pdo->rollBack();
        jsonResponse(['error' => 'Lỗi xử lý rút tiền: ' . $e->getMessage()], 500);
    }
}

// 4. Swap Coin -> USDT
if ($action === 'swap' && $method === 'POST') {
    $user = requireAuth($pdo);
    $settings = getSettings($pdo);

    $coinAmount = (float)($input['coinAmount'] ?? 0);
    $currentCoin = (float)$user['coin_balance'];
    $currentUsdt = (float)$user['usdt_balance'];

    if ($coinAmount <= 0) {
        jsonResponse(['error' => 'Vui lòng nhập số lượng Coin hợp lệ cần đổi'], 400);
    }

    if ($coinAmount > $currentCoin) {
        jsonResponse(['error' => "Số dư Coin không đủ. Bạn đang có " . number_format($currentCoin, 4) . " " . ($settings['coin_symbol'] ?? 'MNX')], 400);
    }

    $rate = (float)($settings['coin_price_usdt'] ?? 0.001);
    $usdtReceived = round($coinAmount * $rate, 4);

    $newCoinBalance = round($currentCoin - $coinAmount, 6);
    $newUsdtBalance = round($currentUsdt + $usdtReceived, 4);

    $pdo->beginTransaction();
    try {
        $updUser = $pdo->prepare("UPDATE users SET coin_balance = ?, usdt_balance = ? WHERE id = ?");
        $updUser->execute([$newCoinBalance, $newUsdtBalance, $user['id']]);

        $txId = 'swap_' . time() . '_' . substr(bin2hex(random_bytes(3)), 0, 4);
        $stmt = $pdo->prepare("INSERT INTO transactions (id, user_id, type, amount, currency, detail, status, created_at) VALUES (?, ?, 'swap', ?, ?, ?, 'completed', ?)");
        $stmt->execute([
            $txId,
            $user['id'],
            $coinAmount,
            $settings['coin_symbol'] ?? 'MNX',
            json_encode([
                'rate_usdt' => $rate,
                'usdt_received' => $usdtReceived,
                'coin_swapped' => $coinAmount
            ]),
            date('c')
        ]);

        $pdo->commit();

        jsonResponse([
            'message' => "Đổi thành công {$coinAmount} " . ($settings['coin_symbol'] ?? 'MNX') . " lấy +{$usdtReceived} USDT!",
            'coin_balance' => $newCoinBalance,
            'usdt_balance' => $newUsdtBalance,
            'usdt_received' => $usdtReceived
        ]);
    } catch (Exception $e) {
        $pdo->rollBack();
        jsonResponse(['error' => 'Lỗi quy đổi coin: ' . $e->getMessage()], 500);
    }
}

// 5. Get User Transactions
if ($action === 'transactions' && $method === 'GET') {
    $user = requireAuth($pdo);
    $stmt = $pdo->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user['id']]);
    $txs = $stmt->fetchAll();

    foreach ($txs as &$t) {
        $t['detail'] = json_decode($t['detail'] ?? '{}', true);
    }

    jsonResponse(['transactions' => $txs]);
}

jsonResponse(['error' => 'Yêu cầu không hợp lệ'], 400);
