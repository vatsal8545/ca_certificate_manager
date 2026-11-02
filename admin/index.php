<?php
require_once '../auth_check.php';
$currentUser = $_SESSION['user'] ?? null;
if (($currentUser['role'] ?? '') !== 'Administrator') {
    header('Location: ../index.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard - CA Certificate Manager</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=<?= time(); ?>">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>
<body>
  <div class="app-container">
    <aside class="sidebar">
      <div class="brand-section">
        <div class="brand">CA CERT MANAGER</div>
        <p class="brand-subtitle">Admin Control Center</p>
      </div>
      <nav class="nav-menu">
        <a class="nav-link-custom active" href="index.php">Dashboard</a>
        <a class="nav-link-custom" href="users.php">Users</a>
        <a class="nav-link-custom" href="settings.php">Site Settings</a>
        <a class="nav-link-custom" href="profile.php">Admin Profile</a>
      </nav>
      <div class="sidebar-footer">
        <div class="avatar" id="sidebarAvatar">A</div>
        <div class="user-info">
          <strong class="user-name" id="sidebarUser"><?=htmlspecialchars($currentUser['username'])?></strong>
          <span class="user-role" id="sidebarRole"><?=htmlspecialchars($currentUser['role'])?></span>
        </div>
        <a href="../logout.php" class="logout-btn" title="Logout">Logout</a>
      </div>
    </aside>

    <main class="main-content">
      <div class="page-header">
        <div>
          <h1 class="page-title">Admin Dashboard</h1>
          <p class="page-subtitle">Monitor CA users, site settings, and global data from one place.</p>
        </div>
        <div class="page-date" id="pageDate">Date: --</div>
      </div>

      <div class="card-premium" style="max-width: 940px; margin: 0 auto;">
        <div class="card-body-premium">
          <div class="dashboard-grid" style="gap:20px; display:grid; grid-template-columns:repeat(3, minmax(200px, 1fr)); margin-bottom:24px;">
            <div class="dashboard-card">
              <h3>Site Name</h3>
              <p id="siteName">Loading…</p>
            </div>
            <div class="dashboard-card">
              <h3>CA Users</h3>
              <p id="caUserCount">Loading…</p>
            </div>
            <div class="dashboard-card">
              <h3>Total Clients</h3>
              <p id="clientCount">Loading…</p>
            </div>
          </div>

          <div style="display:flex; flex-wrap:wrap; gap:20px; align-items:flex-start;">
            <div style="flex:1 1 360px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:18px; padding:24px;">
              <h2 style="margin-top:0;">Admin Controls</h2>
              <p style="color:#475569; margin-bottom:18px;">Use the navigation panel to manage CA users, configure website settings, and update your admin profile.</p>
              <ul style="padding-left:20px; color:#334155;">
                <li style="margin-bottom:10px;">Create and delete CA accounts</li>
                <li style="margin-bottom:10px;">Edit site name, description, and contact email</li>
                <li style="margin-bottom:10px;">Update your admin password</li>
              </ul>
            </div>

            <div style="flex:1 1 360px; background:#ffffff; border:1px solid #e2e8f0; border-radius:18px; padding:24px;">
              <h2 style="margin-top:0;">Quick Links</h2>
              <a href="users.php" class="btn-custom" style="display:inline-block; margin-bottom:12px;">Manage CA Users</a><br>
              <a href="settings.php" class="btn-custom btn-custom-secondary" style="display:inline-block; margin-bottom:12px;">Site Settings</a><br>
              <a href="profile.php" class="btn-custom btn-custom-danger" style="display:inline-block;">Admin Profile</a>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script>
    const pageDate = document.getElementById('pageDate');
    const siteName = document.getElementById('siteName');
    const caUserCount = document.getElementById('caUserCount');
    const clientCount = document.getElementById('clientCount');

    function setCurrentDate() {
      const today = new Date();
      pageDate.textContent = 'Date: ' + today.toLocaleDateString('en-IN', { day:'2-digit', month:'short', year:'numeric' });
    }

    async function loadStats() {
      try {
        const response = await fetch('../database/db.php?action=dashboard_stats');
        const result = await response.json();
        if (result.success) {
          siteName.textContent = result.stats.site_name || 'CA Certificate Manager';
          caUserCount.textContent = result.stats.ca_users;
          clientCount.textContent = result.stats.clients;
        } else {
          siteName.textContent = 'Unable to load';
          caUserCount.textContent = '—';
          clientCount.textContent = '—';
        }
      } catch (error) {
        siteName.textContent = 'Unable to load';
        caUserCount.textContent = '—';
        clientCount.textContent = '—';
      }
    }

    setCurrentDate();
    loadStats();
  </script>
</body>
</html>
