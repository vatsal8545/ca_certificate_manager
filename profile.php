<?php
require_once 'auth_check.php';
$user = $_SESSION['user'];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile - CA Certificate Manager</title>
  <!-- Custom Premium Styles -->
  <link rel="stylesheet" href="assets/css/style.css?v=<?= time(); ?>">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>
<body>
  <div class="app-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="brand-section">
        <div class="brand">
          <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16" style="color: #fbbf24;"><path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.622-.058-.006a2.89 2.89 0 0 0-3.322 3.322l.006.058-.622.622a2.89 2.89 0 0 0 0 4.134l.622.622-.006.058a2.89 2.89 0 0 0 3.322 3.322l.058-.006.622.622a2.89 2.89 0 0 0 4.134 0l.622-.622.058.006a2.89 2.89 0 0 0 3.322-3.322l-.006-.058.622-.622a2.89 2.89 0 0 0 0-4.134l-.622-.622.006-.058a2.89 2.89 0 0 0-3.322-3.322l-.058.006zm-5.69 2.477a1.89 1.89 0 0 1 2.174-2.174l.08.008.835-.835a1.89 1.89 0 0 1 2.67 0l.836.835.08-.008a1.89 1.89 0 0 1 2.174 2.174l-.008.08.835.836a1.89 1.89 0 0 1 0 2.67l-.835.835.008.08a1.89 1.89 0 0 1-2.174 2.174l-.08-.008-.835.835a1.89 1.89 0 0 1-2.67 0l-.836-.835-.08.008a1.89 1.89 0 0 1-2.174-2.174l.008-.08-.835-.836a1.89 1.89 0 0 1 0-2.67l.835-.835-.008-.08zm1.968 4.398a.5.5 0 0 0-.83.604l1.5 2.062a.5.5 0 0 0 .747.078l2.5-2.5a.5.5 0 0 0-.707-.708L7.75 9.423z"/></svg>
          CA CERT MANAGER
        </div>
        <p class="brand-subtitle">Simple • Fast • Accurate</p>
      </div>
      <nav class="nav-menu">
        <a class="nav-link-custom" href="index.php">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4 0 1 1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/></svg>
          Clients & Generator
        </a>
        <a class="nav-link-custom" href="firm_settings.php">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V1.1a.5.5 0 0 1 .278-.447l8-4a.5.5 0 0 1 .485.022M6 8.694 1.458 10.135A.5.5 0 0 0 1 10.615V15h8V8.694zM10 15h4V1.543l-7 3.5v9.957zm1.25-10a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5M11 7.5a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0M10.5 10a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1.5m0 2a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/></svg>
          Firm Settings
        </a>
        <a class="nav-link-custom active" href="profile.php">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
          Profile
        </a>
      </nav>
      <div class="sidebar-footer">
        <div class="avatar" id="sidebarAvatar">A</div>
        <div class="user-info">
          <strong class="user-name" id="sidebarUser">admin</strong>
          <span class="user-role" id="sidebarRole">Administrator</span>
        </div>
        <a href="logout.php" class="logout-btn" title="Logout">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/><path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"/></svg>
        </a>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <div class="page-header">
        <div>
          <h1 class="page-title">User Profile</h1>
          <p class="page-subtitle">Manage your session status and security credentials.</p>
        </div>
        <div class="page-date" id="pageDate">Date: --</div>
      </div>

      <div class="card-premium" style="max-width: 760px; margin: 0 auto;">
        <div class="card-body-premium">
          <div style="display:flex; align-items:center; gap:20px; border-bottom:1px solid #f1f5f9; padding-bottom:20px; margin-bottom:20px;">
            <div class="avatar" style="width:70px; height:70px; font-size:1.6rem; background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);">
              <?=htmlspecialchars(strtoupper(substr($user['username'], 0, 1)))?>
            </div>
            <div>
              <h2 style="font-size:1.4rem; font-weight:800; color:#0f172a; margin-bottom:4px;"><?=htmlspecialchars($user['username'])?></h2>
              <p style="color:#64748b; font-size:0.85rem; font-weight:600; text-transform:uppercase; margin:0; display:flex; align-items:center; gap:6px;">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16" style="color:#eab308;"><path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm14 12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H1a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1z"/></svg>
                <?=htmlspecialchars($user['role'])?>
              </p>
            </div>
          </div>

          <div class="form-grid">
            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:18px;">
              <h3 style="font-size:0.9rem; font-weight:700; color:#334155; margin-bottom:12px;">Account Information</h3>
              <p style="font-size:0.85rem; margin:6px 0; color:#475569;"><strong>Username:</strong> <?=htmlspecialchars($user['username'])?></p>
              <p style="font-size:0.85rem; margin:6px 0; color:#475569;"><strong>Role:</strong> <?=htmlspecialchars($user['role'])?></p>
              <p style="font-size:0.85rem; margin:6px 0; color:#475569;"><strong>Session:</strong> <span style="color:#10b981; font-weight:700;">Active</span></p>
            </div>
            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:18px;">
              <h3 style="font-size:0.9rem; font-weight:700; color:#334155; margin-bottom:12px;">Storage Mode</h3>
              <p style="font-size:0.82rem; line-height:1.6; color:#64748b; margin:0;">
                All certificate information and CA firm settings are configured and held in **Local Memory Storage** inside this web browser. Server database operations are not requested, which provides complete privacy.
              </p>
            </div>
          </div>

          <div style="display:flex; justify-content:flex-end; gap:12px; border-top:1px solid #f1f5f9; padding-top:20px; margin-top:20px;">
            <a href="index.php" class="btn-custom btn-custom-secondary" style="text-decoration:none;">
              <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M11.5 6.027a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m2.5-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m-2.5-3a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m-1.5 1.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354z"/></svg>
              Dashboard
            </a>
            <a href="logout.php" class="btn-custom btn-custom-danger" style="text-decoration:none;">
              <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/></svg>
              Sign Out
            </a>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script>
    const pageDate = document.getElementById('pageDate');
    (function(){
      fetch('auth_session.php').then(r=>r.json()).then(data=>{
        if (data.user) {
          document.getElementById('sidebarUser').textContent = data.user.username;
          document.getElementById('sidebarRole').textContent = data.user.role;
          document.getElementById('sidebarAvatar').textContent = data.user.username.charAt(0).toUpperCase();
        }
      }).catch(()=>{});
    })();

    function formatDateDisplay(value) {
      const date = new Date(value);
      return date.toLocaleDateString('en-IN', { day:'2-digit', month:'short', year:'numeric' });
    }

    function setCurrentDate() {
      const today = new Date();
      pageDate.textContent = 'Date: ' + formatDateDisplay(today.toISOString().slice(0,10));
    }
    setCurrentDate();
  </script>
</body>
</html>
