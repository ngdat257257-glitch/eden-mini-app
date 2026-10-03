// assets/js/app.js

const State = {
  user: null,
  settings: {
    coin_name: 'Minex Coin',
    coin_symbol: 'MNX',
    coin_price_usdt: 0.001,
    usdt_deposit_address: '0x596b41afd2b5f6336a3171898752c2265ae86878',
    network: 'USDT (BEP20)',
    min_deposit: 10,
    min_withdraw: 15,
    withdraw_fee_percent: 2.5
  },
  activeTab: 'dashboard',
  miningData: null,
  liveReward: 0,
  minersCatalog: [],
  transactions: [],
  adminData: null
};

// API Helper
async function apiCall(endpoint, method = 'GET', data = null) {
  const options = {
    method,
    headers: {
      'Content-Type': 'application/json'
    }
  };

  const token = localStorage.getItem('minex_token');
  if (token) {
    options.headers['Authorization'] = `Bearer ${token}`;
  }

  if (data && (method === 'POST' || method === 'PUT')) {
    options.body = JSON.stringify(data);
  }

  try {
    const res = await fetch(endpoint, options);
    const result = await res.json();
    if (!res.ok) {
      throw new Error(result.error || 'Có lỗi xảy ra');
    }
    return result;
  } catch (err) {
    console.error(`API Error on ${endpoint}:`, err);
    throw err;
  }
}

// Toast Alert Helper
function showToast(message, type = 'success') {
  const container = document.getElementById('toastContainer');
  if (!container) return;

  const toast = document.createElement('div');
  toast.className = `alert alert-${type}`;
  toast.style.animation = 'fadeIn 0.2s ease';
  toast.innerHTML = `
    <span>${type === 'success' ? '✅' : '⚠️'}</span>
    <span style="flex: 1">${message}</span>
  `;

  container.appendChild(toast);
  setTimeout(() => {
    toast.style.opacity = '0';
    setTimeout(() => toast.remove(), 250);
  }, 4500);
}

// Navigation & Tab Switching
function switchTab(tabId) {
  // If user clicks or requests 'history', redirect seamlessly to the user page and open history modal
  if (tabId === 'history') {
    switchTab('user');
    setTimeout(() => {
      openHistoryModal();
    }, 120);
    return;
  }

  State.activeTab = tabId;

  // Toggle tab body classes to control navbar visibility on mobile / iphone frame
  if (tabId === 'wallet') {
    document.body.classList.add('tab-wallet-active');
  } else {
    document.body.classList.remove('tab-wallet-active');
  }
  if (tabId === 'user') {
    document.body.classList.add('tab-user-active');
  } else {
    document.body.classList.remove('tab-user-active');
  }

  // Update Top Nav Items
  document.querySelectorAll('.nav-item').forEach(el => {
    if (el.dataset.tab === tabId) {
      el.classList.add('active');
    } else {
      el.classList.remove('active');
    }
  });

  // Update Bottom Nav Items
  document.querySelectorAll('.bottom-nav-btn').forEach(el => {
    if (el.dataset.tab === tabId) {
      el.classList.add('active');
    } else {
      el.classList.remove('active');
    }
  });

  // Close Mobile Drawer
  closeDrawer();

  // Show/Hide Page Sections
  document.querySelectorAll('.tab-page').forEach(page => {
    if (page.id === `page-${tabId}`) {
      page.style.display = 'block';
    } else {
      page.style.display = 'none';
    }
  });

  // Reset scroll to top when switching tabs (unless transitioning to history anchor)
  if (tabId !== 'history') {
    const scrollContainer = document.getElementById('iphoneContentScroll');
    if (scrollContainer) scrollContainer.scrollTop = 0;
    window.scrollTo(0, 0);
  }

  // Load Data for Active Tab
  if (tabId === 'dashboard') loadDashboard();
  if (tabId === 'store') loadStore();
  if (tabId === 'wallet') loadWallet();
  if (tabId === 'admin') loadAdmin();
  if (tabId === 'about') loadReferralData();
  if (tabId === 'user') {
    updateUserInterface();
    if (State.user) loadHistory();
  }
}

function openHistoryModal(e) {
  if (e) {
    e.preventDefault();
    e.stopPropagation();
  }
  loadHistory();
  openModal('historyModal');
}
window.openHistoryModal = openHistoryModal;

function scrollToUserHistory() {
  openHistoryModal();
}
window.scrollToUserHistory = scrollToUserHistory;

function openBuybackView() {
  const mainView = document.getElementById('userWalletMainView');
  const buybackView = document.getElementById('userBuybackView');
  if (mainView && buybackView) {
    mainView.style.display = 'none';
    buybackView.style.display = 'flex';
  }
  const balDisplay = document.getElementById('buybackBalanceDisplay');
  if (balDisplay && State.user) {
    balDisplay.innerText = Number(State.user.usdt_balance || 0).toFixed(2);
  }
  const amountInput = document.getElementById('buybackAmountInput');
  if (amountInput) amountInput.value = '';
  const codeInput = document.getElementById('buyback2faInput');
  if (codeInput) codeInput.value = '';
}
window.openBuybackView = openBuybackView;

function closeBuybackView() {
  const mainView = document.getElementById('userWalletMainView');
  const buybackView = document.getElementById('userBuybackView');
  if (mainView && buybackView) {
    buybackView.style.display = 'none';
    mainView.style.display = 'flex';
  }
}
window.closeBuybackView = closeBuybackView;

function toggleWalletSwapPanel(subtab = 'swap') {
  const panel = document.getElementById('walletExtraPanel');
  if (!panel) return;
  if (panel.style.display === 'none' || !panel.style.display) {
    panel.style.display = 'block';
    if (subtab) switchWalletTab(subtab);
    panel.scrollIntoView({ behavior: 'smooth' });
  } else {
    if (subtab) {
      switchWalletTab(subtab);
    } else {
      panel.style.display = 'none';
    }
  }
}
window.toggleWalletSwapPanel = toggleWalletSwapPanel;

function copyMyUid() {
  const uid = (State.user && State.user.uid) ? State.user.uid : '120850';
  navigator.clipboard.writeText(uid);
  showToast('Đã sao chép mã UID: ' + uid, 'info');
}
window.copyMyUid = copyMyUid;

async function submitBuyback() {
  if (!State.user) {
    showToast('Vui lòng đăng nhập để thực hiện', 'warning');
    return;
  }
  const elAmount = document.getElementById('buybackAmountInput');
  const elAddress = document.getElementById('buybackAddressInput');
  const amount = parseFloat(elAmount ? elAmount.value : 0);
  const address = elAddress ? elAddress.value.trim() : '0xd90e17f8a8a6c0b749028b23828e7c188652ebbc';

  if (!amount || amount <= 0) {
    showToast('Vui lòng nhập số tiền rút hợp lệ', 'error');
    if (elAmount) elAmount.focus();
    return;
  }

  const currentUsdt = Number(State.user.usdt_balance || 0);
  if (amount > currentUsdt) {
    showToast(`Số dư không đủ. Bạn có ${currentUsdt.toFixed(2)} USDT`, 'error');
    return;
  }

  const btn = document.getElementById('btnSubmitBuyback');
  if (btn) {
    btn.disabled = true;
    btn.innerText = 'Đang xử lý...';
  }

  try {
    const res = await apiCall('api/wallet.php?action=withdraw', 'POST', {
      amount: amount,
      address: address
    });

    if (res.success) {
      showToast(`Yêu cầu mua lại / rút tiền ${amount} USDT đã được gửi thành công!`, 'success');
      State.user.usdt_balance = Math.max(0, currentUsdt - amount);
      updateAuthUI();
      closeBuybackView();
    } else {
      showToast(res.error || 'Có lỗi xảy ra', 'error');
    }
  } catch (err) {
    showToast(err.message || 'Lỗi khi gửi yêu cầu mua lại', 'error');
  } finally {
    if (btn) {
      btn.disabled = false;
      btn.innerText = 'Mua lại';
    }
  }
}
window.submitBuyback = submitBuyback;

function openDrawer() {
  const el = document.getElementById('mobileDrawer');
  if (el) el.classList.add('active');
}

function closeDrawer() {
  const el = document.getElementById('mobileDrawer');
  if (el) el.classList.remove('active');
}

// Modals
function openModal(modalId) {
  const el = document.getElementById(modalId);
  if (el) el.classList.add('active');
}

function closeModal(modalId) {
  const el = document.getElementById(modalId);
  if (el) el.classList.remove('active');
}

function openTermsModal(e) {
  if (e) {
    e.preventDefault();
    e.stopPropagation();
  }
  openModal('termsModal');
}
window.openTermsModal = openTermsModal;

// Global App Initialization
document.addEventListener('DOMContentLoaded', async () => {
  setupEventListeners();
  initIphoneSimulator();
  initReferralTracking();
  if (window.initI18n) window.initI18n();
  await checkSession();
  switchTab('dashboard');

  // Start live ticker
  setInterval(liveTicker, 100);
});

function setupEventListeners() {
  // Navigation clicks
  document.querySelectorAll('[data-tab]').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      switchTab(btn.dataset.tab);
    });
  });

  // Auth toggle
  const toRegister = document.getElementById('linkToRegister');
  const toLogin = document.getElementById('linkToLogin');
  if (toRegister) {
    toRegister.addEventListener('click', (e) => {
      e.preventDefault();
      document.getElementById('loginForm').style.display = 'none';
      document.getElementById('registerForm').style.display = 'block';
      document.getElementById('authModalTitle').innerText = 'Tạo Tài Khoản Thợ Đào';
    });
  }
  if (toLogin) {
    toLogin.addEventListener('click', (e) => {
      e.preventDefault();
      document.getElementById('registerForm').style.display = 'none';
      document.getElementById('loginForm').style.display = 'block';
      document.getElementById('authModalTitle').innerText = 'Đăng Nhập Tài Khoản';
    });
  }

  // Quick Demo Logins
  const btnUserDemo = document.getElementById('btnUserDemo');
  const btnAdminDemo = document.getElementById('btnAdminDemo');
  if (btnUserDemo) {
    btnUserDemo.addEventListener('click', () => quickLogin('user'));
  }
  if (btnAdminDemo) {
    btnAdminDemo.addEventListener('click', () => quickLogin('admin'));
  }

  // Login Submit
  const loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', handleLogin);
  }

  // Register Submit
  const registerForm = document.getElementById('registerForm');
  if (registerForm) {
    registerForm.addEventListener('submit', handleRegister);
  }

  // User Page Form Submissions
  const userPageLoginForm = document.getElementById('userPageLoginForm');
  if (userPageLoginForm) {
    userPageLoginForm.addEventListener('submit', handleUserPageLogin);
  }
  const userPageRegisterForm = document.getElementById('userPageRegisterForm');
  if (userPageRegisterForm) {
    userPageRegisterForm.addEventListener('submit', handleUserPageRegister);
  }

  // Deposit Form
  const depositForm = document.getElementById('depositForm');
  if (depositForm) {
    depositForm.addEventListener('submit', handleDeposit);
  }

  // Withdraw Form
  const withdrawForm = document.getElementById('withdrawForm');
  if (withdrawForm) {
    withdrawForm.addEventListener('submit', handleWithdraw);
  }

  // Swap Form
  const swapForm = document.getElementById('swapForm');
  if (swapForm) {
    swapForm.addEventListener('submit', handleSwap);
  }

  // Admin Settings Form
  const adminSettingsForm = document.getElementById('adminSettingsForm');
  if (adminSettingsForm) {
    adminSettingsForm.addEventListener('submit', handleSaveAdminSettings);
  }

  // Admin Add Miner Form
  const addMinerForm = document.getElementById('addMinerForm');
  if (addMinerForm) {
    addMinerForm.addEventListener('submit', handleAddMiner);
  }

  // Admin Adjust Balance Form
  const adjustBalanceForm = document.getElementById('adjustBalanceForm');
  if (adjustBalanceForm) {
    adjustBalanceForm.addEventListener('submit', handleSaveAdjustBalance);
  }

  // Close modals when clicking overlay
  document.querySelectorAll('.modal-overlay').forEach(modal => {
    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.classList.remove('active');
      }
    });
  });
}

// -------------------------------------------------------------
// AUTH FUNCTIONS
// -------------------------------------------------------------
async function checkSession() {
  try {
    let token = localStorage.getItem('minex_token');
    if (!token) {
      // Auto login as demo miner (UID: 120850) by default so user page and full features are immediately active
      const loginRes = await apiCall('api/auth.php?action=login', 'POST', { email: 'user@mining.io', password: 'user123' });
      localStorage.setItem('minex_token', loginRes.token);
      State.user = loginRes.user;
    } else {
      const res = await apiCall('api/auth.php?action=me');
      State.user = res.user;
      if (res.settings) State.settings = res.settings;
    }
    updateUserInterface();
    loadHistory();
  } catch (err) {
    try {
      const loginRes = await apiCall('api/auth.php?action=login', 'POST', { email: 'user@mining.io', password: 'user123' });
      localStorage.setItem('minex_token', loginRes.token);
      State.user = loginRes.user;
      updateUserInterface();
      loadHistory();
    } catch (e) {
      State.user = null;
      updateUserInterface();
    }
  }
}

function updateUserInterface() {
  const loggedOutNav = document.getElementById('loggedOutNav');
  const loggedInNav = document.getElementById('loggedInNav');
  const navLogoutBtn = document.getElementById('navLogoutBtn');
  const adminNavItems = document.querySelectorAll('.admin-only');

  const userPageLoggedOut = document.getElementById('userPageLoggedOut');
  const userPageLoggedIn = document.getElementById('userPageLoggedIn');

  if (State.user) {
    if (loggedOutNav) loggedOutNav.style.display = 'none';
    if (loggedInNav) loggedInNav.style.display = 'flex';
    if (navLogoutBtn) navLogoutBtn.style.display = 'inline-flex';

    if (userPageLoggedOut) userPageLoggedOut.style.display = 'none';
    if (userPageLoggedIn) userPageLoggedIn.style.display = 'flex';

    // Populate user profile info on User page
    const elName = document.getElementById('userProfileName');
    const elEmail = document.getElementById('userProfileEmail');
    const elBadge = document.getElementById('userProfileRoleBadge');
    const elInitial = document.getElementById('userProfileInitial');
    const elNavName = document.querySelector('.user-name-display');

    const uid = State.user.uid || (State.user.id === 'user_demo' ? '120850' : (State.user.id === 'user_admin' ? '10001' : (State.user.id ? State.user.id.replace(/\D/g, '').slice(-6) : '120850')));
    document.querySelectorAll('.user-uid-display').forEach(el => {
      el.innerText = uid;
    });

    if (elName) elName.innerText = State.user.name || 'Thợ Đào';
    if (elEmail) elEmail.innerText = State.user.email || '';
    if (elInitial) {
      const initial = (State.user.name || 'M').charAt(0).toUpperCase();
      elInitial.innerText = initial;
    }
    if (elNavName) elNavName.innerText = `UID: ${uid}`;
    if (elBadge) {
      elBadge.innerText = 'Level 10';
      elBadge.style.color = '#1e1b18';
      elBadge.style.background = '#dfc5b2';
      elBadge.style.borderColor = 'transparent';
      elBadge.style.borderRadius = '9999px';
      elBadge.style.padding = '3px 12px';
      elBadge.style.fontWeight = '600';
    }
    document.querySelectorAll('.nav-level-badge').forEach(el => {
      el.innerText = 'Level 10';
    });

    // Update balances
    document.querySelectorAll('.user-usdt-balance').forEach(el => {
      el.innerText = Number(State.user.usdt_balance || 0).toFixed(2);
    });
    document.querySelectorAll('.user-coin-balance').forEach(el => {
      const val = Number(State.user.coin_balance || 0);
      el.innerText = val.toFixed(6);
    });
    document.querySelectorAll('.coin-symbol').forEach(el => {
      el.innerText = State.settings.coin_symbol || 'EDEN';
    });
    const elEquiv = document.getElementById('userPageEquivUsdt');
    if (elEquiv) {
      const price = (State.settings && parseFloat(State.settings.coin_price_usdt)) ? parseFloat(State.settings.coin_price_usdt) : 0.0001;
      elEquiv.innerText = (Number(State.user.coin_balance || 0) * price).toFixed(6);
    }
    const elProfileEquiv = document.getElementById('userProfileEquivUsdt');
    if (elProfileEquiv) {
      const price = (State.settings && parseFloat(State.settings.coin_price_usdt)) ? parseFloat(State.settings.coin_price_usdt) : 0.0001;
      elProfileEquiv.innerText = (Number(State.user.coin_balance || 0) * price).toFixed(4);
    }

    // Admin toggle
    adminNavItems.forEach(el => {
      el.style.display = State.user.role === 'admin' ? 'flex' : 'none';
    });
  } else {
    if (loggedOutNav) loggedOutNav.style.display = 'flex';
    if (loggedInNav) loggedInNav.style.display = 'none';
    if (navLogoutBtn) navLogoutBtn.style.display = 'none';

    if (userPageLoggedOut) userPageLoggedOut.style.display = 'block';
    if (userPageLoggedIn) userPageLoggedIn.style.display = 'none';

    const elNavName = document.querySelector('.user-name-display');
    if (elNavName) elNavName.innerText = 'User';

    adminNavItems.forEach(el => { el.style.display = 'none'; });
  }
}

function setUserAuthMode(mode) {
  const loginForm = document.getElementById('userPageLoginForm');
  const regForm = document.getElementById('userPageRegisterForm');
  const btnLogin = document.getElementById('userBtnTabLogin');
  const btnReg = document.getElementById('userBtnTabRegister');
  const title = document.getElementById('userPageTitle');
  const subtitle = document.getElementById('userPageSubtitle');

  const currentLangCode = localStorage.getItem('minex_lang') || 'vi';
  const dict = (window.I18N_DICTIONARY && window.I18N_DICTIONARY[currentLangCode]) ? window.I18N_DICTIONARY[currentLangCode] : {};

  if (mode === 'register') {
    if (loginForm) loginForm.style.display = 'none';
    if (regForm) regForm.style.display = 'block';
    if (btnLogin) {
      btnLogin.style.background = 'transparent';
      btnLogin.style.color = 'var(--text-muted)';
    }
    if (btnReg) {
      btnReg.style.background = 'var(--primary)';
      btnReg.style.color = '#fff';
    }
    if (title) title.innerText = dict.btn_register ? `${dict.btn_register} MINEX` : 'Đăng Ký MINEX';
    if (subtitle) subtitle.innerText = dict.user_subtitle || 'Tạo tài khoản thợ đào và nhận 100 USDT trải nghiệm';
  } else {
    if (loginForm) loginForm.style.display = 'block';
    if (regForm) regForm.style.display = 'none';
    if (btnLogin) {
      btnLogin.style.background = 'var(--primary)';
      btnLogin.style.color = '#fff';
    }
    if (btnReg) {
      btnReg.style.background = 'transparent';
      btnReg.style.color = 'var(--text-muted)';
    }
    if (title) title.innerText = dict.user_title || 'Tài Khoản MINEX';
    if (subtitle) subtitle.innerText = dict.user_subtitle || 'Đăng nhập hoặc đăng ký tài khoản thợ đào';
  }
}
window.setUserAuthMode = setUserAuthMode;

async function quickLogin(role) {
  const email = role === 'admin' ? 'admin@mining.io' : 'user@mining.io';
  const password = role === 'admin' ? 'admin123' : 'user123';
  try {
    const res = await apiCall('api/auth.php?action=login', 'POST', { email, password });
    localStorage.setItem('minex_token', res.token);
    State.user = res.user;
    closeModal('authModal');
    updateUserInterface();
    loadHistory();
    showToast(`Đăng nhập thành công với vai trò ${role.toUpperCase()}!`, 'success');
    if (State.activeTab !== 'user') {
      switchTab('dashboard');
    }
  } catch (err) {
    showToast(err.message, 'error');
  }
}

async function handleLogin(e) {
  e.preventDefault();
  const agree = document.getElementById('loginAgreeTerms');
  if (agree && !agree.checked) {
    showToast('Vui lòng tích chọn đồng ý với Điều khoản dịch vụ & Tuyên bố miễn trừ!', 'warning');
    return;
  }

  const email = document.getElementById('loginEmail').value;
  const password = document.getElementById('loginPassword').value;

  try {
    const res = await apiCall('api/auth.php?action=login', 'POST', { email, password });
    localStorage.setItem('minex_token', res.token);
    State.user = res.user;
    closeModal('authModal');
    updateUserInterface();
    showToast('Đăng nhập thành công!', 'success');
    if (State.activeTab !== 'user') {
      switchTab('dashboard');
    }
  } catch (err) {
    showToast(err.message, 'error');
  }
}

async function handleRegister(e) {
  e.preventDefault();
  const agree = document.getElementById('regAgreeTerms');
  if (agree && !agree.checked) {
    showToast('Vui lòng tích chọn đồng ý với Điều khoản sử dụng & Tuyên bố miễn trừ rủi ro!', 'warning');
    return;
  }

  const name = document.getElementById('regName').value;
  const email = document.getElementById('regEmail').value;
  const password = document.getElementById('regPassword').value;
  const ref = (document.getElementById('regRefCode')?.value || localStorage.getItem('minex_ref') || '').trim();

  try {
    const res = await apiCall('api/auth.php?action=register', 'POST', { name, email, password, ref });
    localStorage.setItem('minex_token', res.token);
    State.user = res.user;
    closeModal('authModal');
    updateUserInterface();
    showToast(res.message, 'success');
    if (State.activeTab !== 'user') {
      switchTab('dashboard');
    }
  } catch (err) {
    showToast(err.message, 'error');
  }
}

async function handleUserPageLogin(e) {
  e.preventDefault();
  const agree = document.getElementById('userPageLoginAgreeTerms');
  if (agree && !agree.checked) {
    showToast('Vui lòng tích chọn đồng ý với Điều khoản dịch vụ & Tuyên bố miễn trừ!', 'warning');
    return;
  }

  const email = document.getElementById('userPageLoginEmail').value;
  const password = document.getElementById('userPageLoginPassword').value;

  try {
    const res = await apiCall('api/auth.php?action=login', 'POST', { email, password });
    localStorage.setItem('minex_token', res.token);
    State.user = res.user;
    updateUserInterface();
    showToast('Đăng nhập thành công!', 'success');
  } catch (err) {
    showToast(err.message, 'error');
  }
}

async function handleUserPageRegister(e) {
  e.preventDefault();
  const agree = document.getElementById('userPageRegAgreeTerms');
  if (agree && !agree.checked) {
    showToast('Vui lòng tích chọn đồng ý với Điều khoản sử dụng & Tuyên bố miễn trừ rủi ro!', 'warning');
    return;
  }

  const name = document.getElementById('userPageRegName').value;
  const email = document.getElementById('userPageRegEmail').value;
  const password = document.getElementById('userPageRegPassword').value;
  const ref = (document.getElementById('userPageRegRefCode')?.value || localStorage.getItem('minex_ref') || '').trim();

  try {
    const res = await apiCall('api/auth.php?action=register', 'POST', { name, email, password, ref });
    localStorage.setItem('minex_token', res.token);
    State.user = res.user;
    updateUserInterface();
    showToast(res.message, 'success');
  } catch (err) {
    showToast(err.message, 'error');
  }
}

async function handleLogout() {
  localStorage.removeItem('minex_token');
  await apiCall('api/auth.php?action=logout');
  State.user = null;
  updateUserInterface();
  showToast('Đã đăng xuất tài khoản', 'info');
  if (State.activeTab !== 'user') {
    switchTab('dashboard');
  }
}

// -------------------------------------------------------------
// DASHBOARD & MINING ENGINE
// -------------------------------------------------------------
async function loadDashboard() {
  if (!State.user) return;
  try {
    const data = await apiCall('api/mining.php?action=status');
    State.miningData = data;
    State.liveReward = data.unclaimed_reward || 0;

    // Update stats (safely if elements exist)
    const elHashrate = document.getElementById('dashTotalHashrate');
    if (elHashrate) elHashrate.innerText = data.total_hashrate.toLocaleString();
    const elMinersCount = document.getElementById('dashMinersCount');
    if (elMinersCount) elMinersCount.innerText = `${data.active_miners_count} máy đang vận hành`;
    const elDailyYield = document.getElementById('dashDailyYield');
    if (elDailyYield) elDailyYield.innerText = data.total_daily_yield.toFixed(2);
    const estUsdt = (data.total_daily_yield * data.coin_price_usdt).toFixed(2);
    const elDailyUsdt = document.getElementById('dashDailyUsdt');
    if (elDailyUsdt) elDailyUsdt.innerText = `≈ $${estUsdt} USDT / ngày`;
    const elCoinPrice = document.getElementById('dashCoinPrice');
    if (elCoinPrice) elCoinPrice.innerText = `$${parseFloat(data.coin_price_usdt)}`;

    // Tốc độ đào theo giờ (EDEN / H)
    const elSpeedHour = document.getElementById('liveSpeedPerHour');
    if (elSpeedHour) {
      const perHour = data.total_daily_yield / 24;
      elSpeedHour.innerText = `${perHour.toFixed(2)} ${data.coin_symbol || 'EDEN'} / H`;
    }

    // Rig Status & Fans
    const hasMiners = data.active_miners_count > 0;
    const rigStatusBadge = document.getElementById('rigStatusBadge');
    if (rigStatusBadge) {
      rigStatusBadge.innerHTML = hasMiners
        ? '<span class="pulse-dot"></span><span>HỆ THỐNG ĐANG ĐÀO COIN (ACTIVE)</span>'
        : '<span class="pulse-dot" style="background:#64748b"></span><span>CHƯA KÍCH HOẠT MÁY ĐÀO</span>';
    }

    document.querySelectorAll('.fan').forEach(fan => {
      if (hasMiners) {
        fan.classList.remove('idle');
      } else {
        fan.classList.add('idle');
      }
    });

    // 24h claim countdown setup
    if (data.next_claim_in_ms > 0) {
      State.nextClaimTargetTime = Date.now() + data.next_claim_in_ms;
    } else {
      State.nextClaimTargetTime = 0;
    }
    updateClaimButtonState();

    renderActiveMinersTable(data.active_miners);
  } catch (err) {
    console.error('Failed to load dashboard:', err);
  }
}

// Trạng thái đào: đang đào (đếm ngược 24h) -> đủ 24h thì DỪNG, phải Claim mới chạy tiếp
function isMiningCycleComplete() {
  if (!State.miningData || State.miningData.active_miners_count === 0) return false;
  return State.miningData.can_claim || (State.nextClaimTargetTime > 0 && Date.now() >= State.nextClaimTargetTime);
}

function updateClaimButtonState() {
  const btn = document.getElementById('btnClaimReward');
  const textEl = document.getElementById('btnClaimText');
  const countdownEl = document.getElementById('claimCountdownText');
  const labelEl = document.getElementById('mineTimerLabel');

  if (!btn || !State.miningData) return;

  btn.classList.remove('ready', 'idle');

  // Chưa có máy đào
  if (!State.user || State.miningData.active_miners_count === 0) {
    btn.disabled = false;
    btn.classList.add('idle');
    if (textEl) textEl.innerText = 'Start';
    if (countdownEl) countdownEl.innerText = '00H 00M 00S';
    if (labelEl) labelEl.innerText = 'Buy a miner to start';
    return;
  }

  if (isMiningCycleComplete()) {
    // Đã đủ 24h: máy dừng đào, chờ khách Claim
    State.miningData.can_claim = true;
    btn.disabled = false;
    btn.classList.add('ready');
    if (textEl) textEl.innerText = 'Claim';
    if (countdownEl) countdownEl.innerText = '00H 00M 00S';
    if (labelEl) labelEl.innerText = 'Mining stopped • Claim to restart';
  } else {
    const remainingMs = Math.max(0, (State.nextClaimTargetTime || 0) - Date.now());
    const totalSec = Math.floor(remainingMs / 1000);
    const hrs = String(Math.floor(totalSec / 3600)).padStart(2, '0');
    const mins = String(Math.floor((totalSec % 3600) / 60)).padStart(2, '0');
    const secs = String(totalSec % 60).padStart(2, '0');

    btn.disabled = true;
    if (textEl) textEl.innerText = 'Mining';
    if (countdownEl) countdownEl.innerText = `${hrs}H ${mins}M ${secs}S`;
    if (labelEl) labelEl.innerText = 'Time until next start';
  }
}

function showMiningInfo() {
  showToast('⛏️ Mỗi phiên đào kéo dài 24 giờ. Hết 24h máy sẽ dừng, bấm Claim để nhận coin và bắt đầu phiên mới.', 'info');
}
window.showMiningInfo = showMiningInfo;

function liveTicker() {
  if (!State.miningData || State.miningData.total_daily_yield <= 0) return;
  // Đủ 24h thì dừng tích luỹ, chờ Claim
  if (!isMiningCycleComplete()) {
    const yieldPerSecond = State.miningData.total_daily_yield / 86400;
    State.liveReward = Math.min(State.liveReward + yieldPerSecond * 0.1, State.miningData.total_daily_yield);
  }

  const counterEl = document.getElementById('liveCoinCounter');
  if (counterEl) {
    counterEl.innerText = State.liveReward.toFixed(6);
  }

  const rewardUsdtEl = document.getElementById('liveRewardUsdt');
  if (rewardUsdtEl) {
    const coinPrice = (State.settings && State.settings.coin_price_usdt) ? parseFloat(State.settings.coin_price_usdt) : 0.001;
    rewardUsdtEl.innerHTML = `<span style="display: inline-flex; align-items: center; gap: 5px; background: #000; padding: 3px 10px 3px 6px; border-radius: 14px; border: 1px solid rgba(38,161,123,0.3); box-shadow: 0 2px 8px rgba(0,0,0,0.6);"><img src="assets/usdt.png" alt="USDT" style="width: 14px; height: 14px; border-radius: 50%;"> ≈ $${(State.liveReward * coinPrice).toFixed(4)} <span style="color:#26a17b; font-weight:700;">USDT</span></span>`;
  }

  updateClaimButtonState();
}

async function claimReward() {
  if (!State.user) {
    showToast('Vui lòng đăng nhập để nhận thưởng!', 'warning');
    switchTab('user');
    return;
  }
  if (State.miningData && State.miningData.active_miners_count === 0) {
    switchTab('store');
    return;
  }
  if (State.miningData && !isMiningCycleComplete()) {
    showToast('Máy đang đào. Vui lòng chờ hết 24 giờ để Claim!', 'warning');
    return;
  }
  if (State.liveReward < 0.00001) {
    showToast('Chưa có coin để nhận thưởng hoặc đang tích luỹ...', 'info');
    return;
  }
  const btn = document.getElementById('btnClaimReward');
  if (btn) btn.disabled = true;

  try {
    const res = await apiCall('api/mining.php?action=claim', 'POST');
    showToast(res.message, 'success');
    State.liveReward = 0;
    await checkSession();
    await loadDashboard();
  } catch (err) {
    showToast(err.message, 'error');
  } finally {
    if (btn) btn.disabled = false;
  }
}
window.claimReward = claimReward;

function renderActiveMinersTable(miners = []) {
  const container = document.getElementById('activeMinersList');
  if (!container) return;

  if (miners.length === 0) {
    container.innerHTML = `
      <tr>
        <td colspan="5" style="text-align:center; padding: 25px 10px; color: var(--text-muted);">
          <div style="font-size: 1.6rem; margin-bottom: 6px;">⛏️</div>
          <p style="margin: 0; font-size: 0.86rem;">Bạn chưa sở hữu gói máy đào nào.</p>
          <button class="btn btn-primary btn-sm" style="margin-top: 10px;" onclick="switchTab('store')">
            Xem Các Gói Máy Đào
          </button>
        </td>
      </tr>
    `;
    return;
  }

  const coinPrice = (State.settings && State.settings.coin_price_usdt) ? parseFloat(State.settings.coin_price_usdt) : 0.001;
  const coinSymbol = (State.settings && State.settings.coin_symbol) || 'MNX';

  container.innerHTML = miners.map(m => {
    const perSec = (m.daily_yield / 86400).toFixed(6);
    const dailyUsdt = (m.daily_yield * coinPrice).toFixed(2);
    return `
    <tr>
      <td>
        <strong style="color: #fff; font-size: 0.88rem;">${m.name}</strong>
        <div style="font-size: 0.72rem; color: var(--text-muted);">${m.tier || 'Máy Đào'}</div>
      </td>
      <td style="font-family: var(--font-mono); color: #22d3ee; font-weight: 700;">
        ${m.hashrate} ${m.unit || 'TH/s'}
      </td>
      <td style="font-family: var(--font-mono); color: #38bdf8; font-weight: 700;">
        +${perSec}/s
      </td>
      <td style="font-family: var(--font-mono); color: #fbbf24; font-weight: 700;">
        +${Number(m.daily_yield).toLocaleString()} ${coinSymbol}
        <div style="font-size: 0.72rem; color: #fbbf24;">≈ $${dailyUsdt} USDT/ngày</div>
      </td>
      <td>
        <span class="badge badge-completed">Đang Đào</span>
      </td>
    </tr>
  `;
  }).join('');
}

// -------------------------------------------------------------
// MINERS STORE
// -------------------------------------------------------------
async function loadStore() {
  try {
    const res = await apiCall('api/miners.php?action=catalog');
    State.minersCatalog = res.miners || [];
    renderStoreMiners();
  } catch (err) {
    console.error('Failed to load store:', err);
  }
}

function renderStoreMiners() {
  const container = document.getElementById('storeMinersGrid');
  if (!container) return;

  const currentLangCode = localStorage.getItem('minex_lang') || 'vi';
  const dict = (window.I18N_DICTIONARY && window.I18N_DICTIONARY[currentLangCode]) ? window.I18N_DICTIONARY[currentLangCode] : (window.I18N_DICTIONARY ? window.I18N_DICTIONARY.vi : {});

  const coinPrice = (State.settings && State.settings.coin_price_usdt) ? parseFloat(State.settings.coin_price_usdt) : 0.001;
  const coinSymbol = (State.settings && State.settings.coin_symbol) || 'MNX';
  const userUsdt = State.user ? (State.user.usdt_balance || 0) : 0;

  container.innerHTML = State.minersCatalog.map(m => {
    const dailyCoins = m.daily_yield_coins || 0;
    const perSec = (dailyCoins / 86400).toFixed(6);
    const dailyUsdt = (dailyCoins * coinPrice).toFixed(2);
    const isAffordable = userUsdt >= m.price_usdt;

    return `
      <div class="glass-card miner-card col-3" style="border-radius: 18px; padding: 20px 18px; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
          <!-- Giá gói to rõ với Logo USDT trên nền đen -->
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <div>
              <span style="font-size: 0.72rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; letter-spacing: 0.04em; display: block; margin-bottom: 4px;">${dict.store_price || 'GIÁ GÓI'}</span>
              <div style="display: inline-flex; align-items: center; gap: 8px; background: #000; padding: 5px 12px 5px 6px; border-radius: 28px; border: 1px solid rgba(38,161,123,0.4); box-shadow: 0 4px 15px rgba(0,0,0,0.8), 0 0 10px rgba(38,161,123,0.25);">
                <img src="assets/usdt.png" alt="USDT" style="width: 26px; height: 26px; border-radius: 50%; box-shadow: 0 0 8px rgba(38,161,123,0.5); object-fit: contain; flex-shrink: 0;">
                <span style="font-size: 1.45rem; font-weight: 900; color: #fff; font-family: var(--font-mono); line-height: 1;">
                  $${Number(m.price_usdt).toLocaleString()} <span style="font-size: 0.82rem; color: #26a17b; font-weight: 800;">USDT</span>
                </span>
              </div>
            </div>
            <span class="badge" style="background: rgba(0,0,0,0.7); color: #fbbf24; border: 1px solid rgba(245,158,11,0.3); font-size: 0.72rem; padding: 4px 10px; border-radius: 20px; font-weight: 700; box-shadow: 0 2px 8px rgba(0,0,0,0.5);">● 24/7</span>
          </div>

          <h3 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 14px; color: #f1f5f9;">${m.name}</h3>

          <!-- Chỉ 3 thông số cốt lõi cực kỳ đơn giản & dễ hiểu -->
          <div style="background: rgba(0,0,0,0.35); border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; padding: 12px 14px; margin-bottom: 16px; display: flex; flex-direction: column; gap: 8px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <span style="font-size: 0.82rem; color: var(--text-muted);">${dict.store_speed || 'Tốc độ đào'}:</span>
              <span style="font-family: var(--font-mono); font-size: 0.95rem; font-weight: 700; color: #38bdf8;">+${perSec} ${coinSymbol}/s</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <span style="font-size: 0.82rem; color: var(--text-muted);">${dict.store_daily || 'Thu nhập'}:</span>
              <span style="font-family: var(--font-mono); font-size: 0.95rem; font-weight: 800; color: #fbbf24;">+${Number(dailyCoins).toLocaleString()} ${coinSymbol} <span style="color:#fbbf24; font-size:0.8rem; font-weight:600;">(≈ $${dailyUsdt})</span></span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <span style="font-size: 0.82rem; color: var(--text-muted);">Hoàn vốn:</span>
              <span style="font-family: var(--font-mono); font-size: 0.92rem; font-weight: 800; color: #34d399;">${dailyCoins > 0 ? Math.round(m.price_usdt / (dailyCoins * coinPrice)) : '--'} ngày</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <span style="font-size: 0.82rem; color: var(--text-muted);">${dict.store_power || 'Công suất'}:</span>
              <span style="font-family: var(--font-mono); font-size: 0.85rem; font-weight: 600; color: var(--text-muted);">${m.hashrate} ${m.unit || 'TH/s'}</span>
            </div>
          </div>
        </div>

        <div>
          <button class="btn btn-primary" style="width: 100%; font-weight: 700; border-radius: 12px; padding: 12px; display: flex; align-items: center; justify-content: center; gap: 8px;" onclick="openBuyMinerModal('${m.id}')">
            <span>🛒 ${dict.store_btn_buy || 'Kích Hoạt Gói'}</span>
            <span style="display: inline-flex; align-items: center; gap: 5px; background: rgba(0,0,0,0.5); padding: 3px 9px 3px 6px; border-radius: 16px; font-family: var(--font-mono); font-size: 0.86rem; border: 1px solid rgba(255,255,255,0.1);">
              <img src="assets/usdt.png" alt="USDT" style="width: 16px; height: 16px; border-radius: 50%;">
              $${Number(m.price_usdt).toLocaleString()} USDT
            </span>
          </button>
        </div>
      </div>
    `;
  }).join('');
}
window.renderStoreMiners = renderStoreMiners;

let selectedMinerForBuy = null;

function openBuyMinerModal(minerId) {
  if (!State.user) {
    switchTab('user');
    showToast('Vui lòng đăng nhập để mua máy đào!', 'info');
    return;
  }

  const miner = State.minersCatalog.find(m => m.id === minerId);
  if (!miner) return;

  selectedMinerForBuy = miner;
  
  const elName = document.getElementById('buyModalMinerName');
  const elTier = document.getElementById('buyModalMinerTier');
  const elPrice = document.getElementById('buyModalUnitPrice');
  const elHash = document.getElementById('buyModalUnitHashrate');

  if (elName) elName.innerText = miner.name;
  if (elTier) elTier.innerText = miner.tier || 'Máy Đào';
  if (elPrice) elPrice.innerText = `$${Number(miner.price_usdt).toLocaleString()} USDT`;
  if (elHash) elHash.innerText = `${miner.hashrate} ${miner.unit || 'TH/s'}`;
  
  const qtyInput = document.getElementById('buyModalQty');
  if (qtyInput) qtyInput.value = 1;

  updateBuyModalCalculations();
  openModal('buyMinerModal');
}

function changeBuyQty(delta) {
  const input = document.getElementById('buyModalQty');
  if (!input) return;
  let val = parseInt(input.value) || 1;
  val = Math.max(1, Math.min(1000, val + delta));
  input.value = val;
  updateBuyModalCalculations();
}

function setBuyQty(qty) {
  const input = document.getElementById('buyModalQty');
  if (!input) return;
  input.value = Math.max(1, Math.min(1000, qty));
  updateBuyModalCalculations();
}

function setBuyQtyMax() {
  if (!selectedMinerForBuy || !State.user) return;
  const userUsdt = State.user.usdt_balance || 0;
  const price = selectedMinerForBuy.price_usdt || 1;
  const maxQty = Math.max(1, Math.floor(userUsdt / price));
  setBuyQty(maxQty);
}

function updateBuyModalCalculations() {
  if (!selectedMinerForBuy) return;
  const input = document.getElementById('buyModalQty');
  let qty = parseInt(input ? input.value : 1) || 1;
  if (qty < 1) qty = 1;
  if (qty > 1000) qty = 1000;

  const unitPrice = parseFloat(selectedMinerForBuy.price_usdt) || 0;
  const totalPrice = unitPrice * qty;
  const unitHash = parseFloat(selectedMinerForBuy.hashrate) || 0;
  const totalHash = unitHash * qty;
  const unitDaily = parseFloat(selectedMinerForBuy.daily_yield_coins) || 0;
  const totalDaily = unitDaily * qty;
  const coinSymbol = (State.settings && State.settings.coin_symbol) || 'MNX';
  const userUsdt = State.user ? (State.user.usdt_balance || 0) : 0;

  const elTotalPrice = document.getElementById('buyModalTotalPrice');
  const elTotalHash = document.getElementById('buyModalTotalHashrate');
  const elTotalDaily = document.getElementById('buyModalTotalDaily');
  const elError = document.getElementById('buyModalErrorMsg');
  const btnConfirm = document.getElementById('buyModalConfirmBtn');

  if (elTotalPrice) elTotalPrice.innerText = `$${Number(totalPrice).toLocaleString()} USDT`;
  if (elTotalHash) elTotalHash.innerText = `+${Number(totalHash).toLocaleString()} ${selectedMinerForBuy.unit || 'TH/s'}`;
  if (elTotalDaily) elTotalDaily.innerText = `+${Number(totalDaily).toLocaleString()} ${coinSymbol}/ngày`;

  const currentLangCode = localStorage.getItem('minex_lang') || 'vi';
  const dict = (window.I18N_DICTIONARY && window.I18N_DICTIONARY[currentLangCode]) ? window.I18N_DICTIONARY[currentLangCode] : (window.I18N_DICTIONARY ? window.I18N_DICTIONARY.vi : {});

  if (userUsdt < totalPrice) {
    if (elError) {
      elError.style.display = 'block';
      const missing = (totalPrice - userUsdt).toFixed(2);
      elError.innerHTML = `⚠️ ${dict.buy_modal_insufficient || 'Số dư USDT không đủ'} (Thiếu $${missing} USDT)<br><a href="javascript:void(0)" onclick="closeModal('buyMinerModal'); switchTab('wallet')" style="color: #38bdf8; text-decoration: underline; font-weight: 600; display: inline-block; margin-top: 6px;">💳 ${dict.store_btn_deposit || 'Nạp thêm USDT ngay'} &rarr;</a>`;
    }
    if (btnConfirm) {
      btnConfirm.disabled = true;
      btnConfirm.style.opacity = '0.5';
      btnConfirm.style.cursor = 'not-allowed';
    }
  } else {
    if (elError) {
      elError.style.display = 'none';
      elError.innerHTML = '';
    }
    if (btnConfirm) {
      btnConfirm.disabled = false;
      btnConfirm.style.opacity = '1';
      btnConfirm.style.cursor = 'pointer';
    }
  }
}

async function executeBuyMiner() {
  if (!selectedMinerForBuy || !State.user) return;
  const input = document.getElementById('buyModalQty');
  const quantity = Math.max(1, parseInt(input ? input.value : 1) || 1);

  const btnConfirm = document.getElementById('buyModalConfirmBtn');
  if (btnConfirm) {
    btnConfirm.disabled = true;
    btnConfirm.innerText = 'Đang xử lý...';
  }

  try {
    const res = await apiCall('api/miners.php?action=buy', 'POST', {
      minerId: selectedMinerForBuy.id,
      quantity: quantity
    });
    showToast(res.message, 'success');
    closeModal('buyMinerModal');
    await checkSession();
    await loadStore();
    await loadMiningData();
    if (typeof loadHistory === 'function') loadHistory();
  } catch (err) {
    showToast(err.message, 'error');
  } finally {
    if (btnConfirm) {
      btnConfirm.disabled = false;
      const currentLangCode = localStorage.getItem('minex_lang') || 'vi';
      const dict = (window.I18N_DICTIONARY && window.I18N_DICTIONARY[currentLangCode]) ? window.I18N_DICTIONARY[currentLangCode] : (window.I18N_DICTIONARY ? window.I18N_DICTIONARY.vi : {});
      btnConfirm.innerText = dict.buy_modal_confirm_btn || 'Xác Nhận Kích Hoạt';
    }
  }
}

window.openBuyMinerModal = openBuyMinerModal;
window.changeBuyQty = changeBuyQty;
window.setBuyQty = setBuyQty;
window.setBuyQtyMax = setBuyQtyMax;
window.updateBuyModalCalculations = updateBuyModalCalculations;
window.executeBuyMiner = executeBuyMiner;
window.buyMiner = openBuyMinerModal;

// -------------------------------------------------------------
// WALLET & SWAP
// -------------------------------------------------------------
async function loadWallet() {
  if (!State.user) return;
  try {
    const data = await apiCall('api/wallet.php?action=summary');
    document.getElementById('walletDepositAddress').innerText = data.deposit_address;
    document.getElementById('walletDepositNetwork').innerText = data.network;
    document.getElementById('walletMinDeposit').innerText = `$${data.min_deposit} USDT`;
    document.getElementById('walletMinWithdraw').innerText = `$${data.min_withdraw} USDT`;
    document.getElementById('walletWithdrawFee').innerText = `${data.withdraw_fee_percent}%`;
    document.getElementById('walletSwapRate').innerText = `1 ${data.coin_symbol} = $${data.coin_price_usdt} USDT`;

    updateSwapPreview();
  } catch (err) {
    console.error('Failed to load wallet summary:', err);
  }
}

function switchWalletTab(tab) {
  document.querySelectorAll('.wallet-subtab').forEach(el => el.style.display = 'none');
  document.querySelectorAll('.wallet-nav-btn').forEach(el => el.classList.remove('active'));

  const activeSubtab = document.getElementById(`walletTab-${tab}`);
  if (activeSubtab) activeSubtab.style.display = 'block';

  const activeBtn = document.getElementById(`walletNavBtn-${tab}`);
  if (activeBtn) activeBtn.classList.add('active');
}

function copyDepositAddress() {
  const addr = document.getElementById('walletDepositAddress').innerText;
  navigator.clipboard.writeText(addr);
  showToast('Đã sao chép địa chỉ ví USDT vào clipboard!', 'info');
}

async function handleDeposit(e) {
  e.preventDefault();
  const amount = parseFloat(document.getElementById('depAmount').value);
  const txHash = document.getElementById('depTxHash').value;

  try {
    const res = await apiCall('api/wallet.php?action=deposit', 'POST', { amount, txHash });
    showToast(res.message, 'success');
    document.getElementById('depTxHash').value = '';
    await checkSession();
    switchTab('history');
  } catch (err) {
    showToast(err.message, 'error');
  }
}

async function handleWithdraw(e) {
  e.preventDefault();
  const amount = parseFloat(document.getElementById('wdAmount').value);
  const address = document.getElementById('wdAddress').value;

  try {
    const res = await apiCall('api/wallet.php?action=withdraw', 'POST', { amount, address });
    showToast(res.message, 'success');
    document.getElementById('wdAddress').value = '';
    await checkSession();
    switchTab('history');
  } catch (err) {
    showToast(err.message, 'error');
  }
}

function updateSwapPreview() {
  const input = document.getElementById('swapCoinAmount');
  if (!input) return;
  const coins = parseFloat(input.value) || 0;
  const rate = State.settings.coin_price_usdt || 0.001;
  const usdt = (coins * rate).toFixed(4);

  const previewEl = document.getElementById('swapUsdtPreview');
  if (previewEl) previewEl.innerText = `+${usdt} USDT`;
}

function setSwapPercent(ratio) {
  if (!State.user) return;
  const coins = (State.user.coin_balance || 0) * ratio;
  const input = document.getElementById('swapCoinAmount');
  if (input) {
    input.value = coins.toFixed(4);
    updateSwapPreview();
  }
}

async function handleSwap(e) {
  e.preventDefault();
  const coinAmount = parseFloat(document.getElementById('swapCoinAmount').value);

  try {
    const res = await apiCall('api/wallet.php?action=swap', 'POST', { coinAmount });
    showToast(res.message, 'success');
    await checkSession();
    await loadWallet();
  } catch (err) {
    showToast(err.message, 'error');
  }
}

// -------------------------------------------------------------
// TRANSACTIONS HISTORY
// -------------------------------------------------------------
async function loadHistory() {
  if (!State.user) return;
  try {
    const res = await apiCall('api/wallet.php?action=transactions');
    State.transactions = res.transactions || [];
    filterHistory('all');
  } catch (err) {
    console.error('Failed to load transactions:', err);
  }
}

function filterHistory(type) {
  window.currentHistoryFilter = type;
  document.querySelectorAll('.tx-filter-btn').forEach(btn => {
    if (btn.dataset.type === type) {
      btn.classList.add('btn-primary');
      btn.classList.remove('btn-secondary');
    } else {
      btn.classList.remove('btn-primary');
      btn.classList.add('btn-secondary');
    }
  });

  const filtered = State.transactions.filter(t => type === 'all' || t.type === type);
  const container = document.getElementById('historyTableBody');
  if (!container) return;

  const currentLangCode = localStorage.getItem('minex_lang') || 'vi';
  const dict = (window.I18N_DICTIONARY && window.I18N_DICTIONARY[currentLangCode]) ? window.I18N_DICTIONARY[currentLangCode] : (window.I18N_DICTIONARY ? window.I18N_DICTIONARY.vi : {});

  if (filtered.length === 0) {
    container.innerHTML = `
      <tr>
        <td colspan="6" style="text-align:center; padding: 40px; color: var(--text-muted);">
          ${dict.history_empty || 'Không có giao dịch nào trong danh mục này.'}
        </td>
      </tr>
    `;
    return;
  }

  container.innerHTML = filtered.map(tx => {
    const isCredit = tx.type === 'deposit' || tx.type === 'claim';
    const isDebit = tx.type === 'withdraw' || tx.type === 'buy_miner';
    const typeLabel = dict['tx_filter_' + tx.type] || tx.type.toUpperCase();

    return `
      <tr>
        <td style="font-family: var(--font-mono); font-size: 0.78rem; color: var(--text-dim);">
          #${tx.id.slice(0, 10)}
        </td>
        <td>
          <strong style="text-transform: uppercase; font-size: 0.8rem; color: ${isCredit ? '#fbbf24' : (isDebit ? '#fb7185' : '#fff')};">
            ${typeLabel}
          </strong>
        </td>
        <td style="font-family: var(--font-mono); font-weight: 700; color: ${isCredit ? '#fbbf24' : (isDebit ? '#fb7185' : '#fff')};">
          ${isCredit ? '+' : (isDebit ? '-' : '')}${tx.amount} ${tx.currency}
        </td>
        <td style="font-size: 0.82rem; color: var(--text-muted); max-width: 260px; overflow: hidden; text-overflow: ellipsis;">
          ${tx.detail?.miner_name ? `Máy: <strong>${tx.detail.miner_name}</strong>` : ''}
          ${tx.detail?.tx_hash ? `Hash: ${tx.detail.tx_hash.slice(0, 16)}...` : ''}
          ${tx.detail?.recipient_address ? `Ví nhận: ${tx.detail.recipient_address.slice(0, 14)}...` : ''}
          ${tx.detail?.usdt_received ? `Nhận: <strong>+${tx.detail.usdt_received} USDT</strong>` : ''}
          ${tx.detail?.note ? tx.detail.note : ''}
        </td>
        <td style="font-size: 0.8rem; color: var(--text-dim); white-space: nowrap;">
          ${new Date(tx.created_at).toLocaleString('vi-VN')}
        </td>
        <td>
          <span class="badge badge-${tx.status}">
            ${tx.status}
          </span>
        </td>
      </tr>
    `;
  }).join('');
}

// -------------------------------------------------------------
// ADMIN MANAGEMENT
// -------------------------------------------------------------
async function loadAdmin() {
  if (!State.user || State.user.role !== 'admin') return;

  try {
    // 1. Overview
    const overview = await apiCall('api/admin.php?action=overview');
    document.getElementById('admTotalUsers').innerText = overview.total_users;
    document.getElementById('admPendingCount').innerText = overview.pending_deposits_count + overview.pending_withdrawals_count;
    document.getElementById('admActiveMiners').innerText = overview.active_miners;
    document.getElementById('admCoinPrice').innerText = `$${overview.settings.coin_price_usdt}`;

    // Fill settings form
    document.getElementById('admSetCoinPrice').value = overview.settings.coin_price_usdt;
    document.getElementById('admSetDepositAddress').value = overview.settings.usdt_deposit_address;
    document.getElementById('admSetNetwork').value = overview.settings.network || 'USDT (TRC20)';
    document.getElementById('admSetMinDep').value = overview.settings.min_deposit;
    document.getElementById('admSetMinWd').value = overview.settings.min_withdraw;
    document.getElementById('admSetWdFee').value = overview.settings.withdraw_fee_percent;

    // 2. Pending Transactions
    const txsRes = await apiCall('api/admin.php?action=transactions');
    renderAdminTransactions(txsRes.transactions || []);

    // 3. Users list
    const usersRes = await apiCall('api/admin.php?action=users');
    renderAdminUsers(usersRes.users || []);

    // 4. Miners catalog
    const minersRes = await apiCall('api/admin.php?action=miners');
    renderAdminMiners(minersRes.miners || []);
  } catch (err) {
    console.error('Failed to load admin:', err);
  }
}

function renderAdminTransactions(txs) {
  const container = document.getElementById('admTxTableBody');
  if (!container) return;

  container.innerHTML = txs.map(tx => `
    <tr>
      <td style="font-family: var(--font-mono); font-size: 0.78rem;">#${tx.id.slice(0, 10)}</td>
      <td style="font-size: 0.8rem;">${tx.user_id}</td>
      <td><strong>${tx.type}</strong></td>
      <td style="font-family: var(--font-mono); font-weight: 700;">${tx.amount} ${tx.currency}</td>
      <td style="font-size: 0.8rem; color: var(--text-muted);">
        ${tx.detail?.recipient_address ? `Ví: ${tx.detail.recipient_address}` : ''}
        ${tx.detail?.tx_hash ? `Hash: ${tx.detail.tx_hash}` : ''}
        ${tx.notes ? `<div style="color:#fbbf24;">Note: ${tx.notes}</div>` : ''}
      </td>
      <td style="font-size: 0.78rem; color: var(--text-dim);">${new Date(tx.created_at).toLocaleString('vi-VN')}</td>
      <td><span class="badge badge-${tx.status}">${tx.status}</span></td>
      <td>
        ${tx.status === 'pending' ? `
          <button class="btn btn-success btn-sm" onclick="approveTx('${tx.id}')">Duyệt</button>
          <button class="btn btn-danger btn-sm" onclick="rejectTx('${tx.id}')">Từ Chối</button>
        ` : '<span style="color:var(--text-dim); font-size: 0.78rem;">Đã duyệt</span>'}
      </td>
    </tr>
  `).join('');
}

async function approveTx(id) {
  try {
    const res = await apiCall('api/admin.php?action=approve_tx', 'POST', { id });
    showToast(res.message, 'success');
    await loadAdmin();
    await checkSession();
  } catch (err) {
    showToast(err.message, 'error');
  }
}

async function rejectTx(id) {
  const reason = prompt('Lý do từ chối:', 'Thông tin không hợp lệ');
  if (reason === null) return;

  try {
    const res = await apiCall('api/admin.php?action=reject_tx', 'POST', { id, reason });
    showToast(res.message, 'success');
    await loadAdmin();
    await checkSession();
  } catch (err) {
    showToast(err.message, 'error');
  }
}

function renderAdminUsers(users) {
  const container = document.getElementById('admUsersTableBody');
  if (!container) return;

  container.innerHTML = users.map(u => `
    <tr>
      <td>
        <strong style="color: #fff;">${u.name || 'Thợ đào'}</strong>
        <div style="font-size: 0.78rem; color: var(--text-dim);">${u.email}</div>
      </td>
      <td><span class="badge ${u.role === 'admin' ? 'badge-pending' : 'badge-completed'}">${u.role}</span></td>
      <td style="font-family: var(--font-mono); color: #fbbf24; font-weight: 700;">${Number(u.usdt_balance || 0).toFixed(2)} USDT</td>
      <td style="font-family: var(--font-mono); color: #22d3ee; font-weight: 700;">${Number(u.coin_balance || 0).toFixed(4)} MNX</td>
      <td>${u.active_miners_count} máy</td>
      <td style="font-family: var(--font-mono); color: #a78bfa;">${u.hashrate || 0} TH/s</td>
      <td>
        <button class="btn btn-secondary btn-sm" onclick="openAdjustBalanceModal('${u.id}', '${u.email}')">
          Chỉnh Số Dư
        </button>
      </td>
    </tr>
  `).join('');
}

function openAdjustBalanceModal(userId, email) {
  document.getElementById('adjUserId').value = userId;
  document.getElementById('adjUserEmail').innerText = email;
  openModal('adjustBalanceModal');
}

async function handleSaveAdjustBalance(e) {
  e.preventDefault();
  const userId = document.getElementById('adjUserId').value;
  const usdtAmount = parseFloat(document.getElementById('adjUsdtAmount').value) || 0;
  const coinAmount = parseFloat(document.getElementById('adjCoinAmount').value) || 0;
  const reason = document.getElementById('adjReason').value;

  try {
    const res = await apiCall('api/admin.php?action=adjust_balance', 'POST', {
      userId, usdtAmount, coinAmount, reason
    });
    showToast(res.message, 'success');
    closeModal('adjustBalanceModal');
    await loadAdmin();
  } catch (err) {
    showToast(err.message, 'error');
  }
}

async function handleSaveAdminSettings(e) {
  e.preventDefault();
  const settings = {
    coin_price_usdt: parseFloat(document.getElementById('admSetCoinPrice').value),
    usdt_deposit_address: document.getElementById('admSetDepositAddress').value.trim(),
    network: document.getElementById('admSetNetwork').value.trim(),
    min_deposit: parseFloat(document.getElementById('admSetMinDep').value),
    min_withdraw: parseFloat(document.getElementById('admSetMinWd').value),
    withdraw_fee_percent: parseFloat(document.getElementById('admSetWdFee').value)
  };

  try {
    const res = await apiCall('api/admin.php?action=update_settings', 'POST', { settings });
    showToast(res.message, 'success');
    State.settings = res.settings;
    updateUserInterface();
  } catch (err) {
    showToast(err.message, 'error');
  }
}

function renderAdminMiners(miners) {
  const container = document.getElementById('admMinersTableBody');
  if (!container) return;

  container.innerHTML = miners.map(m => `
    <tr>
      <td><strong>${m.name}</strong></td>
      <td>${m.tier}</td>
      <td style="font-family: var(--font-mono); color: #22d3ee;">${m.hashrate} ${m.unit || 'TH/s'}</td>
      <td style="font-family: var(--font-mono); color: #fbbf24; font-weight: 700;">$${m.price_usdt} USDT</td>
      <td style="font-family: var(--font-mono); color: #fbbf24;">+${m.daily_yield_coins} MNX</td>
      <td style="color: var(--text-dim);">${m.power_consumption}</td>
      <td><span class="badge badge-completed">Đang Bán</span></td>
    </tr>
  `).join('');
}

async function handleAddMiner(e) {
  e.preventDefault();
  const name = document.getElementById('newMinerName').value;
  const tier = document.getElementById('newMinerTier').value;
  const hashrate = parseFloat(document.getElementById('newMinerHashrate').value);
  const price_usdt = parseFloat(document.getElementById('newMinerPrice').value);
  const daily_yield_coins = parseFloat(document.getElementById('newMinerDaily').value);
  const power_consumption = document.getElementById('newMinerPower').value;

  try {
    const res = await apiCall('api/admin.php?action=add_miner', 'POST', {
      name, tier, hashrate, price_usdt, daily_yield_coins, power_consumption
    });
    showToast(res.message, 'success');
    closeModal('addMinerModal');
    await loadAdmin();
  } catch (err) {
    showToast(err.message, 'error');
  }
}

// -------------------------------------------------------------
// IPHONE 17 PRO MAX SIMULATOR CONTROLS
// -------------------------------------------------------------
let isIphoneMode = localStorage.getItem('minex_iphone_mode') !== 'false'; // Default to true!

function initIphoneSimulator() {
  if (window.innerWidth <= 768) {
    isIphoneMode = false;
  }
  applyIphoneFrameState();
  updateIosClock();
  setInterval(updateIosClock, 1000);
}

// Lắng nghe thay đổi kích thước màn hình để tự động cố định layout
window.addEventListener('resize', () => {
  if (window.innerWidth <= 768 && isIphoneMode) {
    isIphoneMode = false;
    applyIphoneFrameState();
  }
});

function updateIosClock() {
  const timeEl = document.getElementById('iosTime');
  if (!timeEl) return;
  const now = new Date();
  const hours = String(now.getHours()).padStart(2, '0');
  const minutes = String(now.getMinutes()).padStart(2, '0');
  timeEl.innerText = `${hours}:${minutes}`;
}

function toggleIphoneFrame() {
  if (window.innerWidth <= 768) {
    showToast('Thiết bị di động luôn hiển thị toàn màn hình tối ưu!', 'info');
    return;
  }
  isIphoneMode = !isIphoneMode;
  localStorage.setItem('minex_iphone_mode', isIphoneMode);
  applyIphoneFrameState();
  showToast(isIphoneMode ? 'Đã bật khung mô phỏng iPhone 17 Pro Max!' : 'Đã chuyển sang chế độ Toàn màn hình Desktop!', 'info');
}

function applyIphoneFrameState() {
  const container = document.getElementById('iphoneScaleContainer');
  const chassis = document.getElementById('iphoneChassis');
  const wrapper = document.getElementById('deviceWrapper');
  const topBar = document.getElementById('iphoneTopBar');
  const bottomBar = document.getElementById('iphoneBottomBar');
  const btn = document.getElementById('btnToggleIphone');

  if (!chassis || !wrapper) return;

  // Trên thiết bị di động (<= 768px): Luôn hiển thị giao diện phẳng 100% gốc không lệch
  if (window.innerWidth <= 768) {
    wrapper.className = '';
    if (container) {
      container.style.width = '100%';
      container.style.height = 'auto';
      container.style.display = 'block';
    }
    chassis.style.display = '';
    chassis.style.transform = 'none';
    chassis.style.zoom = '1';
    if (topBar) topBar.style.display = 'none';
    if (bottomBar) bottomBar.style.display = '';
    return;
  }

  if (isIphoneMode) {
    wrapper.className = 'iphone-mode-active';
    if (container) container.style.display = '';
    chassis.style.display = '';
    if (topBar) topBar.style.display = '';
    if (bottomBar) bottomBar.style.display = '';
    if (btn) {
      btn.innerText = 'Khung iPhone: BẬT';
      btn.className = 'btn btn-sm btn-primary';
    }
    const currentScale = parseFloat(localStorage.getItem('minex_iphone_scale')) || 0.8;
    scaleIphone(currentScale);
  } else {
    wrapper.className = '';
    if (container) {
      container.style.width = '100%';
      container.style.height = 'auto';
      container.style.display = 'block';
    }
    chassis.style.display = '';
    chassis.style.transform = 'none';
    chassis.style.zoom = '1';
    if (topBar) topBar.style.display = 'none';
    if (bottomBar) bottomBar.style.display = '';
    if (btn) {
      btn.innerText = 'Khung iPhone: TẮT';
      btn.className = 'btn btn-sm btn-secondary';
    }
  }
}

function scaleIphone(factor) {
  const container = document.getElementById('iphoneScaleContainer');
  const chassis = document.getElementById('iphoneChassis');
  const wrapper = document.getElementById('deviceWrapper');
  if (!chassis || !isIphoneMode || window.innerWidth <= 768) return;

  const baseW = 428;
  const baseH = 890;

  // Use CSS transform scale for reliable pixel rendering
  chassis.style.zoom = '1';
  chassis.style.transformOrigin = 'top center';
  chassis.style.transform = `scale(${factor})`;

  // Scale the container dimensions so document flow matches the visible phone exactly
  if (container) {
    container.style.width = `${baseW * factor}px`;
    container.style.height = `${baseH * factor}px`;
  }

  if (wrapper) {
    wrapper.style.minHeight = `${(baseH * factor) + 100}px`;
  }

  localStorage.setItem('minex_iphone_scale', factor);

  // Update active scale button styles
  document.querySelectorAll('.scale-btn').forEach(btn => {
    if (parseFloat(btn.dataset.scale) === factor) {
      btn.classList.add('btn-primary');
      btn.classList.remove('btn-secondary');
    } else {
      btn.classList.remove('btn-primary');
      btn.classList.add('btn-secondary');
    }
  });

  showToast(`Đã áp dụng tỷ lệ iPhone 17 Pro Max: ${Math.round(factor * 100)}%`, 'info');
  window.dispatchEvent(new Event('resize'));
}

// Restore saved scale on init if available (default to 80% for ideal desktop view)
const savedScale = parseFloat(localStorage.getItem('minex_iphone_scale')) || 0.8;
setTimeout(() => {
  if (isIphoneMode) {
    scaleIphone(savedScale);
  }
}, 100);

// -------------------------------------------------------------
// 3D GOLDEN COIN IMAGE HANDLER
// -------------------------------------------------------------
function handleCustomCoinImage(input) {
  if (!input || !input.files || !input.files[0]) return;
  const file = input.files[0];
  const img = document.getElementById('mainCoinImg');
  if (!img) return;

  const reader = new FileReader();
  reader.onload = function(e) {
    img.src = e.target.result;
    showToast(`Đã áp dụng ảnh đồng coin "${file.name}"!`, 'success');
  };
  reader.readAsDataURL(file);
}

// -------------------------------------------------------------
// REFERRAL & 10% F1 COMMISSION PROGRAM HANDLERS
// -------------------------------------------------------------
function initReferralTracking() {
  try {
    const urlParams = new URLSearchParams(window.location.search);
    const refCode = urlParams.get('ref') || urlParams.get('r');
    if (refCode) {
      localStorage.setItem('minex_ref', refCode.trim());
    }
    const savedRef = localStorage.getItem('minex_ref');
    if (savedRef) {
      const regRef = document.getElementById('regRefCode');
      if (regRef && !regRef.value) regRef.value = savedRef;
      const userRegRef = document.getElementById('userPageRegRefCode');
      if (userRegRef && !userRegRef.value) userRegRef.value = savedRef;
    }
  } catch (e) {
    console.error('Ref parse error', e);
  }
}

async function loadReferralData() {
  const uid = (State.user && State.user.uid) ? State.user.uid : '120850';
  const origin = window.location.origin && window.location.origin !== 'null' ? window.location.origin : 'http://localhost:8000';
  const pathname = window.location.pathname || '/';
  const refLink = `${origin}${pathname}?ref=${uid}`;

  const elUid = document.getElementById('refMyUidDisplay');
  if (elUid) elUid.innerText = uid;

  const elLinkInput = document.getElementById('refMyLinkInput');
  if (elLinkInput) elLinkInput.value = refLink;

  if (!State.user) return;

  try {
    const res = await apiCall('api/auth.php?action=referral_stats');
    if (res) {
      const elF1 = document.getElementById('refStatsF1Count');
      if (elF1) elF1.innerText = res.f1_count || 0;

      const elComm = document.getElementById('refStatsTotalComm');
      if (elComm) elComm.innerText = `$${Number(res.total_commission || 0).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;

      let totalF1Spent = 0;
      if (res.f1_users && res.f1_users.length > 0) {
        totalF1Spent = res.f1_users.reduce((acc, u) => acc + (parseFloat(u.total_spent) || 0), 0);
      }
      const elSpent = document.getElementById('refStatsF1Spent');
      if (elSpent) elSpent.innerText = `$${Number(totalF1Spent).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;

      // Render F1 List
      const elF1List = document.getElementById('refF1ListContainer');
      if (elF1List) {
        if (!res.f1_users || res.f1_users.length === 0) {
          elF1List.innerHTML = `<div style="text-align: center; padding: 20px; color: var(--text-muted); font-size: 0.85rem;" data-i18n="ref_no_f1">Chưa có thành viên F1 nào. Hãy chia sẻ link giới thiệu ngay để bắt đầu nhận 10% hoa hồng!</div>`;
        } else {
          elF1List.innerHTML = `
            <div style="display: flex; flex-direction: column; gap: 8px;">
              ${res.f1_users.map(u => `
                <div style="background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; padding: 12px 14px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                  <div>
                    <div style="display: flex; align-items: center; gap: 6px;">
                      <strong style="color: #fff; font-size: 0.9rem;">${u.name || 'Thợ đào'}</strong>
                      <span class="badge" style="background: rgba(56,189,248,0.15); color: #38bdf8; font-size: 0.72rem; padding: 2px 6px;">UID: ${u.uid}</span>
                    </div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 3px;">
                      Tham gia: ${new Date(u.created_at).toLocaleDateString('vi-VN')} • Gói sở hữu: <strong style="color: #fbbf24;">${u.miners_count || 0}</strong>
                    </div>
                  </div>
                  <div style="text-align: right;">
                    <div style="font-size: 0.72rem; color: var(--text-muted);">Doanh số F1:</div>
                    <div style="font-family: var(--font-mono); font-weight: 700; color: #34d399; font-size: 0.92rem;">$${Number(u.total_spent || 0).toLocaleString()} USDT</div>
                  </div>
                </div>
              `).join('')}
            </div>
          `;
        }
      }

      // Render Commission History
      const elCommList = document.getElementById('refCommissionHistoryContainer');
      if (elCommList) {
        if (!res.commissions || res.commissions.length === 0) {
          elCommList.innerHTML = `<div style="text-align: center; padding: 14px; color: var(--text-muted); font-size: 0.82rem;" data-i18n="ref_no_comm">Chưa có giao dịch hoa hồng nào được ghi nhận.</div>`;
        } else {
          elCommList.innerHTML = `
            <div style="display: flex; flex-direction: column; gap: 8px;">
              ${res.commissions.map(c => {
                let det = {};
                try { det = JSON.parse(c.detail); } catch(e){}
                return `
                  <div style="background: rgba(16,185,129,0.06); border: 1px dashed rgba(16,185,129,0.25); border-radius: 12px; padding: 12px 14px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                    <div>
                      <div style="font-size: 0.86rem; font-weight: 700; color: #fff;">${det.note || 'Hoa hồng 10% tuyến trên'}</div>
                      <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 2px;">
                        ${new Date(c.created_at).toLocaleString('vi-VN')}
                      </div>
                    </div>
                    <div style="font-family: var(--font-mono); font-size: 1.05rem; font-weight: 800; color: #34d399;">
                      +${Number(c.amount).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})} USDT
                    </div>
                  </div>
                `;
              }).join('')}
            </div>
          `;
        }
      }
    }
  } catch (err) {
    console.error('Failed to load referral stats', err);
  }
}

function copyReferralCode() {
  const uid = (State.user && State.user.uid) ? State.user.uid : '120850';
  navigator.clipboard.writeText(uid).then(() => {
    showToast(`Đã sao chép mã giới thiệu: ${uid}`, 'success');
  }).catch(() => {
    showToast(`Mã giới thiệu: ${uid}`, 'info');
  });
}

function copyReferralLink() {
  const el = document.getElementById('refMyLinkInput');
  const uid = (State.user && State.user.uid) ? State.user.uid : '120850';
  const origin = window.location.origin && window.location.origin !== 'null' ? window.location.origin : 'http://localhost:8000';
  const pathname = window.location.pathname || '/';
  const link = (el && el.value) ? el.value : `${origin}${pathname}?ref=${uid}`;

  navigator.clipboard.writeText(link).then(() => {
    showToast('Đã sao chép liên kết giới thiệu thành công!', 'success');
  }).catch(() => {
    showToast(`Link giới thiệu: ${link}`, 'info');
  });
}

function shareReferralLink() {
  const uid = (State.user && State.user.uid) ? State.user.uid : '120850';
  const origin = window.location.origin && window.location.origin !== 'null' ? window.location.origin : 'http://localhost:8000';
  const pathname = window.location.pathname || '/';
  const link = `${origin}${pathname}?ref=${uid}`;
  if (navigator.share) {
    navigator.share({
      title: 'Tham gia Đào Coin MINEX - Nhận 100 USDT Khởi Nghiệp',
      text: 'Đăng ký tài khoản MINEX để nhận 100 USDT khởi nghiệp và nhận 10% hoa hồng tuyến trên khi F1 mua máy đào!',
      url: link
    }).catch(() => copyReferralLink());
  } else {
    copyReferralLink();
  }
}

// Global Exports
window.updateUserInterface = updateUserInterface;
window.renderStoreMiners = renderStoreMiners;
window.updateClaimButtonState = updateClaimButtonState;
window.quickLogin = quickLogin;
window.loadDashboard = loadDashboard;
window.handleCustomCoinImage = handleCustomCoinImage;
window.initReferralTracking = initReferralTracking;
window.loadReferralData = loadReferralData;
window.copyReferralCode = copyReferralCode;
window.copyReferralLink = copyReferralLink;
window.shareReferralLink = shareReferralLink;
