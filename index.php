<?php
// index.php
require_once __DIR__ . '/config/db.php';
$pdo = getDb();
$settings = getSettings($pdo);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>MINEX Cloud Mining - Nền tảng Đào Coin Ảo Thế Hệ Mới (PHP)</title>
  <meta name="description" content="Nền tảng đào coin ảo MINEX, mua máy đào hashrate cao, sinh lời tự động, nạp rút USDT nhanh chóng, minh bạch." />
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
  
  
  <!-- CSS Stylesheet -->
  <link rel="stylesheet" href="assets/css/style.css">
  
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2310b981' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polygon points='12 2 2 7 12 12 22 7 12 2'/><polyline points='2 17 12 22 22 17'/><polyline points='2 12 12 17 22 12'/></svg>">
</head>
<body>

<!-- Floating Simulator Toolbar -->
<div id="iphoneToolbar" class="iphone-toolbar">
  <span class="iphone-badge">📱 iPhone 17 Pro Max</span>
  <button id="btnToggleIphone" class="btn btn-sm btn-primary" onclick="toggleIphoneFrame()">
    Khung iPhone: BẬT
  </button>
  <button class="btn btn-sm btn-secondary scale-btn" data-scale="0.6" onclick="scaleIphone(0.6)">60%</button>
  <button class="btn btn-sm btn-secondary scale-btn" data-scale="0.7" onclick="scaleIphone(0.7)">70%</button>
  <button class="btn btn-sm btn-secondary scale-btn" data-scale="0.8" onclick="scaleIphone(0.8)">80%</button>
  <button class="btn btn-sm btn-secondary scale-btn" data-scale="1.0" onclick="scaleIphone(1.0)">100%</button>
</div>

<!-- Main Device Wrapper -->
<div id="deviceWrapper" class="iphone-mode-active">
  <div id="iphoneScaleContainer" class="iphone-scale-container">
    <!-- iPhone 17 Pro Max Titanium Chassis -->
    <div id="iphoneChassis" class="iphone-chassis">
    <!-- Physical Side Buttons -->
    <div class="iphone-btn-action" title="Action Button"></div>
    <div class="iphone-btn-vol-up" title="Volume Up"></div>
    <div class="iphone-btn-vol-down" title="Volume Down"></div>
    <div class="iphone-btn-power" title="Power"></div>

    <!-- Screen Viewport -->
    <div id="iphoneScreen" class="iphone-screen">
      <!-- 1. Top Fixed Bar: Status Bar & Dynamic Island -->
      <div id="iphoneTopBar" class="iphone-top-bar">
        <!-- iOS Status Bar -->
        <div id="iosStatusBar" class="ios-status-bar">
          <span class="status-time" id="iosTime">00:03</span>
          <div class="status-icons">
            <!-- Signal -->
            <svg width="15" height="11" viewBox="0 0 16 12" fill="currentColor"><rect x="0" y="9" width="2.5" height="3" rx="0.5"/><rect x="4" y="6" width="2.5" height="6" rx="0.5"/><rect x="8" y="3" width="2.5" height="9" rx="0.5"/><rect x="12" y="0" width="2.5" height="12" rx="0.5"/></svg>
            <!-- 5G -->
            <span style="font-size: 0.68rem; font-weight: 800; letter-spacing: -0.05em;">5G</span>
            <!-- Battery -->
            <svg width="22" height="11" viewBox="0 0 22 11" fill="none" stroke="currentColor" stroke-width="1"><rect x="0.5" y="0.5" width="18" height="10" rx="2.5"/><rect x="2" y="2" width="15" height="7" rx="1.5" fill="currentColor"/><path d="M20 3.5v4" stroke-linecap="round"/></svg>
          </div>
        </div>

        <!-- Dynamic Island -->
        <div id="dynamicIsland" class="dynamic-island" title="Dynamic Island (iPhone 17 Pro Max)">
          <div class="island-camera"></div>
          <div class="island-sensor"></div>
        </div>
      </div> <!-- /iphoneTopBar -->

      <!-- 2. Scrollable Middle Area -->
      <div id="iphoneContentScroll" class="iphone-content-scroll">
        <!-- Top Navigation Bar -->
        <!-- Top Navigation Bar (Chuẩn 100% theo ảnh: UID: 120850 + Level 10 pill + Icon quả địa cầu) -->
        <header class="navbar" style="background: #000000 !important; border-bottom: 1px solid rgba(255,255,255,0.06); padding: 14px 18px !important;">
          <div class="navbar-inner" style="display: flex; align-items: center; justify-content: space-between; width: 100%; max-width: 100%; box-sizing: border-box;">
            <!-- Left: UID Text & Level 10 pill badge -->
            <div class="nav-left" style="display: flex; align-items: center; gap: 10px; cursor: pointer;" onclick="switchTab('user')">
              <span class="nav-uid-text" style="font-size: 1.05rem; font-weight: 500; color: #ead9cf !important; letter-spacing: 0.01em; user-select: none;">
                UID: <span class="user-uid-display">120850</span>
              </span>
              <span class="nav-level-badge" style="background: #dfc5b2 !important; color: #1e1b18 !important; font-size: 0.88rem; font-weight: 600; padding: 3px 14px; border-radius: 9999px; line-height: 1.35; letter-spacing: 0.01em; user-select: none;">
                Level 10
              </span>
            </div>

            <!-- Desktop Links (Center) -->
            <ul class="nav-links">
              <li class="nav-item active" data-tab="dashboard" data-i18n="nav_dashboard">Dashboard</li>
              <li class="nav-item" data-tab="store" data-i18n="nav_store">Máy Đào Ảo</li>
              <li class="nav-item" data-tab="wallet" data-i18n="nav_wallet">Ví & Swap</li>
              <li class="nav-item" data-tab="about" data-i18n="nav_about">Giới Thiệu</li>
              <li class="nav-item" data-tab="user" data-i18n="nav_user">User</li>
              <li class="nav-item admin-only" data-tab="admin" data-i18n="nav_admin" style="display:none; color: #fbbf24;">Admin Quản Trị</li>
            </ul>

            <!-- Right: Minimalist World Globe Icon for Language Selector -->
            <div class="nav-actions" style="display: flex; align-items: center;">
              <div class="lang-selector-dropdown" id="langSelector" style="position: relative;">
                <button type="button" class="lang-globe-btn" id="langBtn" onclick="toggleLangDropdown(event)" aria-label="Select Language" title="Chọn ngôn ngữ" style="background: transparent; border: none; padding: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center; outline: none; transition: transform 0.2s;">
                  <!-- Icon quả địa cầu trắng chuẩn theo ảnh -->
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="#ead9cf" style="display: block;">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                  </svg>
                </button>
                <div class="lang-menu" id="langMenu" style="display: none;"></div>
              </div>
            </div>
          </div>
        </header>

  <!-- Toast Container -->
  <div id="toastContainer" style="position: fixed; top: 70px; right: 20px; z-index: 999; max-width: 360px; width: calc(100% - 40px); display: flex; flex-direction: column; gap: 8px;"></div>

  <!-- Main Pages -->
  <main class="main-content">
    
    <!-- ==================== TAB 1: DASHBOARD ==================== -->
    <section id="page-dashboard" class="tab-page">
      <!-- Mining Realtime & Claim Coin Card with 3D Golden Lighting Around Original Coin -->
      <div class="glass-card" id="dashMiningCard" style="padding: 22px 18px; border-radius: 20px; border: 1px solid rgba(245, 158, 11, 0.45); background: #000; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.7), 0 0 35px rgba(245, 158, 11, 0.2); text-align: center; margin-top: 6px;">
        
        <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 14px;">
          <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.4); padding: 5px 14px; border-radius: 20px;">
            <span class="pulse-dot" style="background: #fbbf24; box-shadow: 0 0 10px #fbbf24;"></span>
            <span data-i18n="dash_badge" style="font-size: 0.74rem; font-weight: 700; color: #fbbf24; letter-spacing: 0.05em; text-transform: uppercase;">⚡ KHAI THÁC COIN REALTIME</span>
          </div>
        </div>

        <!-- 3D Golden Lighting Effects Around Untouched Original Coin -->
        <div class="coin-aura-stage">
          <!-- 1. Ambient Golden Flare (Ánh sáng vàng tỏa mềm mại phía sau) -->
          <div class="coin-aura-glow"></div>

          <!-- 2. Rotating Corona Rays (Tia sáng hào quang xoay tròn xung quanh) -->
          <div class="coin-corona-rays"></div>

          <!-- 3. 3D Golden Orbit Ring 1 (Vòng quỹ đạo vàng nghiêng 3D quay quanh coin) -->
          <div class="coin-orbit-ring-1"></div>

          <!-- 4. 3D Golden Orbit Ring 2 (Vòng quỹ đạo vàng nghiêng chéo đối xứng 3D) -->
          <div class="coin-orbit-ring-2"></div>

          <!-- 5. Golden Sparkles (Các điểm lấp lánh ánh kim xung quanh coin) -->
          <div class="coin-sparkle coin-sparkle-1"></div>
          <div class="coin-sparkle coin-sparkle-2"></div>
          <div class="coin-sparkle coin-sparkle-3"></div>
          <div class="coin-sparkle coin-sparkle-4"></div>

          <!-- 6. Golden Coin Image - KHUNG ẢNH TRÒN XUNG QUANH ĐỒNG COIN -->
          <div class="coin-pure-container" id="coinPureContainer">
            <img id="mainCoinImg" src="assets/images/golden_coin_round.png?v=5" alt="SUPPER COIN" class="coin-pure-img">
          </div>

          <!-- 7. Dynamic 3D Drop Shadow Beneath Coin -->
          <div class="coin-ground-shadow"></div>
        </div>

        <div style="margin-bottom: 6px;">
          <span data-i18n="dash_unclaimed" style="font-size: 0.85rem; color: var(--text-muted); display: block; margin-bottom: 4px;">Sản Lượng Tích Luỹ Chưa Nhận</span>
          <div style="display: flex; align-items: baseline; justify-content: center; gap: 8px;">
            <span id="liveCoinCounter" class="counter-digits" style="font-size: 2.6rem; font-weight: 900; color: #fbbf24; font-family: var(--font-mono); text-shadow: 0 0 24px rgba(245, 158, 11, 0.65);">0.000000</span>
            <span class="coin-symbol" style="font-size: 1.15rem; font-weight: 700; color: #fef08a;">MNX</span>
          </div>
        </div>

          <!-- Khối đào coin chuẩn theo ảnh: EDEN / H + JOIN 100× + Đếm ngược + Nút Mining -->
          <div class="mine-panel">
            <div class="mine-rate-row">
              <span id="liveSpeedPerHour" class="mine-rate">0.00 EDEN / H</span>
              <div class="mine-boost">
                <span class="mine-boost-x">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.5 2.5c3.6-.6 6.9.3 8 1.4 1.1 1.1 2 4.4 1.4 8-.5 3-2.3 5.7-5 7.6l.3 2.6-3.4 1.4-1.6-2.9-4.2-4.2-2.9-1.6 1.4-3.4 2.6.3c1.9-2.7 4.6-4.5 7.4-5.2zM16 6.5a1.5 1.5 0 100 3 1.5 1.5 0 000-3zM5.2 15.6l3.2 3.2c-1 1.8-3.1 2.9-6.4 3.2.3-3.3 1.4-5.4 3.2-6.4z"/></svg>100<small>×</small>
                </span>
                <button type="button" class="mine-join-btn" id="btnMineJoin" onclick="switchTab('store')">JOIN</button>
              </div>
            </div>

            <div class="mine-box">
              <button type="button" class="mine-info-btn" id="btnMineInfo" onclick="showMiningInfo()" aria-label="Thông tin đào">i</button>
              <div class="mine-timer">
                <span class="mine-timer-line"></span>
                <span id="claimCountdownText">00H 00M 00S</span>
                <span class="mine-timer-line"></span>
              </div>
              <div id="mineTimerLabel" class="mine-timer-label">Time until next start</div>

              <button id="btnClaimReward" type="button" class="mine-action-btn" onclick="claimReward()">
                <span id="btnClaimText">Mining</span>
              </button>
            </div>

          </div>

        </div>
    </section>

    <!-- ==================== TAB 2: STORE (MÁY ĐÀO - GIAO DIỆN CHUẨN 100% THEO ẢNH) ==================== -->
    <section id="page-store" class="tab-page" style="display: none; width: 100%; max-width: 520px; margin: 0 auto; padding: 0 10px 30px; box-sizing: border-box; overflow-x: hidden;">
      
      <!-- Top Brand Header: Logo EDEN & Quả địa cầu chuẩn theo ảnh 1 -->
      <div class="store-top-header" style="display: flex; align-items: center; justify-content: space-between; padding: 10px 2px 18px;">
        <div style="display: flex; align-items: center; gap: 8px;">
          <!-- Logo tròn E của Eden -->
          <svg width="30" height="30" viewBox="0 0 36 36" fill="none" style="flex-shrink: 0;">
            <circle cx="18" cy="18" r="16.5" stroke="#ead9cf" stroke-width="2"/>
            <path d="M24 12.5C22.8 11.5 21 11 19 11C14.8 11 11.5 14.1 11.5 18C11.5 21.9 14.8 25 19 25C21 25 22.8 24.5 24 23.5" stroke="#ead9cf" stroke-width="2.2" stroke-linecap="round"/>
            <line x1="9.5" y1="16" x2="21" y2="16" stroke="#ead9cf" stroke-width="2.2" stroke-linecap="round"/>
            <line x1="9.5" y1="20" x2="21" y2="20" stroke="#ead9cf" stroke-width="2.2" stroke-linecap="round"/>
          </svg>
          <span style="font-size: 1.25rem; font-weight: 800; color: #ead9cf; letter-spacing: 0.03em;">EDEN</span>
        </div>
        <div>
          <!-- Icon quả địa cầu -->
          <button type="button" class="lang-globe-btn" onclick="toggleLangDropdown(event)" aria-label="Language" style="background: transparent; border: none; padding: 4px; cursor: pointer; display: flex; align-items: center;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="#ead9cf">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- User Profile Banner (chuẩn ảnh 1) -->
      <div class="store-user-banner" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 22px;">
        <div style="display: flex; align-items: center; gap: 14px;">
          <!-- Avatar tròn vòng nguyệt quế + vương miện -->
          <div style="width: 58px; height: 58px; position: relative; flex-shrink: 0; border-radius: 50%; overflow: hidden; background: #0c0d12;">
            <img src="assets/images/user_avatar_wreath.png" alt="Avatar" style="width: 100%; height: 100%; object-fit: contain;">
          </div>
          <!-- Tên, UID và Người giới thiệu -->
          <div>
            <div style="display: flex; align-items: center; gap: 6px; font-size: 1.15rem; font-weight: 700; color: #fff;">
              <span style="color: #eab308; font-size: 0.95rem;">💎</span>
              <span id="storeProfileName" class="user-name-display">evansTi</span>
            </div>
            <div style="font-size: 0.85rem; color: #8a8793; margin-top: 3px; font-family: var(--font-mono);">
              UID: <span class="user-uid-display">120850</span>
            </div>
            <div style="font-size: 0.82rem; color: #8a8793; margin-top: 2px;">
              Invited by (<span id="storeInvitedBy">Dreddinh</span>)
            </div>
          </div>
        </div>

        <!-- 2 Nút cài đặt & thông báo bên phải -->
        <div style="display: flex; align-items: center; gap: 8px;">
          <button type="button" onclick="switchTab('user')" class="store-action-btn" title="Cài đặt">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ead9cf" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="3"></circle>
              <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
            </svg>
          </button>
          <button type="button" onclick="openHistoryModal(event)" class="store-action-btn" title="Lịch sử giao dịch">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ead9cf" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
              <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
          </button>
        </div>
      </div>

      <!-- Tiêu đề: Thiết bị hiện tại -->
      <div style="font-size: 1.15rem; font-weight: 700; color: #fff; margin-bottom: 12px; letter-spacing: -0.01em;">
        Thiết bị hiện tại
      </div>

      <!-- 3 Ô thống kê: cấp bậc, Thời gian làm việc, Tốc độ khai thác -->
      <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 24px;">
        <!-- Ô 1: Cấp bậc (khách mua 10 gói 10 USDT thì lên 1 level) -->
        <div class="store-stat-card">
          <div class="store-stat-icon-wrap">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="#dfc5b2">
              <path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5zm14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z"/>
            </svg>
          </div>
          <div class="store-stat-title">cấp bậc</div>
          <div class="store-stat-value user-level-display">Level 1</div>
        </div>

        <!-- Ô 2: Thời gian làm việc -->
        <div class="store-stat-card">
          <div class="store-stat-icon-wrap">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="#dfc5b2">
              <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm1 14.5h-2V11h2v5.5zm0-7.5h-2V7h2v2z"/>
            </svg>
          </div>
          <div class="store-stat-title">Thời gian làm việc</div>
          <div class="store-stat-value">24H</div>
        </div>

        <!-- Ô 3: Tốc độ khai thác -->
        <div class="store-stat-card">
          <div class="store-stat-icon-wrap">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="#dfc5b2">
              <path d="M14.7 6.3l3.5 3.5-1.4 1.4-3.5-3.5 1.4-1.4zm-4.9 9.9l1.4-1.4 7.1 7.1-1.4 1.4-7.1-7.1zm-7.1 2.1l1.4-1.4 3.5 3.5-1.4 1.4-3.5-3.5zM17.5 3.5l1.4-1.4 3.5 3.5-1.4 1.4-3.5-3.5z"/>
            </svg>
          </div>
          <div class="store-stat-title">Tốc độ khai thác</div>
          <div class="store-stat-value" id="storeSpeedValue">250.000000<br><span style="font-size: 0.65rem; color: #8a8793; font-weight: 500;">EDEN/H</span></div>
        </div>
      </div>

      <!-- 2 Tab Chuyển: SVIP & Nâng cấp -->
      <div style="display: flex; gap: 8px; margin-bottom: 0;">
        <button type="button" id="tabBtnSVIP" class="store-tab-btn active" onclick="switchStoreSubTab('svip')">
          <span>SVIP</span>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="8" y1="8" x2="16" y2="8"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="8" y1="16" x2="16" y2="16"/></svg>
        </button>
        <button type="button" id="tabBtnUpgrade" class="store-tab-btn" onclick="switchStoreSubTab('upgrade')">
          <span>Nâng cấp</span>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="8" y1="8" x2="16" y2="8"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="8" y1="16" x2="16" y2="16"/></svg>
        </button>
      </div>

      <!-- Khung Nội Dung Gói Đào SVIP (Chuẩn 100% Ảnh 1) -->
      <div id="storeContentSVIP" class="store-card-container">
        <!-- Khối thông tin gói -->
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 22px;">
          <!-- Ảnh chip máy đào SVIP -->
          <div style="width: 86px; height: 86px; border-radius: 14px; overflow: hidden; background: #000; flex-shrink: 0; border: 1px solid rgba(255,255,255,0.08);">
            <img src="assets/images/svip_chip_clean.png" alt="SVIP Chip" style="width: 100%; height: 100%; object-fit: cover;">
          </div>
          <!-- Thông số gói SVIP -->
          <div style="flex: 1; min-width: 0;">
            <div style="display: flex; align-items: center; gap: 6px; font-size: 1.15rem; font-weight: 700; color: #fff; margin-bottom: 8px;">
              <span style="color: #eab308; font-size: 0.95rem;">💎</span>
              <span>SVIP</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.88rem; margin-bottom: 5px;">
              <span style="color: #8a8793;">Daily Output</span>
              <span style="color: #fff; font-weight: 600; font-family: var(--font-mono);">6000 EDEN</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.88rem;">
              <span style="color: #8a8793;">Price</span>
              <span style="color: #fff; font-weight: 600; font-family: var(--font-mono);">10 USDT</span>
            </div>
          </div>
        </div>

        <!-- Nút Mua sắm (hồng phấn/be sang trọng #ead1bf) -->
        <button type="button" class="btn-store-buy" onclick="openSvipBuyModal('miner_svip')">
          Mua sắm
        </button>
      </div>

      <!-- Khung Nội Dung Gói Đào Nâng Cấp -->
      <div id="storeContentUpgrade" class="store-card-container" style="display: none;">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 22px;">
          <div style="width: 86px; height: 86px; border-radius: 14px; overflow: hidden; background: #000; flex-shrink: 0; border: 1px solid rgba(255,255,255,0.08);">
            <img src="assets/images/svip_chip_clean.png" alt="SVIP Pro" style="width: 100%; height: 100%; object-fit: cover; filter: hue-rotate(45deg);">
          </div>
          <div style="flex: 1; min-width: 0;">
            <div style="display: flex; align-items: center; gap: 6px; font-size: 1.15rem; font-weight: 700; color: #fff; margin-bottom: 8px;">
              <span style="color: #38bdf8; font-size: 0.95rem;">💎</span>
              <span>SVIP Pro (Nâng Cấp)</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.88rem; margin-bottom: 5px;">
              <span style="color: #8a8793;">Daily Output</span>
              <span style="color: #fff; font-weight: 600; font-family: var(--font-mono);">30000 EDEN</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.88rem;">
              <span style="color: #8a8793;">Price</span>
              <span style="color: #fff; font-weight: 600; font-family: var(--font-mono);">50 USDT</span>
            </div>
          </div>
        </div>

        <button type="button" class="btn-store-buy" onclick="openSvipBuyModal('miner_upgrade')">
          Mua sắm
        </button>
      </div>

      <!-- Danh sách gói phụ (nếu có thêm gói) -->
      <div id="storeMinersGrid" style="display: none;"></div>

    </section>

    <!-- ==================== TAB 3: WALLET & SWAP (VÍ TIỀN & MUA LẠI CHUẨN ẢNH) ==================== -->
    <section id="page-wallet" class="tab-page" style="display: none; width: 100%; max-width: 540px; margin: 0 auto; padding-bottom: 30px; box-sizing: border-box; overflow-x: hidden;">
      
      <!-- 1. MÀN HÌNH CHÍNH: VÍ TIỀN (CHUẨN 100% THEO ẢNH NGƯỜI DÙNG CUNG CẤP) -->
      <div id="userWalletMainView" style="display: flex; flex-direction: column; width: 100%;">
        
        <!-- Tiêu đề: Ví tiền -->
        <h1 class="wallet-title" style="font-size: 1.85rem; font-weight: 700; text-align: center; margin: 12px 0 22px; color: #ead9cf !important; letter-spacing: -0.01em;">
          Ví tiền
        </h1>

        <!-- Khối Số Dư Lớn: (E) 1555.582095 EDEN -->
        <div style="text-align: center; margin-bottom: 32px;">
          <div class="wallet-main-balance" style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; font-size: 1.85rem; font-weight: 700; color: #ead9cf !important; letter-spacing: -0.01em;">
            <!-- Biểu tượng đồng tiền tròn chữ E (Euro/Eden symbol) -->
            <svg width="34" height="34" viewBox="0 0 36 36" fill="none" style="flex-shrink: 0;">
              <circle cx="18" cy="18" r="16.5" stroke="#ead9cf" stroke-width="2"/>
              <path d="M24 12.5C22.8 11.5 21 11 19 11C14.8 11 11.5 14.1 11.5 18C11.5 21.9 14.8 25 19 25C21 25 22.8 24.5 24 23.5" stroke="#ead9cf" stroke-width="2.2" stroke-linecap="round"/>
              <line x1="9.5" y1="16" x2="21" y2="16" stroke="#ead9cf" stroke-width="2.2" stroke-linecap="round"/>
              <line x1="9.5" y1="20" x2="21" y2="20" stroke="#ead9cf" stroke-width="2.2" stroke-linecap="round"/>
            </svg>
            <span class="user-coin-balance" style="font-weight: 700; color: #ead9cf !important;">1555.582095</span>
            <span class="coin-symbol" style="font-weight: 700; color: #ead9cf !important;">EDEN</span>
          </div>
          <!-- Quy đổi tương đương sang USDT -->
          <div class="wallet-sub-equiv" style="margin-top: 6px; font-size: 0.86rem; color: #7c7a82 !important; text-align: center;">
            ≈<span id="userPageEquivUsdt" style="color: #7c7a82 !important;">0.155558</span> USDT
          </div>
        </div>

        <!-- Bốn Nút Tròn Thao Tác: Hóa đơn, tạm thay đổi, Mua lại, lời hứa -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 30px; text-align: center;">
          
          <!-- Nút 1: Hóa đơn -->
          <div onclick="openHistoryModal(event)" style="cursor: pointer; display: flex; flex-direction: column; align-items: center;">
            <div class="action-btn-circle" style="width: 58px; height: 58px; border-radius: 50%; border: 1.5px solid rgba(234, 217, 207, 0.32); background: rgba(255, 255, 255, 0.02); display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ead9cf" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="4" y="3" width="16" height="18" rx="2"/>
                <line x1="8" y1="8" x2="16" y2="8"/>
                <line x1="8" y1="12" x2="16" y2="12"/>
                <line x1="8" y1="16" x2="12" y2="16"/>
              </svg>
            </div>
            <span class="action-btn-label" style="font-size: 0.85rem; font-weight: 500; color: #ead9cf !important; margin-top: 8px;">Hóa đơn</span>
          </div>

          <!-- Nút 2: tạm thay đổi (Mở khu vực Hoán đổi & Nạp) -->
          <div onclick="toggleWalletSwapPanel('swap')" style="cursor: pointer; display: flex; flex-direction: column; align-items: center;">
            <div class="action-btn-circle" style="width: 58px; height: 58px; border-radius: 50%; border: 1.5px solid rgba(234, 217, 207, 0.32); background: rgba(255, 255, 255, 0.02); display: flex; align-items: center; justify-content: center; position: relative; transition: all 0.2s;">
              <span class="badge-new" style="position: absolute; top: -6px; right: -4px; border: 1px solid rgba(211, 184, 166, 0.7); background: #000; color: #d3b8a6 !important; border-radius: 10px; font-size: 0.62rem; font-weight: 700; padding: 1px 6px; line-height: 1.2;">new</span>
              <svg width="24" height="24" viewBox="0 0 24 24" fill="#ead9cf" stroke="#ead9cf" stroke-width="1">
                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
              </svg>
            </div>
            <span class="action-btn-label" style="font-size: 0.82rem; font-weight: 500; color: #ead9cf !important; margin-top: 8px; line-height: 1.25; text-align: center;">tạm thay<br>đổi</span>
          </div>

          <!-- Nút 3: Mua lại (Mở màn hình Mua lại chuẩn ảnh) -->
          <div onclick="openBuybackView()" style="cursor: pointer; display: flex; flex-direction: column; align-items: center;">
            <div class="action-btn-circle" style="width: 58px; height: 58px; border-radius: 50%; border: 1.5px solid rgba(234, 217, 207, 0.32); background: rgba(255, 255, 255, 0.02); display: flex; align-items: center; justify-content: center; position: relative; transition: all 0.2s;">
              <span class="badge-new" style="position: absolute; top: -6px; right: -4px; border: 1px solid rgba(211, 184, 166, 0.7); background: #000; color: #d3b8a6 !important; border-radius: 10px; font-size: 0.62rem; font-weight: 700; padding: 1px 6px; line-height: 1.2;">new</span>
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ead9cf" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                <path d="M16 3H8a2 2 0 0 0-2 2v2h12V5a2 2 0 0 0-2-2z"/>
                <circle cx="15.5" cy="13.5" r="1.5" fill="#ead9cf"/>
              </svg>
            </div>
            <span class="action-btn-label" style="font-size: 0.85rem; font-weight: 500; color: #ead9cf !important; margin-top: 8px;">Mua lại</span>
          </div>

          <!-- Nút 4: lời hứa -->
          <div onclick="openTermsModal(event)" style="cursor: pointer; display: flex; flex-direction: column; align-items: center;">
            <div class="action-btn-circle" style="width: 58px; height: 58px; border-radius: 50%; border: 1.5px solid rgba(234, 217, 207, 0.32); background: rgba(255, 255, 255, 0.02); display: flex; align-items: center; justify-content: center; position: relative; transition: all 0.2s;">
              <span class="badge-new" style="position: absolute; top: -6px; right: -4px; border: 1px solid rgba(211, 184, 166, 0.7); background: #000; color: #d3b8a6 !important; border-radius: 10px; font-size: 0.62rem; font-weight: 700; padding: 1px 6px; line-height: 1.2;">new</span>
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ead9cf" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="12 2 2 7 12 12 22 7 12 2"/>
                <polyline points="2 17 12 22 22 17"/>
                <polyline points="2 12 12 17 22 12"/>
              </svg>
            </div>
            <span class="action-btn-label" style="font-size: 0.85rem; font-weight: 500; color: #ead9cf !important; margin-top: 8px;">lời hứa</span>
          </div>

        </div>

        <!-- Đường Kẻ Phân Cách & Mục "Số dư" -->
        <div class="wallet-divider" style="border-top: 1px solid rgba(255,255,255,0.08); margin-top: 10px;"></div>
        <div class="wallet-section-title" style="text-align: center; padding: 14px 0; font-size: 1.05rem; font-weight: 600; color: #ead9cf !important; letter-spacing: 0.01em;">
          Số dư
        </div>
        <div class="wallet-divider" style="border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 10px;"></div>

        <!-- Danh Sách Tài Sản (EDEN & USDT) -->
        <div style="display: flex; flex-direction: column;">
          
          <!-- Hàng 1: EDEN -->
          <div onclick="toggleWalletSwapPanel('swap')" style="display: flex; align-items: center; justify-content: space-between; padding: 18px 4px; border-bottom: 1px solid rgba(255,255,255,0.05); cursor: pointer;">
            <div style="display: flex; align-items: center; gap: 14px;">
              <svg width="34" height="34" viewBox="0 0 36 36" fill="none" style="flex-shrink: 0;">
                <circle cx="18" cy="18" r="16.5" stroke="#ead9cf" stroke-width="2"/>
                <path d="M24 12.5C22.8 11.5 21 11 19 11C14.8 11 11.5 14.1 11.5 18C11.5 21.9 14.8 25 19 25C21 25 22.8 24.5 24 23.5" stroke="#ead9cf" stroke-width="2.2" stroke-linecap="round"/>
                <line x1="9.5" y1="16" x2="21" y2="16" stroke="#ead9cf" stroke-width="2.2" stroke-linecap="round"/>
                <line x1="9.5" y1="20" x2="21" y2="20" stroke="#ead9cf" stroke-width="2.2" stroke-linecap="round"/>
              </svg>
              <span class="asset-name coin-symbol" style="font-size: 1.15rem; font-weight: 700; color: #ead9cf !important; letter-spacing: 0.02em;">EDEN</span>
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
              <span class="asset-amount user-coin-balance" style="font-size: 1.15rem; font-weight: 600; color: #ead9cf !important; font-family: var(--font-mono);">1555.582095</span>
              <svg class="asset-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#5b595e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"/>
              </svg>
            </div>
          </div>

          <!-- Hàng 2: USDT -->
          <div onclick="openBuybackView()" style="display: flex; align-items: center; justify-content: space-between; padding: 18px 4px; border-bottom: 1px solid rgba(255,255,255,0.05); cursor: pointer;">
            <div style="display: flex; align-items: center; gap: 14px;">
              <img src="assets/usdt.png" alt="USDT" style="width: 34px; height: 34px; border-radius: 50%; object-fit: contain; flex-shrink: 0; box-shadow: 0 0 8px rgba(38,161,123,0.5);">
              <span class="asset-name" style="font-size: 1.15rem; font-weight: 700; color: #ead9cf !important; letter-spacing: 0.02em;">USDT</span>
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
              <span class="asset-amount user-usdt-balance" style="font-size: 1.15rem; font-weight: 600; color: #ead9cf !important; font-family: var(--font-mono);">22539.62</span>
              <svg class="asset-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#5b595e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"/>
              </svg>
            </div>
          </div>

        </div>

        <!-- Khối Mở Rộng: Hoán Đổi & Nạp USDT (Khi người dùng bấm tạm thay đổi hoặc hàng tài sản) -->
        <div id="walletExtraPanel" style="display: none; margin-top: 24px; padding-top: 20px; border-top: 1px dashed rgba(255,255,255,0.12);">
          <!-- Nút điều hướng các chức năng nạp/đổi -->
          <div style="display: flex; gap: 8px; margin-bottom: 16px;">
            <button id="walletNavBtn-swap" type="button" class="btn btn-primary btn-sm wallet-nav-btn active" onclick="switchWalletTab('swap')" style="flex: 1;">
              🔄 Hoán Đổi EDEN
            </button>
            <button id="walletNavBtn-deposit" type="button" class="btn btn-secondary btn-sm wallet-nav-btn" onclick="switchWalletTab('deposit')" style="flex: 1;">
              📥 Nạp USDT
            </button>
            <button id="walletNavBtn-withdraw" type="button" class="btn btn-secondary btn-sm wallet-nav-btn" onclick="switchWalletTab('withdraw')" style="flex: 1;">
              📤 Rút USDT
            </button>
          </div>

          <!-- TAB: HOÁN ĐỔI SWAP -->
          <div id="walletTab-swap" class="wallet-subtab glass-card" style="padding: 18px 16px; border-radius: 16px;">
            <h3 data-i18n="wallet_swap_title" style="font-size: 1.15rem; font-weight: 700; margin-bottom: 6px; color: #ead9cf;">Hoán Đổi Coin Sang USDT</h3>
            <p data-i18n="wallet_swap_desc" style="color: #8e8c94; font-size: 0.84rem; margin-bottom: 16px;">Quy đổi ngay lập tức sản lượng EDEN thành USDT để rút về hoặc mua thêm máy.</p>

            <form id="swapForm">
              <div class="form-group">
                <div style="display: flex; justify-content: space-between; font-size: 0.82rem; margin-bottom: 4px;">
                  <label class="form-label" data-i18n="wallet_swap_amt_label">Số lượng Coin muốn đổi</label>
                  <span><span data-i18n="wallet_swap_avail">Khả dụng:</span> <strong style="color: #fbbf24;" class="user-coin-balance">0.00</strong></span>
                </div>
                <input type="number" step="any" id="swapCoinAmount" class="form-input" value="20" oninput="updateSwapPreview()" required style="background: #000;">
                <div style="display: flex; gap: 6px; margin-top: 6px;">
                  <button type="button" class="btn btn-secondary btn-sm" style="flex: 1; padding: 4px;" onclick="setSwapPercent(0.25)">25%</button>
                  <button type="button" class="btn btn-secondary btn-sm" style="flex: 1; padding: 4px;" onclick="setSwapPercent(0.5)">50%</button>
                  <button type="button" class="btn btn-secondary btn-sm" style="flex: 1; padding: 4px;" onclick="setSwapPercent(0.75)">75%</button>
                  <button type="button" class="btn btn-secondary btn-sm" style="flex: 1; padding: 4px;" onclick="setSwapPercent(1.0)">100% (MAX)</button>
                </div>
              </div>

              <div style="background: #000; padding: 12px 14px; border-radius: var(--radius-sm); border: 1px dashed rgba(255,255,255,0.12); margin: 14px 0;">
                <div style="display: flex; justify-content: space-between; font-size: 0.82rem; margin-bottom: 4px;">
                  <span style="color: #8e8c94;" data-i18n="wallet_swap_rate_label">Tỷ giá quy đổi:</span>
                  <span id="walletSwapRate" style="font-family: var(--font-mono); color: #ead9cf;">1 EDEN = $0.001 USDT</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                  <span style="color: #8e8c94;" data-i18n="wallet_swap_receive_label">Bạn nhận được:</span>
                  <strong style="color: #fbbf24; font-size: 1.3rem; font-family: var(--font-mono);" id="swapUsdtPreview">+0.00 USDT</strong>
                </div>
              </div>

              <button type="submit" class="btn btn-primary" style="width: 100%; height: 44px; font-weight: 700;" data-i18n="wallet_swap_btn">Đổi Ngay Sang USDT</button>
            </form>
          </div>

          <!-- TAB: NẠP USDT -->
          <div id="walletTab-deposit" class="wallet-subtab glass-card" style="display: none; padding: 18px 16px; border-radius: 16px;">
            <h3 data-i18n="wallet_dep_title" style="font-size: 1.15rem; font-weight: 700; margin-bottom: 6px; color: #ead9cf;">Nạp USDT Vào Hệ Thống</h3>
            <p data-i18n="wallet_dep_desc" style="color: #8e8c94; font-size: 0.84rem; margin-bottom: 16px;">Chuyển USDT đến địa chỉ ví dưới đây, sau đó gửi số tiền và mã TxHash để Admin phê duyệt.</p>

            <div style="background: #000; padding: 16px; border-radius: var(--radius-sm); border: 1px solid var(--border-subtle); text-align: center; margin-bottom: 14px;">
              <div style="display: inline-block; padding: 10px; background: #fff; border-radius: 10px; margin-bottom: 10px;">
                <svg width="100" height="100" viewBox="0 0 24 24" fill="#000">
                  <path d="M2 2h8v8H2zM4 4v4h4V4zm10-2h8v8h-8zM16 4v4h4V4zM2 14h8v8H2zm2 2v4h4v-4zm10 0h3v3h-3zm5 0h3v3h-3zm-5 5h3v3h-3zm5 0h3v3h-3zM10 4h4v2h-4zm0 6h4v2h-4zm6 0h4v2h-4z"/>
                </svg>
              </div>
              <div style="font-size: 0.8rem; color: #8e8c94; margin-bottom: 6px;">
                <span data-i18n="wallet_dep_network_label">Mạng lưới:</span> <strong style="color: #fbbf24;" id="walletDepositNetwork">USDT (TRC20)</strong>
              </div>
              <div style="background: #000; border: 1px solid rgba(255,255,255,0.12); padding: 8px 10px; border-radius: 6px; font-family: var(--font-mono); font-size: 0.82rem; word-break: break-all; color: #ead9cf;">
                <span id="walletDepositAddress"><?= htmlspecialchars($settings['usdt_deposit_address']) ?></span>
              </div>
              <button class="btn btn-secondary btn-sm" style="margin-top: 10px; width: 100%;" onclick="copyDepositAddress()" data-i18n="wallet_dep_copy_btn">Sao Chép Địa Chỉ Ví</button>
            </div>

            <!-- Deposit Form -->
            <form id="depositForm">
              <div class="form-group" style="margin-bottom: 12px;">
                <label class="form-label" style="font-size: 0.82rem;"><span data-i18n="wallet_dep_amt_label">Số lượng USDT muốn nạp</span> (<span data-i18n="wallet_dep_min_label">Tối thiểu:</span> <span id="walletMinDeposit">$10 USDT</span>)</label>
                <input type="number" step="any" min="10" id="depAmount" class="form-input" value="50" required style="background: #000;">
              </div>
              <div class="form-group" style="margin-bottom: 12px;">
                <label class="form-label" data-i18n="wallet_dep_tx_label" style="font-size: 0.82rem;">Mã băm giao dịch (TxHash / Transaction ID)</label>
                <input type="text" id="depTxHash" class="form-input" data-i18n-placeholder="wallet_dep_tx_placeholder" placeholder="Dán mã giao dịch hoặc để trống để tạo tự động" style="background: #000;">
              </div>
              <button type="submit" class="btn btn-primary" style="width: 100%; height: 44px; font-weight: 700;" data-i18n="wallet_dep_btn">Xác Nhận Đã Chuyển Tiền</button>
            </form>
          </div>

          <!-- TAB: RÚT USDT -->
          <div id="walletTab-withdraw" class="wallet-subtab glass-card" style="display: none; padding: 18px 16px; border-radius: 16px;">
            <h3 data-i18n="wallet_wd_title" style="font-size: 1.15rem; font-weight: 700; margin-bottom: 6px; color: #ead9cf;">Rút USDT Về Ví Cá Nhân</h3>
            <p style="color: #8e8c94; font-size: 0.84rem; margin-bottom: 14px;"><span data-i18n="wallet_wd_desc">Lệnh rút sẽ được gửi đến hàng đợi xét duyệt. Phí rút cố định</span> <span id="walletWithdrawFee">2.5%</span>.</p>

            <form id="withdrawForm">
              <div class="form-group" style="margin-bottom: 12px;">
                <label class="form-label" data-i18n="wallet_wd_addr_label" style="font-size: 0.82rem;">Địa chỉ ví USDT nhận tiền (TRC20)</label>
                <input type="text" id="wdAddress" class="form-input" placeholder="Nhập địa chỉ ví USDT..." required style="background: #000;">
              </div>

              <div class="form-group" style="margin-bottom: 14px;">
                <div style="display: flex; justify-content: space-between; font-size: 0.82rem; margin-bottom: 4px;">
                  <label class="form-label"><span data-i18n="wallet_wd_amt_label">Số lượng rút</span> (<span data-i18n="wallet_dep_min_label">Tối thiểu:</span> <span id="walletMinWithdraw">$15 USDT</span>)</label>
                  <span>Khả dụng: <strong style="color: #fbbf24;" class="user-usdt-balance">0.00</strong> USDT</span>
                </div>
                <input type="number" step="any" id="wdAmount" class="form-input" value="20" min="15" required style="background: #000;">
              </div>

              <button type="submit" class="btn btn-primary" style="width: 100%; height: 44px; font-weight: 700;" data-i18n="wallet_wd_btn">Xác Nhận Yêu Cầu Rút USDT</button>
            </form>
          </div>

        </div>

      </div> <!-- /userWalletMainView -->

      <!-- 2. MÀN HÌNH MUA LẠI (CHUẨN 100% THEO ẢNH NGƯỜI DÙNG CUNG CẤP) -->
      <div id="userBuybackView" style="display: none; flex-direction: column; width: 100%;">
        
        <!-- Thanh điều hướng trên cùng: Nút quay lại & Tiêu đề "Mua lại" -->
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;">
          <button type="button" onclick="closeBuybackView()" style="width: 44px; height: 44px; border-radius: 12px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ead9cf" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
              <line x1="19" y1="12" x2="5" y2="12"/>
              <polyline points="12 19 5 12 12 5"/>
            </svg>
          </button>
          <h2 style="font-size: 1.25rem; font-weight: 700; color: #ead9cf !important; margin: 0; text-align: center; flex: 1;">
            Mua lại
          </h2>
          <div style="width: 44px;"></div>
        </div>

        <!-- Khung thẻ chính bo góc viền cam/hồng phấn nhẹ -->
        <div style="background: #000; border: 1.5px solid rgba(255, 200, 180, 0.22); border-radius: 18px; padding: 20px 16px; box-sizing: border-box;">
          
          <!-- Đầu thẻ: Logo EDEN & Nút Lịch sử giao dịch -->
          <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
            <div style="display: flex; align-items: center; gap: 8px;">
              <svg width="26" height="26" viewBox="0 0 36 36" fill="none" style="flex-shrink: 0;">
                <circle cx="18" cy="18" r="16.5" stroke="#ead9cf" stroke-width="2"/>
                <path d="M24 12.5C22.8 11.5 21 11 19 11C14.8 11 11.5 14.1 11.5 18C11.5 21.9 14.8 25 19 25C21 25 22.8 24.5 24 23.5" stroke="#ead9cf" stroke-width="2.2" stroke-linecap="round"/>
                <line x1="9.5" y1="16" x2="21" y2="16" stroke="#ead9cf" stroke-width="2.2" stroke-linecap="round"/>
                <line x1="9.5" y1="20" x2="21" y2="20" stroke="#ead9cf" stroke-width="2.2" stroke-linecap="round"/>
              </svg>
              <span style="font-size: 1.05rem; font-weight: 800; color: #ead9cf !important;" class="coin-symbol">EDEN</span>
            </div>
            <button type="button" onclick="openHistoryModal(event)" style="border: 1px solid rgba(255,255,255,0.25); background: transparent; border-radius: 20px; padding: 4px 14px; font-size: 0.8rem; font-weight: 500; color: #ead9cf !important; cursor: pointer; transition: all 0.2s;">
              Lịch sử giao dịch
            </button>
          </div>

          <!-- Khối Sự cân bằng (Số dư USDT khả dụng) -->
          <div style="background: #000; border: 1px solid rgba(255,255,255,0.12); border-radius: 14px; padding: 16px; margin-bottom: 16px;">
            <div style="font-size: 0.84rem; color: #9c9aa2 !important; margin-bottom: 6px;">Sự cân bằng</div>
            <div style="font-size: 1.65rem; font-weight: 800; color: #ead9cf !important; font-family: var(--font-mono); display: flex; align-items: baseline; gap: 8px;">
              <span class="user-usdt-balance" id="buybackBalanceDisplay">22539.62</span>
              <span style="font-size: 1.05rem; font-weight: 700; color: #ead9cf !important;">USDT</span>
            </div>
          </div>

          <!-- Ô 1: Địa chỉ ví -->
          <div style="border: 1px solid rgba(255,255,255,0.16); border-radius: 10px; padding: 10px 14px; margin-bottom: 12px; background: #000;">
            <div style="font-size: 0.8rem; color: #7c7a82 !important; margin-bottom: 4px;">Địa chỉ ví:</div>
            <input type="text" id="buybackAddressInput" value="0xd90e17f8a8a6c0b749028b23828e7c188652ebbc" style="background: transparent; border: none; outline: none; width: 100%; color: #ead9cf !important; font-family: var(--font-mono); font-size: 0.84rem; word-break: break-all; padding: 0;">
          </div>

          <!-- Ô 2: Số tiền rút -->
          <div style="border: 1px solid rgba(255,255,255,0.16); border-radius: 10px; padding: 12px 14px; margin-bottom: 12px; background: #000; display: flex; align-items: center; justify-content: space-between;">
            <input type="number" id="buybackAmountInput" step="any" placeholder="Số tiền rút" style="background: transparent; border: none; outline: none; flex: 1; color: #ead9cf !important; font-size: 0.95rem; padding: 0;">
            <span style="font-weight: 700; color: #ead9cf !important; font-size: 0.92rem; margin-left: 8px;">USDT</span>
          </div>

          <!-- Ô 3: Tiền tệ ghi có -->
          <div style="border: 1px solid rgba(255,255,255,0.16); border-radius: 10px; padding: 12px 14px; margin-bottom: 14px; background: #000;">
            <div style="font-size: 0.8rem; color: #7c7a82 !important; margin-bottom: 8px;">Tiền tệ ghi có:</div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
              <div style="width: 20px; height: 20px; border-radius: 50%; background: #ceb09b; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#121116" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="20 6 9 17 4 12"/>
                </svg>
              </div>
              <span style="font-weight: 700; color: #ead9cf !important; font-size: 0.95rem;">USDT</span>
            </div>
            <div style="font-size: 0.78rem; color: #7c7a82 !important;">Phí xử lý:1USDT</div>
          </div>

          <!-- Dòng 2FA thông báo & Ô nhập mã xác minh 6 chữ số -->
          <div style="display: flex; align-items: flex-start; gap: 6px; margin-bottom: 8px; font-size: 0.78rem; color: #7c7a82 !important; line-height: 1.4;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#7c7a82" stroke-width="2" style="flex-shrink: 0; margin-top: 1px;">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            <span>Vui lòng nhập mã xác minh 6 chữ số được tạo ra bởi ứng dụng xác thực.:</span>
          </div>
          <div style="border: 1px solid rgba(255,255,255,0.16); border-radius: 10px; padding: 12px 14px; margin-bottom: 22px; background: #000;">
            <input type="text" id="buyback2faInput" placeholder="Mã xác minh 6 chữ số" maxlength="6" style="background: transparent; border: none; outline: none; width: 100%; color: #ead9cf !important; font-size: 0.92rem; padding: 0;">
          </div>

          <!-- Nút gửi Mua lại màu cam kem ấm đúng chuẩn ảnh -->
          <button type="button" id="btnSubmitBuyback" onclick="submitBuyback()" style="width: 100%; height: 50px; background: #ceb09b !important; color: #18171c !important; border: none; border-radius: 12px; font-size: 1.05rem; font-weight: 700; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; text-shadow: none !important;">
            Mua lại
          </button>

        </div>

      </div>

    </section>

    <!-- ==================== TAB 4: ABOUT & REFERRAL (GIỚI THIỆU & HOA HỒNG TUYẾN TRÊN) ==================== -->
    <section id="page-about" class="tab-page" style="display: none; width: 100%; max-width: 860px; margin: 0 auto; padding-bottom: 30px; box-sizing: border-box; overflow-x: hidden;">
      <!-- Hero Header -->
      <div style="text-align: center; margin-bottom: 24px;">
        <div style="display: inline-flex; align-items: center; gap: 8px; padding: 6px 14px; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 30px; margin-bottom: 12px;">
          <span style="width: 8px; height: 8px; border-radius: 50%; background: #fbbf24; box-shadow: 0 0 8px #fbbf24;"></span>
          <span data-i18n="ref_hero_badge" style="font-size: 0.74rem; font-weight: 700; color: #fbbf24; letter-spacing: 0.05em; text-transform: uppercase;">🎁 CHƯƠNG TRÌNH HOA HỒNG GIỚI THIỆU ĐỐI TÁC</span>
        </div>
        <h1 data-i18n="ref_main_title" style="font-size: 1.85rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 8px;">Giới Thiệu Tuyến Trên - Nhận 10% Hoa Hồng</h1>
        <p data-i18n="ref_main_subtitle" style="color: var(--text-muted); font-size: 0.92rem; max-width: 650px; margin: 0 auto; line-height: 1.6;">
          Khi khách hàng <strong style="color: #fbbf24;">F1</strong> mua bất kỳ gói máy đào nào, người giới thiệu (<strong style="color: #38bdf8;">tuyến trên</strong>) sẽ nhận ngay <strong style="color: #34d399; font-size: 1.05rem;">10%</strong> giá trị gói bằng USDT về ví tức thì!
        </p>
      </div>

      <!-- Card: Liên Kết & Mã Giới Thiệu Của Bạn -->
      <div class="glass-card" style="padding: 22px 18px; border-radius: 18px; margin-bottom: 24px; border: 1px solid rgba(245, 158, 11, 0.3); background: #000; box-shadow: 0 10px 30px rgba(0,0,0,0.5); box-sizing: border-box; width: 100%;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; flex-wrap: wrap; gap: 8px;">
          <h3 style="font-size: 1.15rem; font-weight: 800; margin: 0; display: flex; align-items: center; gap: 8px; color: #fff;">
            <span>🔗</span> <span data-i18n="ref_card_title">Liên Kết & Mã Giới Thiệu Của Bạn</span>
          </h3>
          <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
            <span style="font-size: 0.82rem; color: var(--text-muted);" data-i18n="ref_my_code">Mã UID:</span>
            <span class="badge" style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; font-family: var(--font-mono); font-size: 0.95rem; font-weight: 800; padding: 4px 10px; border-radius: 10px; border: 1px solid rgba(245, 158, 11, 0.4);" id="refMyUidDisplay">120850</span>
            <button type="button" class="btn btn-secondary btn-sm" onclick="copyReferralCode()" style="padding: 4px 10px; font-size: 0.78rem;" data-i18n="ref_copy_code_btn">Sao Chép Mã</button>
          </div>
        </div>

        <!-- Referral Link Copy Box -->
        <div style="margin-bottom: 12px; width: 100%;">
          <label class="form-label" style="font-size: 0.82rem; margin-bottom: 6px; color: var(--text-muted);" data-i18n="ref_link_label">Đường dẫn giới thiệu trực tiếp (Referral Link)</label>
          <div style="display: flex; gap: 8px; flex-wrap: wrap; width: 100%; box-sizing: border-box;">
            <input type="text" id="refMyLinkInput" readonly class="form-input" style="flex: 1; min-width: 140px; font-family: var(--font-mono); font-size: 0.82rem; color: #38bdf8; background: #000; border-color: rgba(255,255,255,0.12);" value="http://localhost:8000/?ref=120850">
            <button type="button" class="btn btn-primary" onclick="copyReferralLink()" style="padding: 0 16px; font-weight: 700; font-size: 0.86rem; white-space: nowrap; border-radius: 10px; flex-shrink: 0;" data-i18n="ref_copy_link_btn">
              📋 Sao Chép Link
            </button>
          </div>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.8rem; color: var(--text-muted); flex-wrap: wrap; gap: 8px;">
          <span>💡 <span data-i18n="ref_hint">Chia sẻ link này cho bạn bè, hội nhóm crypto. Khi họ đăng ký và mua máy đào, bạn nhận ngay 10% hoa hồng!</span></span>
          <button type="button" class="btn btn-secondary btn-sm" onclick="shareReferralLink()" style="font-size: 0.78rem; padding: 3px 10px;" data-i18n="ref_share_btn">📤 Chia Sẻ</button>
        </div>
      </div>

      <!-- 4 Highlight Stats Tuyến Dưới -->
      <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 24px;" class="ref-stats-grid">
        <div class="glass-card" style="padding: 14px; text-align: center; border-radius: 14px; border: 1px solid rgba(255,255,255,0.08);">
          <div style="font-size: 1.55rem; font-weight: 800; color: #38bdf8; font-family: var(--font-mono);" id="refStatsF1Count">0</div>
          <div data-i18n="ref_stat_f1_count" style="font-size: 0.72rem; color: var(--text-muted); margin-top: 4px; text-transform: uppercase; font-weight: 600;">Thành Viên F1</div>
        </div>
        <div class="glass-card" style="padding: 14px; text-align: center; border-radius: 14px; border: 1px solid rgba(255,255,255,0.08);">
          <div style="font-size: 1.55rem; font-weight: 800; color: #fbbf24; font-family: var(--font-mono);">10%</div>
          <div data-i18n="ref_stat_rate" style="font-size: 0.72rem; color: var(--text-muted); margin-top: 4px; text-transform: uppercase; font-weight: 600;">Hoa Hồng Tuyến Trên</div>
        </div>
        <div class="glass-card" style="padding: 14px; text-align: center; border-radius: 14px; border: 1px solid rgba(255,255,255,0.08);">
          <div style="font-size: 1.55rem; font-weight: 800; color: #34d399; font-family: var(--font-mono);" id="refStatsTotalComm">$0.00</div>
          <div data-i18n="ref_stat_total_comm" style="font-size: 0.72rem; color: var(--text-muted); margin-top: 4px; text-transform: uppercase; font-weight: 600;">Hoa Hồng Đã Nhận</div>
        </div>
        <div class="glass-card" style="padding: 14px; text-align: center; border-radius: 14px; border: 1px solid rgba(255,255,255,0.08);">
          <div style="font-size: 1.55rem; font-weight: 800; color: #a78bfa; font-family: var(--font-mono);" id="refStatsF1Spent">$0.00</div>
          <div data-i18n="ref_stat_f1_spent" style="font-size: 0.72rem; color: var(--text-muted); margin-top: 4px; text-transform: uppercase; font-weight: 600;">Doanh Số F1</div>
        </div>
      </div>

      <!-- Bảng Minh Họa Quyền Lợi Hoa Hồng Khi F1 Mua Gói Đào (10% Tuyến Trên) -->
      <div class="glass-card" style="padding: 22px 18px; border-radius: 18px; margin-bottom: 24px; border: 1px solid rgba(255,255,255,0.08);">
        <h3 data-i18n="ref_table_title" style="font-size: 1.15rem; font-weight: 800; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
          <span>💰</span> <span>Bảng Quyền Lợi Hoa Hồng Khi F1 Mua Gói Đào (10%)</span>
        </h3>
        <p data-i18n="ref_table_subtitle" style="font-size: 0.82rem; color: var(--text-muted); margin-bottom: 16px;">
          Mỗi khi thành viên F1 kích hoạt gói máy đào, hệ thống sẽ tự động trích <strong style="color: #34d399;">10% giá trị gói</strong> chuyển thẳng vào số dư ví USDT của bạn:
        </p>

        <!-- 2 Packages Commission Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 14px; margin-bottom: 16px;">
          <!-- Package 1: 30 USDT -->
          <div style="background: #000; border: 1px solid rgba(245,158,11,0.25); border-radius: 14px; padding: 16px; position: relative; overflow: hidden;">
            <div style="position: absolute; top: 10px; right: 10px; background: rgba(52,211,153,0.15); border: 1px solid rgba(52,211,153,0.4); color: #34d399; font-size: 0.72rem; font-weight: 800; padding: 3px 8px; border-radius: 12px;">
              +10% HOA HỒNG
            </div>
            <div style="font-size: 0.75rem; color: #fbbf24; font-weight: 700; text-transform: uppercase; margin-bottom: 2px;">GÓI KHỞI ĐỘNG</div>
            <h4 style="font-size: 1.05rem; font-weight: 800; margin: 0 0 10px; color: #fff;">Antminer S19 Mini (30 USDT)</h4>
            
            <div style="display: flex; flex-direction: column; gap: 6px; font-size: 0.84rem;">
              <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed rgba(255,255,255,0.06); padding-bottom: 4px;">
                <span style="color: var(--text-muted);">Giá F1 thanh toán:</span>
                <span style="display: inline-flex; align-items: center; gap: 5px; background: #000; padding: 2px 8px 2px 5px; border-radius: 12px; border: 1px solid rgba(38,161,123,0.3);">
                  <img src="assets/usdt.png" alt="USDT" style="width: 15px; height: 15px; border-radius: 50%;">
                  <strong style="color: #fff; font-family: var(--font-mono);">$30.00 USDT</strong>
                </span>
              </div>
              <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed rgba(255,255,255,0.06); padding-bottom: 4px;">
                <span style="color: var(--text-muted);">Công suất F1 nhận:</span>
                <strong style="color: #38bdf8; font-family: var(--font-mono);">30 TH/s (+1,764.71 EDEN/ngày)</strong>
              </div>
              <div style="display: flex; justify-content: space-between; padding-top: 4px; align-items: center;">
                <span style="font-weight: 700; color: #34d399;">Tuyến trên nhận ngay:</span>
                <span style="display: inline-flex; align-items: center; gap: 5px; background: #000; padding: 2px 10px 2px 6px; border-radius: 14px; border: 1px solid rgba(52,211,153,0.35);">
                  <img src="assets/usdt.png" alt="USDT" style="width: 17px; height: 17px; border-radius: 50%; box-shadow: 0 0 6px rgba(52,211,153,0.5);">
                  <strong style="color: #34d399; font-family: var(--font-mono); font-size: 1.15rem; font-weight: 800;">+$3.00 USDT</strong>
                </span>
              </div>
            </div>
          </div>

          <!-- Package 2: 100 USDT -->
          <div style="background: #000; border: 1px solid rgba(56,189,248,0.3); border-radius: 14px; padding: 16px; position: relative; overflow: hidden;">
            <div style="position: absolute; top: 10px; right: 10px; background: rgba(52,211,153,0.15); border: 1px solid rgba(52,211,153,0.4); color: #34d399; font-size: 0.72rem; font-weight: 800; padding: 3px 8px; border-radius: 12px;">
              +10% HOA HỒNG
            </div>
            <div style="font-size: 0.75rem; color: #38bdf8; font-weight: 700; text-transform: uppercase; margin-bottom: 2px;">GÓI CƠ BẢN</div>
            <h4 style="font-size: 1.05rem; font-weight: 800; margin: 0 0 10px; color: #fff;">Antminer S19 Pro (100 USDT)</h4>
            
            <div style="display: flex; flex-direction: column; gap: 6px; font-size: 0.84rem;">
              <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed rgba(255,255,255,0.06); padding-bottom: 4px;">
                <span style="color: var(--text-muted);">Giá F1 thanh toán:</span>
                <span style="display: inline-flex; align-items: center; gap: 5px; background: #000; padding: 2px 8px 2px 5px; border-radius: 12px; border: 1px solid rgba(38,161,123,0.3);">
                  <img src="assets/usdt.png" alt="USDT" style="width: 15px; height: 15px; border-radius: 50%;">
                  <strong style="color: #fff; font-family: var(--font-mono);">$100.00 USDT</strong>
                </span>
              </div>
              <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed rgba(255,255,255,0.06); padding-bottom: 4px;">
                <span style="color: var(--text-muted);">Công suất F1 nhận:</span>
                <strong style="color: #38bdf8; font-family: var(--font-mono);">100 TH/s (+5,882.35 EDEN/ngày)</strong>
              </div>
              <div style="display: flex; justify-content: space-between; padding-top: 4px; align-items: center;">
                <span style="font-weight: 700; color: #34d399;">Tuyến trên nhận ngay:</span>
                <span style="display: inline-flex; align-items: center; gap: 5px; background: #000; padding: 2px 10px 2px 6px; border-radius: 14px; border: 1px solid rgba(52,211,153,0.35);">
                  <img src="assets/usdt.png" alt="USDT" style="width: 17px; height: 17px; border-radius: 50%; box-shadow: 0 0 6px rgba(52,211,153,0.5);">
                  <strong style="color: #34d399; font-family: var(--font-mono); font-size: 1.15rem; font-weight: 800;">+$10.00 USDT</strong>
                </span>
            </div>
          </div>
        </div>

        <!-- Callout: Mua nhiều gói xN -->
        <div style="background: #000; border: 1px dashed rgba(245,158,11,0.3); border-radius: 12px; padding: 12px 14px; font-size: 0.82rem; color: var(--text-muted); line-height: 1.5;">
          <div style="color: #fbbf24; font-weight: 700; margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
            <span>💡</span> <span>Cơ chế tính khi F1 mua số lượng nhiều gói:</span>
          </div>
          <div>• F1 mua <strong>2 gói 30 USDT</strong> ($60 USDT) &rarr; Tuyến trên nhận ngay: <strong style="color: #34d399;">+$6.00 USDT</strong> (10%)</div>
          <div>• F1 mua <strong>5 gói 100 USDT</strong> ($500 USDT) &rarr; Tuyến trên nhận ngay: <strong style="color: #34d399;">+$50.00 USDT</strong> (10%)</div>
          <div>• F1 mua <strong>10 gói 100 USDT</strong> ($1,000 USDT) &rarr; Tuyến trên nhận ngay: <strong style="color: #34d399;">+$100.00 USDT</strong> (10%)</div>
          <div style="margin-top: 4px; color: #fff;">✨ <em>Không giới hạn số lượng F1 và số lượng gói máy đào! Hoa hồng được cộng trực tiếp vào ví USDT, có thể rút hoặc tái đầu tư 24/7.</em></div>
        </div>
      </div>
      </div> <!-- /glass-card Bảng Minh Họa Quyền Lợi Hoa Hồng -->

      <!-- 3 Bước Kiếm Tiền Thụ Động -->
      <div class="glass-card" style="padding: 22px 18px; border-radius: 18px; margin-bottom: 24px; border: 1px solid rgba(255,255,255,0.08);">
        <h3 data-i18n="ref_steps_title" style="font-size: 1.15rem; font-weight: 800; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
          <span>🚀</span> <span>3 Bước Kiếm Tiền Hoa Hồng Thụ Động Cùng MINEX</span>
        </h3>
        <div style="display: flex; flex-direction: column; gap: 14px;">
          <div style="display: flex; gap: 14px; align-items: flex-start;">
            <div style="width: 32px; height: 32px; border-radius: 50%; background: #f59e0b; color: #000; font-weight: 800; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 0 10px rgba(245,158,11,0.5);">1</div>
            <div>
              <strong style="color: #fff; font-size: 0.94rem;" data-i18n="ref_step1_title">Lấy Mã & Liên Kết Giới Thiệu</strong>
              <p data-i18n="ref_step1_desc" style="font-size: 0.82rem; color: var(--text-muted); margin: 4px 0 0; line-height: 1.5;">Sao chép mã UID hoặc đường link giới thiệu cá nhân ở trên và gửi cho bạn bè hoặc các hội nhóm cộng đồng crypto.</p>
            </div>
          </div>

          <div style="display: flex; gap: 14px; align-items: flex-start;">
            <div style="width: 32px; height: 32px; border-radius: 50%; background: #38bdf8; color: #fff; font-weight: 800; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 0 10px rgba(56,189,248,0.5);">2</div>
            <div>
              <strong style="color: #fff; font-size: 0.94rem;" data-i18n="ref_step2_title">F1 Đăng Ký & Mua Gói Máy Đào</strong>
              <p data-i18n="ref_step2_desc" style="font-size: 0.82rem; color: var(--text-muted); margin: 4px 0 0; line-height: 1.5;">Bạn bè mở link đăng ký tài khoản (hệ thống tự động liên kết tuyến trên) và tiến hành kích hoạt gói đào 30 USDT hoặc 100 USDT.</p>
            </div>
          </div>

          <div style="display: flex; gap: 14px; align-items: flex-start;">
            <div style="width: 32px; height: 32px; border-radius: 50%; background: #10b981; color: #fff; font-weight: 800; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 0 10px rgba(16,185,129,0.5);">3</div>
            <div>
              <strong style="color: #fff; font-size: 0.94rem;" data-i18n="ref_step3_title">Nhận Ngay 10% USDT Tuyến Trên Tức Thì</strong>
              <p data-i18n="ref_step3_desc" style="font-size: 0.82rem; color: var(--text-muted); margin: 4px 0 0; line-height: 1.5;">Ngay khi đơn hàng hoàn tất, 10% hoa hồng sẽ tự động ghi có vào số dư USDT của tuyến trên. Bạn có thể rút tiền về ví cá nhân hoặc tiếp tục mua máy đào.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Danh Sách Thành Viên F1 & Lịch Sử Hoa Hồng -->
      <div class="glass-card" style="padding: 22px 18px; border-radius: 18px; margin-bottom: 24px; border: 1px solid rgba(255,255,255,0.08);">
        <h3 data-i18n="ref_f1_list_title" style="font-size: 1.15rem; font-weight: 800; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
          <span>👥</span> <span>Danh Sách F1 & Lịch Sử Nhận Hoa Hồng</span>
        </h3>

        <!-- F1 Members Container -->
        <div id="refF1ListContainer" style="margin-bottom: 16px;">
          <div style="text-align: center; padding: 20px; color: var(--text-muted); font-size: 0.85rem;" data-i18n="ref_no_f1">
            Chưa có thành viên F1 nào. Hãy chia sẻ link giới thiệu ngay để bắt đầu nhận 10% hoa hồng!
          </div>
        </div>

        <!-- Commission History Container -->
        <h4 style="font-size: 0.95rem; font-weight: 700; margin: 16px 0 10px; color: #fbbf24; display: flex; align-items: center; gap: 6px;">
          <span>📜</span> <span data-i18n="ref_comm_history_title">Lịch Sử Nhận Hoa Hồng Tuyến Trên</span>
        </h4>
        <div id="refCommissionHistoryContainer">
          <div style="text-align: center; padding: 14px; color: var(--text-muted); font-size: 0.82rem;" data-i18n="ref_no_comm">
            Chưa có giao dịch hoa hồng nào được ghi nhận.
          </div>
        </div>
      </div>

      <!-- Core Pillars & Tech Reliability (Tóm tắt nền tảng) -->
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 14px; margin-bottom: 24px;">
        <div class="glass-card" style="padding: 16px; border-radius: 14px; border: 1px solid rgba(255,255,255,0.08);">
          <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
            <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(16,185,129,0.15); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">⚡</div>
            <h4 data-i18n="about_feature_1_title" style="font-size: 0.96rem; font-weight: 700; margin: 0;">Khai Thác Theo Giây</h4>
          </div>
          <p data-i18n="about_feature_1_desc" style="font-size: 0.8rem; color: var(--text-muted); line-height: 1.45; margin: 0;">
            Hệ thống phân bổ Hashrate tức thì. Sản lượng coin MNX được tính toán và cộng dồn trực tiếp theo từng giây, nhận thưởng 24 giờ một lần.
          </p>
        </div>

        <div class="glass-card" style="padding: 16px; border-radius: 14px; border: 1px solid rgba(255,255,255,0.08);">
          <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
            <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(56,189,248,0.15); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">🛡️</div>
            <h4 data-i18n="about_feature_2_title" style="font-size: 0.96rem; font-weight: 700; margin: 0;">Bảo Mật Chuẩn Ngân Hàng</h4>
          </div>
          <p data-i18n="about_feature_2_desc" style="font-size: 0.8rem; color: var(--text-muted); line-height: 1.45; margin: 0;">
            Mã hóa SSL 256-bit, kiến trúc lưu trữ ví lạnh cách ly an toàn và hệ sinh thái bảo vệ chống DDOS đa tầng chuẩn quốc tế.
          </p>
        </div>
      </div>

      <!-- Quick Action Buttons -->
      <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
        <button class="btn btn-primary btn-lg" onclick="copyReferralLink()" data-i18n="ref_btn_copy_link" style="font-weight: 700; padding: 13px 24px; border-radius: 14px;">
          🔗 Sao Chép Link Giới Thiệu
        </button>
        <button class="btn btn-secondary btn-lg" onclick="switchTab('store')" data-i18n="about_btn_start" style="font-weight: 700; padding: 13px 24px; border-radius: 14px;">
          🛒 Xem Gói Máy Đào
        </button>
      </div>
    </section>

    <!-- ==================== TAB 5: USER (ĐĂNG NHẬP / ĐĂNG KÝ & TÀI KHOẢN) ==================== -->
    <section id="page-user" class="tab-page" style="display: none; width: 100%; max-width: 720px; margin: 0 auto; padding-bottom: 24px; box-sizing: border-box; overflow-x: hidden;">
      
      <!-- 1. CHƯA ĐĂNG NHẬP: NƠI ĐĂNG NHẬP & ĐĂNG KÝ TÀI KHOẢN -->
      <div id="userPageLoggedOut" class="glass-card" style="width: 100%; max-width: 480px; margin: 0 auto; padding: 24px 18px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.12); background: #000; box-sizing: border-box;">
        
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 20px;">
          <div style="width: 56px; height: 56px; margin: 0 auto 12px; background: linear-gradient(135deg, rgba(245,158,11,0.2) 0%, rgba(217,119,6,0.2) 100%); border: 1px solid rgba(245,158,11,0.4); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 20px rgba(245,158,11,0.25);">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="2.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </div>
          <h2 id="userPageTitle" data-i18n="user_title" style="font-size: 1.4rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 4px;">Tài Khoản MINEX</h2>
          <p id="userPageSubtitle" data-i18n="user_subtitle" style="color: var(--text-muted); font-size: 0.85rem;">Đăng nhập hoặc đăng ký tài khoản thợ đào</p>
        </div>

        <!-- Auth Mode Switcher -->
        <div style="display: flex; background: rgba(255,255,255,0.06); padding: 4px; border-radius: 12px; margin-bottom: 18px; border: 1px solid rgba(255,255,255,0.08);">
          <button type="button" id="userBtnTabLogin" data-i18n="btn_login" onclick="setUserAuthMode('login')" style="flex: 1; padding: 9px; font-weight: 700; font-size: 0.88rem; border: none; border-radius: 9px; cursor: pointer; background: var(--primary); color: #000; transition: all 0.2s;">
            Đăng Nhập
          </button>
          <button type="button" id="userBtnTabRegister" data-i18n="btn_register" onclick="setUserAuthMode('register')" style="flex: 1; padding: 9px; font-weight: 600; font-size: 0.88rem; border: none; border-radius: 9px; cursor: pointer; background: transparent; color: var(--text-muted); transition: all 0.2s;">
            Đăng Ký
          </button>
        </div>

        <!-- Quick Demo Login Box -->
        <div style="background: rgba(245,158,11,0.08); border: 1px dashed rgba(245,158,11,0.35); border-radius: 12px; padding: 12px 14px; margin-bottom: 18px;">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
            <span data-i18n="demo_badge" style="font-size: 0.78rem; font-weight: 700; color: #fbbf24; text-transform: uppercase;">⚡ 1-Click Trải Nghiệm Demo</span>
            <span style="font-size: 0.72rem; color: #38bdf8; font-family: var(--font-mono); font-weight: 700;">UID: 120850</span>
          </div>
          <div style="display: flex; gap: 8px;">
            <button type="button" class="btn btn-primary btn-sm" onclick="quickLogin('user')" data-i18n="demo_btn_user" style="flex: 1; font-weight: 700; font-size: 0.82rem; padding: 8px;">👤 Demo (UID: 120850)</button>
            <button type="button" class="btn btn-secondary btn-sm" onclick="quickLogin('admin')" data-i18n="demo_btn_admin" style="flex: 1; font-weight: 700; font-size: 0.82rem; padding: 8px; border-color: rgba(245,158,11,0.35); color: #fbbf24;">🛡️ Admin (UID: 10001)</button>
          </div>
        </div>

        <!-- Form Đăng Nhập -->
        <form id="userPageLoginForm">
          <div class="form-group" style="margin-bottom: 14px;">
            <label class="form-label" data-i18n="lbl_email" style="font-size: 0.82rem; margin-bottom: 6px;">Địa chỉ Email</label>
            <input type="email" id="userPageLoginEmail" class="form-input" placeholder="miner@example.com" required autocomplete="email">
          </div>
          <div class="form-group" style="margin-bottom: 12px;">
            <label class="form-label" data-i18n="lbl_password" style="font-size: 0.82rem; margin-bottom: 6px;">Mật khẩu</label>
            <input type="password" id="userPageLoginPassword" class="form-input" placeholder="••••••••" required autocomplete="current-password">
          </div>

          <!-- Dấu tích đồng ý Điều khoản trong Đăng nhập -->
          <div style="display: flex; align-items: flex-start; gap: 8px; margin: 12px 0 16px; font-size: 0.82rem; color: var(--text-muted);">
            <input type="checkbox" id="userPageLoginAgreeTerms" style="margin-top: 2px; accent-color: var(--primary); width: 16px; height: 16px; cursor: pointer;" checked required>
            <label for="userPageLoginAgreeTerms" style="cursor: pointer; line-height: 1.4;">
              <span data-i18n="agree_terms_login">Tôi đồng ý với</span> <a href="#" onclick="openTermsModal(event)" data-i18n="terms_link" style="color: var(--primary); text-decoration: underline;">Điều khoản dịch vụ & Tuyên bố miễn trừ trách nhiệm</a>.
            </label>
          </div>

          <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; font-weight: 700; padding: 12px;">
            <span data-i18n="btn_submit_login">Đăng Nhập Tài Khoản</span>
          </button>
          <div style="text-align: center; margin-top: 14px; font-size: 0.85rem; color: var(--text-muted);">
            <span data-i18n="dont_have_account">Chưa có tài khoản?</span> <a href="javascript:void(0)" onclick="setUserAuthMode('register')" data-i18n="link_register_now" style="color: var(--primary); font-weight: 600;">Đăng ký nhận 100 USDT</a>
          </div>
        </form>

        <!-- Form Đăng Ký -->
        <form id="userPageRegisterForm" style="display: none;">
          <div class="form-group" style="margin-bottom: 14px;">
            <label class="form-label" data-i18n="lbl_fullname" style="font-size: 0.82rem; margin-bottom: 6px;">Họ và tên thợ đào</label>
            <input type="text" id="userPageRegName" class="form-input" placeholder="Nguyễn Văn A" required>
          </div>
          <div class="form-group" style="margin-bottom: 14px;">
            <label class="form-label" data-i18n="lbl_email" style="font-size: 0.82rem; margin-bottom: 6px;">Địa chỉ Email</label>
            <input type="email" id="userPageRegEmail" class="form-input" placeholder="miner@example.com" required autocomplete="email">
          </div>
          <div class="form-group" style="margin-bottom: 12px;">
            <label class="form-label" data-i18n="lbl_password" style="font-size: 0.82rem; margin-bottom: 6px;">Mật khẩu</label>
            <input type="password" id="userPageRegPassword" class="form-input" placeholder="Tối thiểu 6 ký tự" required autocomplete="new-password">
          </div>
          <div class="form-group" style="margin-bottom: 14px;">
            <label class="form-label" style="font-size: 0.82rem; margin-bottom: 6px; display: flex; justify-content: space-between; align-items: center;">
              <span>Mã Người Giới Thiệu (Tuyến Trên)</span>
              <span style="font-size: 0.72rem; color: #fbbf24; font-weight: 600;">(Không bắt buộc)</span>
            </label>
            <input type="text" id="userPageRegRefCode" class="form-input" placeholder="Nhập UID tuyến trên (ví dụ: 120850)" style="font-family: var(--font-mono); letter-spacing: 0.05em;">
          </div>

          <!-- Dấu tích đồng ý Điều khoản trong Đăng ký -->
          <div style="display: flex; align-items: flex-start; gap: 8px; margin: 12px 0 16px; font-size: 0.82rem; color: var(--text-muted);">
            <input type="checkbox" id="userPageRegAgreeTerms" style="margin-top: 2px; accent-color: var(--primary); width: 16px; height: 16px; cursor: pointer;" checked required>
            <label for="userPageRegAgreeTerms" style="cursor: pointer; line-height: 1.4;">
              <span data-i18n="agree_terms_register">Tôi đã đọc và đồng ý với</span> <a href="#" onclick="openTermsModal(event)" data-i18n="terms_link" style="color: var(--primary); text-decoration: underline;">Điều khoản sử dụng & Tuyên bố miễn trừ rủi ro</a>.
            </label>
          </div>

          <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; font-weight: 700; padding: 12px;">
            <span data-i18n="btn_submit_register">Đăng Ký & Nhận 100 USDT</span>
          </button>
          <div style="text-align: center; margin-top: 14px; font-size: 0.85rem; color: var(--text-muted);">
            <span data-i18n="already_have_account">Đã có tài khoản?</span> <a href="javascript:void(0)" onclick="setUserAuthMode('login')" data-i18n="link_login_now" style="color: var(--primary); font-weight: 600;">Đăng nhập ngay</a>
          </div>
        </form>
      </div>

      <!-- 2. ĐÃ ĐĂNG NHẬP: TRANG TÀI KHOẢN CÁ NHÂN (USER PROFILE & MANAGEMENT) -->
      <div id="userPageLoggedIn" style="display: none; flex-direction: column; width: 100%; max-width: 540px; margin: 0 auto; box-sizing: border-box; padding: 10px 14px 40px; gap: 16px;">
        
        <!-- THẺ 1: HỒ SƠ THỢ ĐÀO & UID -->
        <div style="background: #000; border: 1px solid rgba(255,255,255,0.12); border-radius: 18px; padding: 20px 18px; display: flex; flex-direction: column; gap: 14px;">
          <div style="display: flex; align-items: center; gap: 16px;">
            <!-- Avatar tròn với Initial -->
            <div style="width: 58px; height: 58px; border-radius: 50%; background: #16151c; border: 2px solid rgba(245, 158, 11, 0.45); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; font-weight: 800; color: #fbbf24; flex-shrink: 0; box-shadow: 0 0 15px rgba(245,158,11,0.2);" id="userProfileInitial">
              M
            </div>
            <!-- Họ tên, email, UID -->
            <div style="flex: 1; min-width: 0;">
              <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                <h3 id="userProfileName" style="font-size: 1.25rem; font-weight: 800; color: #ead9cf !important; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                  VIP Miner Demo
                </h3>
                <span id="userProfileRoleBadge" class="nav-level-badge" style="background: #dfc5b2 !important; color: #1e1b18 !important; font-size: 0.8rem; font-weight: 600; padding: 2px 12px; border-radius: 9999px;">Level 10</span>
              </div>
              <div id="userProfileEmail" style="font-size: 0.82rem; color: #8e8c94 !important; margin-top: 3px; word-break: break-all;">
                user@mining.io
              </div>
              <!-- UID pill with copy -->
              <div style="margin-top: 6px; display: flex; align-items: center; gap: 8px;">
                <div onclick="copyMyUid()" title="Bấm để sao chép UID" style="cursor: pointer; display: inline-flex; align-items: center; gap: 6px; background: rgba(223, 197, 178, 0.12); border: 1px solid rgba(223, 197, 178, 0.35); border-radius: 8px; padding: 2px 10px; font-family: var(--font-mono); font-size: 0.82rem; color: #ead9cf;">
                  <span>UID: <strong class="user-uid-display">120850</strong></span>
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                </div>
                <span style="font-size: 0.76rem; color: #34d399; display: inline-flex; align-items: center; gap: 4px;">● Đã xác thực</span>
              </div>
            </div>
          </div>
        </div>

        <!-- THẺ 2: TỔNG QUAN TÀI SẢN & SỐ DƯ -->
        <div style="background: #000; border: 1px solid rgba(255,255,255,0.12); border-radius: 18px; padding: 18px; display: flex; flex-direction: column; gap: 14px;">
          <div style="display: flex; align-items: center; justify-content: space-between;">
            <div style="font-size: 0.95rem; font-weight: 700; color: #ead9cf !important; display: flex; align-items: center; gap: 6px;">
              <span>💳</span> <span>Tài Sản Của Bạn</span>
            </div>
            <button onclick="switchTab('wallet')" class="btn btn-secondary btn-sm" style="font-size: 0.76rem; padding: 3px 10px; border-color: rgba(255,255,255,0.2);">
              Vào Ví &rarr;
            </button>
          </div>
          
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <!-- Box USDT -->
            <div style="background: #000; border: 1px solid rgba(38,161,123,0.3); border-radius: 14px; padding: 12px 14px;">
              <div style="display: flex; align-items: center; gap: 6px; font-size: 0.76rem; color: #8e8c94 !important;">
                <img src="assets/usdt.png" alt="USDT" style="width: 14px; height: 14px; border-radius: 50%;">
                <span>Số dư USDT</span>
              </div>
              <div style="font-size: 1.25rem; font-weight: 800; color: #ead9cf !important; font-family: var(--font-mono); margin-top: 4px;">
                <span class="user-usdt-balance">22539.62</span>
              </div>
              <div style="font-size: 0.72rem; color: #26a17b; font-weight: 700; margin-top: 2px;">Tether USD (TRC20)</div>
            </div>

            <!-- Box EDEN -->
            <div style="background: #000; border: 1px solid rgba(245,158,11,0.3); border-radius: 14px; padding: 12px 14px;">
              <div style="display: flex; align-items: center; gap: 6px; font-size: 0.76rem; color: #8e8c94 !important;">
                <span>🪙</span>
                <span>Sản lượng <span class="coin-symbol">EDEN</span></span>
              </div>
              <div style="font-size: 1.25rem; font-weight: 800; color: #fbbf24 !important; font-family: var(--font-mono); margin-top: 4px;">
                <span class="user-coin-balance">1555.582095</span>
              </div>
              <div style="font-size: 0.72rem; color: #8e8c94; margin-top: 2px;">
                ≈ <span id="userProfileEquivUsdt">0.1555</span> USDT
              </div>
            </div>
          </div>
        </div>

        <!-- THẺ 3: MÁY ĐÀO & HIỆU SUẤT KHAI THÁC -->
        <div style="background: #000; border: 1px solid rgba(255,255,255,0.12); border-radius: 18px; padding: 18px; display: flex; flex-direction: column; gap: 12px;">
          <div style="display: flex; align-items: center; justify-content: space-between;">
            <div style="font-size: 0.95rem; font-weight: 700; color: #ead9cf !important; display: flex; align-items: center; gap: 6px;">
              <span>⛏️</span> <span>Hệ Thống Máy Đào Đang Chạy</span>
            </div>
            <button onclick="switchTab('store')" class="btn btn-secondary btn-sm" style="font-size: 0.76rem; padding: 3px 10px; border-color: rgba(245,158,11,0.35); color: #fbbf24;">
              + Thuê Máy
            </button>
          </div>

          <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 14px; background: #000; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px;">
            <div>
              <div style="font-size: 0.88rem; font-weight: 700; color: #ead9cf !important;">WhatsMiner M50S</div>
              <div style="font-size: 0.75rem; color: #34d399; margin-top: 2px;">● Hoạt động 24/7 (Đang đào)</div>
            </div>
            <div style="text-align: right;">
              <div style="font-size: 0.95rem; font-weight: 800; color: #38bdf8; font-family: var(--font-mono);">500 TH/s</div>
              <div style="font-size: 0.75rem; color: #8e8c94;">+15.000 EDEN/ngày</div>
            </div>
          </div>
        </div>

        <!-- THẺ 4: HOA HỒNG GIỚI THIỆU (AFFILIATE 10%) -->
        <div style="background: #000; border: 1px solid rgba(255,255,255,0.12); border-radius: 18px; padding: 18px; display: flex; flex-direction: column; gap: 12px;">
          <div style="display: flex; align-items: center; justify-content: space-between;">
            <div style="font-size: 0.95rem; font-weight: 700; color: #ead9cf !important; display: flex; align-items: center; gap: 6px;">
              <span>👥</span> <span>Đối Tác Tuyến Dưới (10% F1)</span>
            </div>
            <button onclick="switchTab('about')" class="btn btn-secondary btn-sm" style="font-size: 0.76rem; padding: 3px 10px; border-color: rgba(52,211,153,0.35); color: #34d399;">
              Chi Tiết &rarr;
            </button>
          </div>
          <div style="font-size: 0.82rem; color: #8e8c94 !important; line-height: 1.5;">
            Khi thành viên F1 mua gói đào, bạn nhận ngay <strong style="color: #34d399;">10%</strong> giá trị gói bằng USDT về ví tức thì!
          </div>
          <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: #000; border: 1px dashed rgba(255,255,255,0.12); border-radius: 10px; font-size: 0.8rem;">
            <span style="color: #8e8c94;">Mã giới thiệu UID:</span>
            <span style="font-family: var(--font-mono); font-weight: 800; color: #fbbf24;" class="user-uid-display">120850</span>
          </div>
        </div>

        <!-- THẺ 5: TRUNG TÂM BẢO MẬT & CÀI ĐẶT -->
        <div style="background: #000; border: 1px solid rgba(255,255,255,0.12); border-radius: 18px; padding: 18px; display: flex; flex-direction: column; gap: 10px;">
          <div style="font-size: 0.95rem; font-weight: 700; color: #ead9cf !important; margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
            <span>⚙️</span> <span>Cài Đặt & Bảo Mật</span>
          </div>

          <!-- Mục 1: Lịch sử giao dịch -->
          <div onclick="openHistoryModal(event)" style="display: flex; align-items: center; justify-content: space-between; padding: 11px 4px; border-bottom: 1px solid rgba(255,255,255,0.06); cursor: pointer;">
            <div style="display: flex; align-items: center; gap: 10px;">
              <span>📋</span>
              <span style="font-size: 0.86rem; color: #ead9cf !important; font-weight: 500;">Lịch sử giao dịch & Nạp/Rút</span>
            </div>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#5b595e" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
          </div>

          <!-- Mục 2: Xác thực 2FA -->
          <div style="display: flex; align-items: center; justify-content: space-between; padding: 11px 4px; border-bottom: 1px solid rgba(255,255,255,0.06);">
            <div style="display: flex; align-items: center; gap: 10px;">
              <span>🛡️</span>
              <span style="font-size: 0.86rem; color: #ead9cf !important; font-weight: 500;">Xác thực Google 2FA</span>
            </div>
            <span style="font-size: 0.76rem; color: #34d399; font-weight: 600;">✓ Đã bật bảo vệ</span>
          </div>

          <!-- Mục 3: Mạng lưới ví -->
          <div style="display: flex; align-items: center; justify-content: space-between; padding: 11px 4px; border-bottom: 1px solid rgba(255,255,255,0.06);">
            <div style="display: flex; align-items: center; gap: 10px;">
              <span>🌐</span>
              <span style="font-size: 0.86rem; color: #ead9cf !important; font-weight: 500;">Mạng lưới thanh toán</span>
            </div>
            <span style="font-size: 0.8rem; color: #fbbf24; font-weight: 600;">USDT (TRC20)</span>
          </div>

          <!-- Mục 4: Điều khoản dịch vụ -->
          <div onclick="openTermsModal(event)" style="display: flex; align-items: center; justify-content: space-between; padding: 11px 4px; cursor: pointer;">
            <div style="display: flex; align-items: center; gap: 10px;">
              <span>📜</span>
              <span style="font-size: 0.86rem; color: #ead9cf !important; font-weight: 500;">Điều khoản dịch vụ & Miễn trừ rủi ro</span>
            </div>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#5b595e" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
          </div>
        </div>

        <!-- KHU VỰC ADMIN (NẾU CÓ ROLE ADMIN) -->
        <div class="admin-only" style="display: none; background: #000; border: 1px solid rgba(245,158,11,0.35); border-radius: 18px; padding: 16px; align-items: center; justify-content: space-between;">
          <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 1.3rem;">🛡️</span>
            <div>
              <div style="font-size: 0.9rem; font-weight: 700; color: #fbbf24;">Bảng Quản Trị Hệ Thống</div>
              <div style="font-size: 0.75rem; color: #8e8c94;">Duyệt nạp/rút, thành viên & tỷ giá</div>
            </div>
          </div>
          <button onclick="switchTab('admin')" class="btn btn-secondary btn-sm" style="border-color: rgba(245,158,11,0.4); color: #fbbf24; font-weight: 700; padding: 6px 14px;">
            Vào Admin &rarr;
          </button>
        </div>

        <!-- NÚT ĐĂNG XUẤT -->
        <div style="margin-top: 8px; text-align: center;">
          <button onclick="handleLogout()" style="width: 100%; height: 48px; background: transparent; border: 1.5px solid rgba(239,68,68,0.35); color: #f87171 !important; border-radius: 12px; font-size: 0.92rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            <span>Đăng xuất tài khoản</span>
          </button>
        </div>

      </div>

    </section>

    <!-- ==================== TAB 6: ADMIN ==================== -->
    <section id="page-admin" class="tab-page" style="display: none;">
      <div style="margin-bottom: 20px;">
        <h1 style="font-size: 1.8rem; font-weight: 800; color: #fbbf24;">Bảng Quản Trị Hệ Thống (Admin)</h1>
        <p style="color: var(--text-muted); font-size: 0.92rem; margin-top: 3px;">
          Duyệt nạp/rút, quản lý thành viên, điều chỉnh tỷ giá Coin/USDT và danh mục máy đào.
        </p>
      </div>

      <!-- Overview stats -->
      <div class="dashboard-grid" style="margin-bottom: 20px;">
        <div class="glass-card stat-card col-3">
          <div>
            <span class="stat-label">Tổng Người Dùng</span>
            <div class="stat-val" id="admTotalUsers">0</div>
          </div>
        </div>
        <div class="glass-card stat-card col-3">
          <div>
            <span class="stat-label">Lệnh Chờ Duyệt</span>
            <div class="stat-val" style="color: #fbbf24;" id="admPendingCount">0</div>
          </div>
        </div>
        <div class="glass-card stat-card col-3">
          <div>
            <span class="stat-label">Tổng Máy Hoạt Động</span>
            <div class="stat-val" style="color: #fbbf24;" id="admActiveMiners">0</div>
          </div>
        </div>
        <div class="glass-card stat-card col-3">
          <div>
            <span class="stat-label">Tỷ Giá Coin Hiện Tại</span>
            <div class="stat-val" style="color: #fbbf24;" id="admCoinPrice">$0.20</div>
          </div>
        </div>
      </div>

      <!-- Admin Pending Transactions -->
      <div class="glass-card" style="margin-bottom: 20px; padding: 0;">
        <div style="padding: 14px 18px; border-bottom: 1px solid var(--border-subtle);">
          <h3 style="font-size: 1.1rem; font-weight: 700;">Hàng Đợi Phê Duyệt Nạp / Rút</h3>
        </div>
        <div class="table-wrapper">
          <table class="custom-table">
            <thead>
              <tr>
                <th>Mã Lệnh</th>
                <th>User ID</th>
                <th>Loại</th>
                <th>Số Lượng</th>
                <th>Ví / TxHash</th>
                <th>Thời Gian</th>
                <th>Trạng Thái</th>
                <th>Thao Tác</th>
              </tr>
            </thead>
            <tbody id="admTxTableBody">
              <!-- Rendered via JS -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- Admin Settings & Rates -->
      <div class="glass-card" style="margin-bottom: 20px;">
        <h3 style="font-size: 1.15rem; font-weight: 700; margin-bottom: 14px;">Cập Nhật Cấu Hình Tỷ Giá & Tham Số Ví</h3>
        <form id="adminSettingsForm" style="max-width: 600px;">
          <div class="form-group">
            <label class="form-label">Tỷ giá Coin sang USDT ($)</label>
            <input type="number" step="0.001" id="admSetCoinPrice" class="form-input" required>
          </div>
          <div class="form-group">
            <label class="form-label">Địa chỉ ví nhận tiền Nạp USDT của Hệ thống</label>
            <input type="text" id="admSetDepositAddress" class="form-input" required>
          </div>
          <div class="form-group">
            <label class="form-label">Mạng lưới ví nạp</label>
            <input type="text" id="admSetNetwork" class="form-input" required>
          </div>
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <div class="form-group">
              <label class="form-label">Mức nạp tối thiểu (USDT)</label>
              <input type="number" step="any" id="admSetMinDep" class="form-input" required>
            </div>
            <div class="form-group">
              <label class="form-label">Mức rút tối thiểu (USDT)</label>
              <input type="number" step="any" id="admSetMinWd" class="form-input" required>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Phí rút tiền (%)</label>
            <input type="number" step="0.1" id="admSetWdFee" class="form-input" required>
          </div>
          <button type="submit" class="btn btn-primary" style="margin-top: 8px;">Lưu Cấu Hình</button>
        </form>
      </div>

      <!-- Admin Users List -->
      <div class="glass-card" style="margin-bottom: 20px; padding: 0;">
        <div style="padding: 14px 18px; border-bottom: 1px solid var(--border-subtle);">
          <h3 style="font-size: 1.1rem; font-weight: 700;">Danh Sách Người Dùng & Số Dư</h3>
        </div>
        <div class="table-wrapper">
          <table class="custom-table">
            <thead>
              <tr>
                <th>Tên & Email</th>
                <th>Vai Trò</th>
                <th>Số Dư USDT</th>
                <th>Số Dư Coin</th>
                <th>Số Máy</th>
                <th>Hashrate</th>
                <th>Thao Tác</th>
              </tr>
            </thead>
            <tbody id="admUsersTableBody">
              <!-- Rendered via JS -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- Admin Miners Catalog -->
      <div class="glass-card" style="padding: 0;">
        <div style="padding: 14px 18px; border-bottom: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center;">
          <h3 style="font-size: 1.1rem; font-weight: 700;">Danh Mục Gói Máy Đào</h3>
          <button class="btn btn-primary btn-sm" onclick="openModal('addMinerModal')">+ Thêm Gói Mới</button>
        </div>
        <div class="table-wrapper">
          <table class="custom-table">
            <thead>
              <tr>
                <th>Tên Máy</th>
                <th>Phân Khúc</th>
                <th>Hashrate</th>
                <th>Giá USDT</th>
                <th>Sản Lượng/Ngày</th>
                <th>Điện Năng</th>
                <th>Trạng Thái</th>
              </tr>
            </thead>
            <tbody id="admMinersTableBody">
              <!-- Rendered via JS -->
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- ==================== TAB 6: TERMS & DISCLAIMER ==================== -->
    <section id="page-terms" class="tab-page" style="display: none; max-width: 860px; margin: 0 auto;">
      <div style="text-align: center; margin-bottom: 24px;">
        <h1 style="font-size: 1.9rem; font-weight: 800;">Điều Khoản Sử Dụng & Miễn Trừ Trách Nhiệm</h1>
        <p style="color: var(--text-muted); font-size: 0.92rem; margin-top: 4px;">
          Quy định dịch vụ và khuyến cáo an toàn khi tham gia MINEX Cloud Mining.
        </p>
      </div>

      <div class="alert alert-warning" style="padding: 16px; margin-bottom: 20px;">
        <div>
          <strong style="display: block; margin-bottom: 3px;">CẢNH BÁO RỦI RO ĐẦU TƯ TÀI SẢN SỐ</strong>
          Thị trường tiền mã hóa có tính biến động cao. Giá trị đồng coin có thể biến động lớn theo thị trường. Người dùng tự chịu trách nhiệm đối với các quyết định tài chính của mình và không nên đầu tư số tiền vượt quá khả năng chấp nhận rủi ro.
        </div>
      </div>

      <div class="glass-card" style="margin-bottom: 20px;">
        <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 12px;">1. Điều Khoản Dịch Vụ</h2>
        <div style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.7; display: flex; flex-direction: column; gap: 10px;">
          <p><strong style="color:#fff;">1.1. Tài khoản:</strong> Người dùng có trách nhiệm tự bảo mật tài khoản đăng nhập của mình.</p>
          <p><strong style="color:#fff;">1.2. Máy đào ảo:</strong> Khi mua máy đào bằng USDT, hệ thống sẽ cấp quyền sức mạnh băm hashrate. Lợi nhuận đồng Coin dự án (<span class="coin-symbol">MNX</span>) được tính toán theo thuật toán thời gian thực và người dùng có thể nhận về ví bất cứ lúc nào.</p>
          <p><strong style="color:#fff;">1.3. Nạp & Rút:</strong> Tiền nạp và rút phải tuân thủ mạng lưới hỗ trợ (TRC20). Các lệnh rút được kiểm duyệt phòng chống gian lận.</p>
          <p><strong style="color:#fff;">1.4. Quy đổi Hoán đổi (Swap):</strong> Cung cấp tính năng hoán đổi Coin dự án sang USDT theo tỷ giá thị trường niêm yết.</p>
        </div>
      </div>

      <div class="glass-card">
        <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 12px; color: #fb7185;">2. Tuyên Bố Miễn Trừ Trách Nhiệm</h2>
        <div style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.7; display: flex; flex-direction: column; gap: 10px;">
          <p><strong style="color:#fff;">2.1. Bản chất dịch vụ:</strong> Hệ thống hoạt động dựa trên mô hình khai thác ảo đám mây mô phỏng sức mạnh tính toán.</p>
          <p><strong style="color:#fff;">2.2. Không phải tư vấn tài chính:</strong> Toàn bộ số liệu hiển thị mang tính tham khảo kỹ thuật, không cấu thành lời khuyên đầu tư tài chính.</p>
          <p><strong style="color:#fff;">2.3. Trách nhiệm người dùng:</strong> Ban quản trị không chịu trách nhiệm trong trường hợp người dùng nhập sai địa chỉ ví nhận USDT hoặc các sự cố bất khả kháng về mạng lưới blockchain.</p>
        </div>
      </div>
    </section>

  </main>

</div> <!-- /iphoneContentScroll -->

      <!-- 3. Bottom Fixed Bar: Bottom Navigation + iOS Home Indicator -->
      <div id="iphoneBottomBar" class="iphone-bottom-bar">
        <!-- Mobile Bottom Navigation Bar -->
        <nav class="bottom-nav">
          <button class="bottom-nav-btn active" data-tab="dashboard">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            <span data-i18n="nav_dashboard">Dashboard</span>
          </button>
          <button class="bottom-nav-btn" data-tab="store">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            <span data-i18n="nav_store_short">Máy Đào</span>
          </button>
          <button class="bottom-nav-btn" data-tab="wallet">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M7 15h0M2 10h20"/></svg>
            <span data-i18n="nav_wallet">Ví & Swap</span>
          </button>
          <button class="bottom-nav-btn" data-tab="about">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            <span data-i18n="nav_about">Giới Thiệu</span>
          </button>
          <button class="bottom-nav-btn" data-tab="user">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <span data-i18n="nav_user">User</span>
          </button>
          <button class="bottom-nav-btn admin-only" data-tab="admin" style="display: none; color: #fbbf24;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            <span data-i18n="nav_admin_short">Admin</span>
          </button>
        </nav>
        <!-- iOS Home Indicator -->
        <div id="iosHomeIndicator" class="ios-home-indicator"></div>
      </div> <!-- /iphoneBottomBar -->

    </div> <!-- /iphoneScreen -->
  </div> <!-- /iphoneChassis -->
  </div> <!-- /iphoneScaleContainer -->
</div> <!-- /deviceWrapper -->

<!-- ==================== MODALS ==================== -->

<!-- Modal 0: Mua Máy Đào Chuẩn 100% Theo Ảnh 2 -->
<div id="buyMinerModal" class="modal-overlay" style="z-index: 10005;">
  <div class="modal-content svip-modal-box" style="position: relative; max-width: 400px; width: 92%; padding: 26px 20px 22px; border-radius: 20px; background: #111219; border: 1px solid rgba(255, 255, 255, 0.14); box-shadow: 0 20px 50px rgba(0,0,0,0.92); box-sizing: border-box;">
    
    <!-- Nút Đóng (X) ở góc trên bên phải -->
    <button type="button" class="svip-modal-close" onclick="closeModal('buyMinerModal')" aria-label="Close">
      &times;
    </button>

    <!-- Ảnh Chip máy đào ở giữa với huy hiệu kim cương vàng -->
    <div style="display: flex; justify-content: center; margin-top: 6px; margin-bottom: 14px;">
      <div style="position: relative; width: 105px; height: 105px; border-radius: 16px; overflow: hidden; background: #000; border: 1.5px solid rgba(255,255,255,0.12); box-shadow: 0 8px 24px rgba(0,0,0,0.6);">
        <img id="modalMinerImg" src="assets/images/svip_chip_clean.png" alt="Chip SVIP" style="width: 100%; height: 100%; object-fit: cover;">
        <!-- Huy hiệu kim cương vàng góc trên bên trái của chip -->
        <div style="position: absolute; top: -1px; left: -1px; background: linear-gradient(135deg, #f59e0b, #d97706); width: 26px; height: 26px; border-radius: 0 0 14px 0; display: flex; align-items: center; justify-content: center; font-size: 0.72rem; box-shadow: 0 2px 6px rgba(0,0,0,0.4);">
          💎
        </div>
      </div>
    </div>

    <!-- Tên máy đào: SVIP -->
    <h3 id="modalMinerTitle" style="font-size: 1.35rem; font-weight: 700; color: #fff; text-align: center; margin: 0 0 6px;">
      SVIP
    </h3>

    <!-- Mô tả tiếng Anh chuẩn theo ảnh: Speed up the production... -->
    <p style="font-size: 0.82rem; color: #8a8793; text-align: center; margin: 0 0 18px; line-height: 1.45; padding: 0 8px;">
      Speed up the production of mining machines and improve work efficiency.
    </p>

    <!-- Hàng 1: Daily Output -->
    <div class="svip-modal-row">
      <span class="svip-modal-label">Daily Output</span>
      <span id="modalMinerDailyOutput" class="svip-modal-val">6000 EDEN</span>
    </div>

    <!-- Hàng 2: Price -->
    <div class="svip-modal-row">
      <span class="svip-modal-label">Price</span>
      <span id="modalMinerPrice" class="svip-modal-val">10 USDT</span>
    </div>

    <!-- Hàng 3: Multiples (Chọn số lượng) -->
    <div class="svip-modal-row" style="border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 20px;">
      <span class="svip-modal-label">Multiples</span>
      <div style="display: flex; align-items: center; gap: 8px;">
        <button type="button" class="svip-qty-btn" onclick="stepSvipQuantity(-1)">−</button>
        <input type="number" id="buyModalQty" value="1" min="1" max="1000" oninput="onSvipQuantityChange()" class="svip-qty-input">
        <button type="button" class="svip-qty-btn" onclick="stepSvipQuantity(1)">+</button>
      </div>
    </div>

    <!-- Nút Mua sắm (hồng phấn/be sang trọng #ead1bf) -->
    <button type="button" id="btnConfirmSvipBuy" class="btn-store-buy" onclick="executeBuyMiner()" style="margin-bottom: 14px;">
      Mua sắm
    </button>

    <!-- Chú thích chân trang: Mining results are harvested every 24 hours -->
    <div style="font-size: 0.78rem; color: #8a8793; text-align: center;">
      Mining results are harvested every 24 hours.
    </div>

  </div>
</div>

<!-- Modal 1: Auth Modal -->
<div id="authModal" class="modal-overlay">
  <div class="modal-content">
    <div class="modal-header">
      <h3 id="authModalTitle" style="font-size: 1.25rem; font-weight: 700;">Đăng Nhập Tài Khoản</h3>
      <button class="modal-close" onclick="closeModal('authModal')">&times;</button>
    </div>


    <!-- Login Form -->
    <form id="loginForm">
      <div class="form-group">
        <label class="form-label">Địa chỉ Email</label>
        <input type="email" id="loginEmail" class="form-input" placeholder="miner@example.com" required>
      </div>
      <div class="form-group">
        <label class="form-label">Mật khẩu</label>
        <input type="password" id="loginPassword" class="form-input" placeholder="••••••••" required>
      </div>

      <!-- Dấu tích đồng ý Điều khoản trong Đăng nhập -->
      <div style="display: flex; align-items: flex-start; gap: 8px; margin: 12px 0 16px; font-size: 0.82rem; color: var(--text-muted);">
        <input type="checkbox" id="loginAgreeTerms" style="margin-top: 2px; accent-color: var(--primary); width: 16px; height: 16px; cursor: pointer;" checked required>
        <label for="loginAgreeTerms" style="cursor: pointer; line-height: 1.4;">
          Tôi đồng ý với <a href="#" onclick="openTermsModal(event)" style="color: var(--primary); text-decoration: underline;">Điều khoản dịch vụ & Tuyên bố miễn trừ trách nhiệm</a>.
        </label>
      </div>

      <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
        Đăng Nhập
      </button>
      <div style="text-align: center; margin-top: 14px; font-size: 0.85rem; color: var(--text-muted);">
        Chưa có tài khoản? <a href="#" id="linkToRegister" style="font-weight: 600;">Đăng ký nhận 100 USDT</a>
      </div>
    </form>

    <!-- Register Form -->
    <form id="registerForm" style="display: none;">
      <div class="form-group">
        <label class="form-label">Họ và tên thợ đào</label>
        <input type="text" id="regName" class="form-input" placeholder="Nguyễn Văn A">
      </div>
      <div class="form-group">
        <label class="form-label">Địa chỉ Email</label>
        <input type="email" id="regEmail" class="form-input" placeholder="miner@example.com" required>
      </div>
      <div class="form-group">
        <label class="form-label">Mật khẩu</label>
        <input type="password" id="regPassword" class="form-input" placeholder="Tối thiểu 6 ký tự" required>
      </div>
      <div class="form-group">
        <label class="form-label" style="display: flex; justify-content: space-between; align-items: center;">
          <span>Mã Người Giới Thiệu (Tuyến Trên)</span>
          <span style="font-size: 0.72rem; color: #fbbf24; font-weight: 600;">(Không bắt buộc)</span>
        </label>
        <input type="text" id="regRefCode" class="form-input" placeholder="Nhập UID tuyến trên (ví dụ: 120850)" style="font-family: var(--font-mono); letter-spacing: 0.05em;">
      </div>

      <!-- Dấu tích đồng ý Điều khoản trong Đăng ký -->
      <div style="display: flex; align-items: flex-start; gap: 8px; margin: 12px 0 16px; font-size: 0.82rem; color: var(--text-muted);">
        <input type="checkbox" id="regAgreeTerms" style="margin-top: 2px; accent-color: var(--primary); width: 16px; height: 16px; cursor: pointer;" checked required>
        <label for="regAgreeTerms" style="cursor: pointer; line-height: 1.4;">
          Tôi đã đọc và đồng ý với <a href="#" onclick="openTermsModal(event)" style="color: var(--primary); text-decoration: underline;">Điều khoản sử dụng & Tuyên bố miễn trừ rủi ro</a>.
        </label>
      </div>

      <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
        Đăng Ký & Nhận 100 USDT
      </button>
      <div style="text-align: center; margin-top: 14px; font-size: 0.85rem; color: var(--text-muted);">
        Đã có tài khoản? <a href="#" id="linkToLogin" style="font-weight: 600;">Đăng nhập tại đây</a>
      </div>
    </form>
  </div>
</div>

<!-- Modal: Terms of Service & Disclaimer Popup -->
<div id="termsModal" class="modal-overlay" style="z-index: 10000;">
  <div class="modal-content" style="max-width: 620px;">
    <div class="modal-header">
      <h3 style="font-size: 1.25rem; font-weight: 700;">Điều Khoản Sử Dụng & Miễn Trừ Trách Nhiệm</h3>
      <button class="modal-close" onclick="closeModal('termsModal')">&times;</button>
    </div>
    
    <div class="alert alert-warning" style="margin-bottom: 16px; font-size: 0.82rem; padding: 10px 12px;">
      <strong>⚠️ CẢNH BÁO RỦI RO:</strong> Thị trường tiền kỹ thuật số và dịch vụ đào ảo đám mây có tính biến động cao. Người dùng tự chịu trách nhiệm đối với quyết định tài chính của mình.
    </div>

    <div style="max-height: 55vh; overflow-y: auto; padding-right: 6px; font-size: 0.86rem; color: var(--text-muted); line-height: 1.65; display: flex; flex-direction: column; gap: 12px;">
      <div>
        <strong style="color: #fff; font-size: 0.92rem;">1. Điều Khoản Dịch Vụ Nền Tảng</strong>
        <p style="margin-top: 4px;">1.1. Người dùng có nghĩa vụ tự bảo mật thông tin tài khoản và mật khẩu.</p>
        <p>1.2. Mua máy đào bằng USDT cấp quyền hashrate mô phỏng. Sản lượng coin (MNX) được tích lũy theo thời gian thực và người dùng có thể nhận thưởng (claim) về ví.</p>
        <p>1.3. Nạp USDT chỉ chấp nhận mạng lưới quy định (TRC20). Mọi yêu cầu rút USDT đều được xét duyệt phòng chống gian lận.</p>
        <p>1.4. Tính năng hoán đổi Swap hỗ trợ quy đổi Coin sang USDT ngay lập tức theo tỷ giá niêm yết.</p>
      </div>
      <div>
        <strong style="color: #fb7185; font-size: 0.92rem;">2. Tuyên Bố Miễn Trừ Trách Nhiệm</strong>
        <p style="margin-top: 4px;">2.1. Nền tảng hoạt động theo mô hình mô phỏng công suất đào ảo đám mây.</p>
        <p>2.2. Toàn bộ thông tin số liệu mang tính tham khảo kỹ thuật, không cấu thành lời khuyên đầu tư tài chính.</p>
        <p>2.3. Ban quản trị không chịu trách nhiệm trong trường hợp người dùng nhập sai địa chỉ ví nhận tiền khi rút.</p>
      </div>
    </div>

    <button class="btn btn-primary" style="width: 100%; margin-top: 18px;" onclick="closeModal('termsModal')" data-i18n="terms_modal_agree">Tôi Đã Hiểu Và Đồng Ý</button>
  </div>
</div>

<!-- Modal: Lịch Sử Giao Dịch & Nhận Coin Popup -->
<div id="historyModal" class="modal-overlay" style="z-index: 10000;">
  <div class="modal-content" style="max-width: 680px; width: 95%; max-height: 86vh; display: flex; flex-direction: column; padding: 20px 16px; border: 1px solid rgba(245, 158, 11, 0.35); box-shadow: 0 10px 40px rgba(0,0,0,0.8), 0 0 25px rgba(245, 158, 11, 0.15);">
    <div class="modal-header" style="padding-bottom: 12px; margin-bottom: 12px; border-bottom: 1px solid rgba(255,255,255,0.08); display: flex; justify-content: space-between; align-items: center;">
      <div>
        <h3 style="font-size: 1.18rem; font-weight: 800; margin: 0; display: flex; align-items: center; gap: 8px; color: #fff;">
          <span>📜</span> <span data-i18n="history_manage">Lịch Sử Giao Dịch & Nhận Coin</span>
        </h3>
        <p data-i18n="history_subtitle" style="color: var(--text-muted); font-size: 0.76rem; margin: 3px 0 0 0;">
          Toàn bộ lệnh Nạp, Rút, Mua máy, Hoán đổi và Nhận thưởng
        </p>
      </div>
      <div style="display: flex; align-items: center; gap: 8px;">
        <button class="btn btn-secondary btn-sm" onclick="loadHistory()" title="Làm mới" data-i18n="history_btn_refresh" style="padding: 4px 10px; font-size: 0.74rem;">🔄 Làm mới</button>
        <button class="modal-close" onclick="closeModal('historyModal')">&times;</button>
      </div>
    </div>

    <!-- Category Filters -->
    <div style="display: flex; gap: 6px; overflow-x: auto; padding-bottom: 8px; margin-bottom: 12px; width: 100%; max-width: 100%; min-width: 0; box-sizing: border-box; -webkit-overflow-scrolling: touch;">
      <button class="btn btn-sm btn-primary tx-filter-btn" data-type="all" onclick="filterHistory('all')" data-i18n="tx_filter_all" style="flex-shrink: 0; font-size: 0.74rem; padding: 4px 10px;">Tất cả</button>
      <button class="btn btn-sm btn-secondary tx-filter-btn" data-type="deposit" onclick="filterHistory('deposit')" data-i18n="tx_filter_deposit" style="flex-shrink: 0; font-size: 0.74rem; padding: 4px 10px;">Nạp USDT</button>
      <button class="btn btn-sm btn-secondary tx-filter-btn" data-type="withdraw" onclick="filterHistory('withdraw')" data-i18n="tx_filter_withdraw" style="flex-shrink: 0; font-size: 0.74rem; padding: 4px 10px;">Rút USDT</button>
      <button class="btn btn-sm btn-secondary tx-filter-btn" data-type="buy_miner" onclick="filterHistory('buy_miner')" data-i18n="tx_filter_buy" style="flex-shrink: 0; font-size: 0.74rem; padding: 4px 10px;">Mua máy</button>
      <button class="btn btn-sm btn-secondary tx-filter-btn" data-type="swap" onclick="filterHistory('swap')" data-i18n="tx_filter_swap" style="flex-shrink: 0; font-size: 0.74rem; padding: 4px 10px;">Đổi coin</button>
      <button class="btn btn-sm btn-secondary tx-filter-btn" data-type="claim" onclick="filterHistory('claim')" data-i18n="tx_filter_claim" style="flex-shrink: 0; font-size: 0.74rem; padding: 4px 10px;">Nhận thưởng</button>
    </div>

    <!-- Table Container -->
    <div class="table-wrapper" style="flex: 1; max-height: 52vh; overflow-y: auto; overflow-x: auto; width: 100%; max-width: 100%; min-width: 0; box-sizing: border-box; -webkit-overflow-scrolling: touch;">
      <table class="custom-table" style="font-size: 0.8rem; min-width: 520px;">
        <thead>
          <tr>
            <th data-i18n="tx_th_code">Mã GD</th>
            <th data-i18n="tx_th_type">Loại</th>
            <th data-i18n="tx_th_amount">Số Lượng</th>
            <th data-i18n="tx_th_detail">Chi Tiết</th>
            <th data-i18n="tx_th_time">Thời Gian</th>
            <th data-i18n="tx_th_status">Trạng Thái</th>
          </tr>
        </thead>
        <tbody id="historyTableBody">
          <!-- Rendered via JS -->
        </tbody>
      </table>
    </div>

    <div style="margin-top: 14px; display: flex; justify-content: flex-end;">
      <button class="btn btn-secondary" onclick="closeModal('historyModal')" data-i18n="history_btn_close" style="padding: 8px 20px; font-size: 0.84rem;">Đóng</button>
    </div>
  </div>
</div>

<!-- Modal 2: Adjust User Balance (Admin) -->
<div id="adjustBalanceModal" class="modal-overlay">
  <div class="modal-content">
    <div class="modal-header">
      <h3 style="font-size: 1.2rem; font-weight: 700;">Điều Chỉnh Số Dư</h3>
      <button class="modal-close" onclick="closeModal('adjustBalanceModal')">&times;</button>
    </div>
    <p style="font-size: 0.84rem; color: var(--text-muted); margin-bottom: 14px;">
      Tài khoản: <strong id="adjUserEmail" style="color: #fff;"></strong>
    </p>
    <form id="adjustBalanceForm">
      <input type="hidden" id="adjUserId">
      <div class="form-group">
        <label class="form-label">Thay đổi số dư USDT (+ để cộng, - để trừ)</label>
        <input type="number" step="any" id="adjUsdtAmount" class="form-input" placeholder="VD: 50 hoặc -20">
      </div>
      <div class="form-group">
        <label class="form-label">Thay đổi số dư Coin (+ để cộng, - để trừ)</label>
        <input type="number" step="any" id="adjCoinAmount" class="form-input" placeholder="VD: 100 hoặc -50">
      </div>
      <div class="form-group">
        <label class="form-label">Lý do điều chỉnh</label>
        <input type="text" id="adjReason" class="form-input" placeholder="Thưởng sự kiện, bù mạng..." required>
      </div>
      <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 8px;">
        Xác Nhận Cập Nhật
      </button>
    </form>
  </div>
</div>

<!-- Modal 3: Add Miner (Admin) -->
<div id="addMinerModal" class="modal-overlay">
  <div class="modal-content">
    <div class="modal-header">
      <h3 style="font-size: 1.2rem; font-weight: 700;">Thêm Gói Máy Đào Mới</h3>
      <button class="modal-close" onclick="closeModal('addMinerModal')">&times;</button>
    </div>
    <form id="addMinerForm">
      <div class="form-group">
        <label class="form-label">Tên máy đào</label>
        <input type="text" id="newMinerName" class="form-input" placeholder="VD: Avalon Hydro Rig" required>
      </div>
      <div class="form-group">
        <label class="form-label">Phân khúc (Tier)</label>
        <input type="text" id="newMinerTier" class="form-input" value="Enterprise Rig">
      </div>
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
        <div class="form-group">
          <label class="form-label">Hashrate (TH/s)</label>
          <input type="number" step="any" id="newMinerHashrate" class="form-input" value="600" required>
        </div>
        <div class="form-group">
          <label class="form-label">Giá bán (USDT)</label>
          <input type="number" step="any" id="newMinerPrice" class="form-input" value="250" required>
        </div>
      </div>
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
        <div class="form-group">
          <label class="form-label">Sản lượng (Coin/ngày)</label>
          <input type="number" step="any" id="newMinerDaily" class="form-input" value="85" required>
        </div>
        <div class="form-group">
          <label class="form-label">Điện năng</label>
          <input type="text" id="newMinerPower" class="form-input" value="500W">
        </div>
      </div>
      <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 8px;">
        Thêm Vào Cửa Hàng
      </button>
    </form>
  </div>
</div>

<script src="assets/js/i18n.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>
