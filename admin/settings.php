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
  <title>Site Settings - Admin Panel</title>
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
        <a class="nav-link-custom" href="index.php">Dashboard</a>
        <a class="nav-link-custom" href="users.php">Users</a>
        <a class="nav-link-custom active" href="settings.php">Site Settings</a>
        <a class="nav-link-custom" href="profile.php">Admin Profile</a>
      </nav>
      <div class="sidebar-footer">
        <div class="avatar" id="sidebarAvatar">A</div>
        <div class="user-info">
          <strong class="user-name"><?=htmlspecialchars($currentUser['username'])?></strong>
          <span class="user-role"><?=htmlspecialchars($currentUser['role'])?></span>
        </div>
        <a href="../logout.php" class="logout-btn" title="Logout">Logout</a>
      </div>
    </aside>

    <main class="main-content">
      <div class="page-header">
        <div>
          <h1 class="page-title">Site Settings</h1>
          <p class="page-subtitle">Update the website title, description, and contact email.</p>
        </div>
        <div class="page-date" id="pageDate">Date: --</div>
      </div>

      <div class="card-premium" style="max-width: 920px; margin: 0 auto;">
        <div class="card-body-premium">
          <form id="settingsForm" style="display:grid; gap:18px;">
            <div class="form-group">
              <label class="form-label" for="siteName">Site Name</label>
              <input id="siteName" name="siteName" class="form-control" type="text" placeholder="Site Name" required>
            </div>
            <div class="form-group">
              <label class="form-label" for="siteDescription">Site Description</label>
              <textarea id="siteDescription" name="siteDescription" class="form-control" rows="4" placeholder="Site description"></textarea>
            </div>
            <div class="form-group">
              <label class="form-label" for="contactEmail">Contact Email</label>
              <input id="contactEmail" name="contactEmail" class="form-control" type="email" placeholder="contact@example.com">
            </div>
            <button type="submit" class="btn-custom" style="width:170px;">Save Settings</button>
            <div id="settingsAlert" style="display:none; padding:12px; border-radius:12px; font-weight:600;"></div>
          </form>
        </div>
      </div>
    </main>
  </div>

  <script>
    const pageDate = document.getElementById('pageDate');
    const settingsAlert = document.getElementById('settingsAlert');

    function setCurrentDate() {
      const today = new Date();
      pageDate.textContent = 'Date: ' + today.toLocaleDateString('en-IN', { day:'2-digit', month:'short', year:'numeric' });
    }

    function showAlert(message, type = 'success') {
      settingsAlert.style.display = 'block';
      settingsAlert.style.backgroundColor = type === 'error' ? '#fee2e2' : '#ecfdf5';
      settingsAlert.style.color = type === 'error' ? '#b91c1c' : '#166534';
      settingsAlert.style.border = type === 'error' ? '1px solid #fca5a5' : '1px solid #a7f3d0';
      settingsAlert.textContent = message;
      setTimeout(() => settingsAlert.style.display = 'none', 6000);
    }

    async function loadSettings() {
      try {
        const response = await fetch('../database/db.php?action=load_site_settings');
        const result = await response.json();
        if (result.success && result.site) {
          document.getElementById('siteName').value = result.site.site_name || '';
          document.getElementById('siteDescription').value = result.site.site_description || '';
          document.getElementById('contactEmail').value = result.site.contact_email || '';
        }
      } catch (error) {
        showAlert('Unable to load site settings.', 'error');
      }
    }

    document.getElementById('settingsForm').addEventListener('submit', async e => {
      e.preventDefault();
      const payload = {
        siteName: document.getElementById('siteName').value.trim(),
        siteDescription: document.getElementById('siteDescription').value.trim(),
        contactEmail: document.getElementById('contactEmail').value.trim(),
      };

      try {
        const response = await fetch('../database/db.php?action=save_site_settings', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
        const result = await response.json();
        if (!result.success) {
          showAlert(result.error || 'Unable to save settings.', 'error');
          return;
        }
        showAlert('Site settings saved successfully.');
      } catch (error) {
        showAlert('Unable to save settings.', 'error');
      }
    });

    setCurrentDate();
    loadSettings();
  </script>
</body>
</html>
