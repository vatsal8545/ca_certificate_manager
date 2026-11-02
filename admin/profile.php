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
  <title>Admin Profile - Admin Panel</title>
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
        <a class="nav-link-custom" href="settings.php">Site Settings</a>
        <a class="nav-link-custom active" href="profile.php">Admin Profile</a>
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
          <h1 class="page-title">Admin Profile</h1>
          <p class="page-subtitle">Update your account information and password.</p>
        </div>
        <div class="page-date" id="pageDate">Date: --</div>
      </div>

      <div class="card-premium" style="max-width: 920px; margin: 0 auto;">
        <div class="card-body-premium">
          <div style="display:grid; gap:18px;">
            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:18px; padding:22px;">
              <h2 style="margin-top:0;">Admin Account</h2>
              <p><strong>Username:</strong> <?=htmlspecialchars($currentUser['username'])?></p>
              <p><strong>Role:</strong> <?=htmlspecialchars($currentUser['role'])?></p>
            </div>

            <form id="changePasswordForm" style="display:grid; gap:16px;">
              <h2 style="margin:0;">Change Password</h2>
              <div class="form-group">
                <label class="form-label" for="currentPassword">Current Password</label>
                <input id="currentPassword" name="currentPassword" class="form-control" type="password" required />
              </div>
              <div class="form-group">
                <label class="form-label" for="newPassword">New Password</label>
                <input id="newPassword" name="newPassword" class="form-control" type="password" required />
              </div>
              <div class="form-group">
                <label class="form-label" for="confirmPassword">Confirm New Password</label>
                <input id="confirmPassword" name="confirmPassword" class="form-control" type="password" required />
              </div>
              <button type="submit" class="btn-custom" style="width:170px;">Update Password</button>
              <div id="profileAlert" style="display:none; padding:12px; border-radius:12px; font-weight:600;"></div>
            </form>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script>
    const pageDate = document.getElementById('pageDate');
    const profileAlert = document.getElementById('profileAlert');

    function setCurrentDate() {
      const today = new Date();
      pageDate.textContent = 'Date: ' + today.toLocaleDateString('en-IN', { day:'2-digit', month:'short', year:'numeric' });
    }

    function showAlert(message, type = 'success') {
      profileAlert.style.display = 'block';
      profileAlert.style.backgroundColor = type === 'error' ? '#fee2e2' : '#ecfdf5';
      profileAlert.style.color = type === 'error' ? '#b91c1c' : '#166534';
      profileAlert.style.border = type === 'error' ? '1px solid #fca5a5' : '1px solid #a7f3d0';
      profileAlert.textContent = message;
      setTimeout(() => profileAlert.style.display = 'none', 6000);
    }

    document.getElementById('changePasswordForm').addEventListener('submit', async e => {
      e.preventDefault();
      const payload = {
        current_password: document.getElementById('currentPassword').value.trim(),
        new_password: document.getElementById('newPassword').value.trim(),
        confirm_password: document.getElementById('confirmPassword').value.trim(),
      };

      try {
        const response = await fetch('../database/db.php?action=change_password', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
        const result = await response.json();
        if (!result.success) {
          showAlert(result.error || 'Unable to update password.', 'error');
          return;
        }
        showAlert('Password updated successfully.');
        document.getElementById('changePasswordForm').reset();
      } catch (error) {
        showAlert('Unable to update password.', 'error');
      }
    });

    setCurrentDate();
  </script>
</body>
</html>
