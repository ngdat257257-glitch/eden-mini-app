<?php
// api/auth.php
require_once __DIR__ . '/../config/db.php';

$pdo = getDb();
$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

// Support JSON input
$input = json_decode(file_get_contents('php://input'), true) ?? $_POST;

if ($action === 'register' && $method === 'POST') {
    $email = trim($input['email'] ?? '');
    $password = $input['password'] ?? '';
    $name = trim($input['name'] ?? '');

    if (empty($email) || empty($password)) {
        jsonResponse(['error' => 'Email và mật khẩu không được để trống'], 400);
    }
    if (strlen($password) < 6) {
        jsonResponse(['error' => 'Mật khẩu phải có ít nhất 6 ký tự'], 400);
    }

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([strtolower($email)]);
    if ($stmt->fetch()) {
        jsonResponse(['error' => 'Email này đã được đăng ký trên hệ thống'], 400);
    }

    $refCode = trim($input['ref'] ?? $input['ref_code'] ?? '');
    $referrerId = null;
    if (!empty($refCode)) {
        $findRef = $pdo->prepare("SELECT id FROM users WHERE uid = ? OR id = ? LIMIT 1");
        $findRef->execute([$refCode, $refCode]);
        $referrerUser = $findRef->fetch();
        if ($referrerUser) {
            $referrerId = $referrerUser['id'];
        }
    }

    $userId = 'user_' . time() . '_' . substr(bin2hex(random_bytes(4)), 0, 6);
    $uid = (string)mt_rand(100000, 999999);
    $displayName = $name ?: explode('@', $email)[0];
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $initialUsdt = 100.0; // 100 USDT Welcome bonus

    $stmt = $pdo->prepare("INSERT INTO users (id, uid, email, name, password_hash, role, usdt_balance, coin_balance, created_at, referrer_id) VALUES (?, ?, ?, ?, ?, 'user', ?, 0, ?, ?)");
    $stmt->execute([$userId, $uid, strtolower($email), $displayName, $passwordHash, $initialUsdt, date('c'), $referrerId]);

    // Transaction bonus
    $txId = 'tx_bonus_' . time();
    $txStmt = $pdo->prepare("INSERT INTO transactions (id, user_id, type, amount, currency, detail, status, created_at) VALUES (?, ?, 'deposit', ?, 'USDT', ?, 'approved', ?)");
    $txStmt->execute([$txId, $userId, $initialUsdt, json_encode(['note' => 'Tặng thưởng đăng ký thành viên mới (+100 USDT)']), date('c')]);

    $_SESSION['user_id'] = $userId;

    $user = [
        'id' => $userId,
        'uid' => $uid,
        'email' => strtolower($email),
        'name' => $displayName,
        'role' => 'user',
        'usdt_balance' => $initialUsdt,
        'coin_balance' => 0.0,
        'created_at' => date('c'),
        'referrer_id' => $referrerId
    ];

    jsonResponse([
        'message' => 'Đăng ký tài khoản thành công! Bạn nhận được 100 USDT khởi nghiệp.',
        'token' => $userId,
        'user' => $user
    ], 201);
}

if ($action === 'login' && $method === 'POST') {
    $email = trim($input['email'] ?? '');
    $password = $input['password'] ?? '';

    if (empty($email) || empty($password)) {
        jsonResponse(['error' => 'Vui lòng nhập email và mật khẩu'], 400);
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([strtolower($email)]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        jsonResponse(['error' => 'Email hoặc mật khẩu không chính xác'], 400);
    }

    $_SESSION['user_id'] = $user['id'];
    unset($user['password_hash']);

    jsonResponse([
        'message' => 'Đăng nhập thành công',
        'token' => $user['id'],
        'user' => $user
    ]);
}

if ($action === 'me' && $method === 'GET') {
    $user = getCurrentUser($pdo);
    if (!$user) {
        jsonResponse(['error' => 'Chưa đăng nhập', 'user' => null], 401);
    }
    $cntStmt = $pdo->prepare("SELECT COUNT(*) FROM user_miners WHERE user_id = ? AND status = 'active'");
    $cntStmt->execute([$user['id']]);
    $packagesCount = (int)$cntStmt->fetchColumn();
    $user['packages_count'] = $packagesCount;
    $user['level'] = max(1, 1 + (int)floor($packagesCount / 10));

    $settings = getSettings($pdo);
    jsonResponse([
        'user' => $user,
        'settings' => $settings
    ]);
}

if ($action === 'referral_stats' && $method === 'GET') {
    $user = getCurrentUser($pdo);
    if (!$user) {
        jsonResponse(['error' => 'Chưa đăng nhập'], 401);
    }

    // 1. Count F1 members
    $f1CountStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE referrer_id = ?");
    $f1CountStmt->execute([$user['id']]);
    $f1Count = (int)$f1CountStmt->fetchColumn();

    // 2. Total commission earned from F1 purchases (10%)
    $commStmt = $pdo->prepare("SELECT SUM(amount) FROM transactions WHERE user_id = ? AND type = 'commission'");
    $commStmt->execute([$user['id']]);
    $totalComm = (float)($commStmt->fetchColumn() ?: 0.0);

    // 3. F1 members list
    $f1ListStmt = $pdo->prepare("
        SELECT u.id, u.uid, u.name, u.email, u.created_at,
               (SELECT COUNT(*) FROM user_miners um WHERE um.user_id = u.id) as miners_count,
               (SELECT IFNULL(SUM(amount), 0) FROM transactions t WHERE t.user_id = u.id AND t.type = 'buy_miner') as total_spent
        FROM users u 
        WHERE u.referrer_id = ? 
        ORDER BY u.created_at DESC 
        LIMIT 20
    ");
    $f1ListStmt->execute([$user['id']]);
    $f1Users = $f1ListStmt->fetchAll();

    // 4. Commission history
    $commHistoryStmt = $pdo->prepare("
        SELECT id, amount, currency, detail, status, created_at 
        FROM transactions 
        WHERE user_id = ? AND type = 'commission' 
        ORDER BY created_at DESC 
        LIMIT 20
    ");
    $commHistoryStmt->execute([$user['id']]);
    $commHistory = $commHistoryStmt->fetchAll();

    jsonResponse([
        'ref_code' => $user['uid'],
        'commission_rate' => 10,
        'f1_count' => $f1Count,
        'total_commission' => round($totalComm, 4),
        'f1_users' => $f1Users,
        'commissions' => $commHistory
    ]);
}

if ($action === 'logout') {
    session_destroy();
    jsonResponse(['message' => 'Đăng xuất thành công']);
}

jsonResponse(['error' => 'Hành động không hợp lệ'], 400);
