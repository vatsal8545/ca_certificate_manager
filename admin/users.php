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
  <title>Manage CA Users - Admin Panel</title>
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
        <a class="nav-link-custom active" href="users.php">Users</a>
        <a class="nav-link-custom" href="settings.php">Site Settings</a>
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
          <h1 class="page-title">CA User Management</h1>
          <p class="page-subtitle">Create, edit, and remove CA accounts.</p>
        </div>
        <div class="page-date" id="pageDate">Date: --</div>
      </div>

      <div class="card-premium" style="max-width: 940px; margin: 0 auto;">
        <div class="card-body-premium">
          <div style="margin-bottom:24px; display:flex; flex-wrap:wrap; gap:16px;">
            <form id="createUserForm" style="display:grid; gap:12px; width:100%; max-width:560px;">
              <h2 style="margin:0 0 12px;">Create New CA User</h2>
              <div style="display:grid; gap:12px; grid-template-columns:1fr 1fr;">
                <input id="newUsername" class="form-control" placeholder="Username" required />
                <input id="newPassword" class="form-control" type="password" placeholder="Password" required />
              </div>
              <button type="submit" class="btn-custom" style="width:170px;">Create Account</button>
              <div id="adminUserAlert" style="display:none; padding:12px; border-radius:12px; font-weight:600;"></div>
            </form>
          </div>

          <div>
            <h2 style="margin-top:0;">Registered CA Users</h2>
            <div class="table-responsive">
              <table class="table-custom" style="width:100%; border-collapse:collapse;">
                <thead>
                  <tr>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="userTableBody">
                  <tr><td colspan="4" class="text-center" style="padding:20px 0; color:#64748b;">Loading users…</td></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script>
    const pageDate = document.getElementById('pageDate');
    const userTableBody = document.getElementById('userTableBody');
    const adminUserAlert = document.getElementById('adminUserAlert');

    function setCurrentDate() {
      const today = new Date();
      pageDate.textContent = 'Date: ' + today.toLocaleDateString('en-IN', { day:'2-digit', month:'short', year:'numeric' });
    }

    function showAlert(message, type = 'success') {
      adminUserAlert.style.display = 'block';
      adminUserAlert.style.backgroundColor = type === 'error' ? '#fee2e2' : '#ecfdf5';
      adminUserAlert.style.color = type === 'error' ? '#b91c1c' : '#166534';
      adminUserAlert.style.border = type === 'error' ? '1px solid #fca5a5' : '1px solid #a7f3d0';
      adminUserAlert.textContent = message;
      setTimeout(() => adminUserAlert.style.display = 'none', 6000);
    }

    async function loadUsers() {
      try {
        const response = await fetch('../database/db.php?action=list_users');
        const result = await response.json();
        if (!result.success) {
          userTableBody.innerHTML = `<tr><td colspan="4" class="text-center" style="padding:20px 0; color:#b91c1c;">${result.error || 'Unable to load users.'}</td></tr>`;
          return;
        }

        if (!result.users.length) {
          userTableBody.innerHTML = '<tr><td colspan="4" class="text-center" style="padding:20px 0; color:#64748b;">No CA accounts found.</td></tr>';
          return;
        }

        userTableBody.innerHTML = result.users.map(user => `
          <tr>
            <td>${user.username}</td>
            <td>${user.role}</td>
            <td>${new Date(user.created_at).toLocaleDateString('en-IN', { day:'2-digit', month:'short', year:'numeric' })}</td>
            <td><button class="btn-custom btn-custom-danger btn-sm" onclick="deleteUser(${user.id}, '${encodeURIComponent(user.username)}')">Delete</button></td>
          </tr>
        `).join('');
      } catch (error) {
        userTableBody.innerHTML = '<tr><td colspan="4" class="text-center" style="padding:20px 0; color:#b91c1c;">Unable to load users.</td></tr>';
      }
    }

    async function deleteUser(id, username) {
      if (!confirm(`Delete CA user ${decodeURIComponent(username)}?`)) return;
      try {
        const response = await fetch('../database/db.php?action=delete_user', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id })
        });
        const result = await response.json();
        if (!result.success) {
          showAlert(result.error || 'Unable to delete user.', 'error');
          return;
        }
        showAlert('User deleted successfully.');
        loadUsers();
      } catch (error) {
        showAlert('Unable to delete user.', 'error');
      }
    }

    document.getElementById('createUserForm').addEventListener('submit', async e => {
      e.preventDefault();
      const username = document.getElementById('newUsername').value.trim();
      const password = document.getElementById('newPassword').value.trim();
      if (!username || !password) {
        showAlert('Username and password are required.', 'error');
        return;
      }
      try {
        const response = await fetch('../database/db.php?action=create_user', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ username, password })
        });
        const result = await response.json();
        if (!result.success) {
          showAlert(result.error || 'Unable to create user.', 'error');
          return;
        }
        showAlert('CA account created successfully.');
        document.getElementById('newUsername').value = '';
        document.getElementById('newPassword').value = '';
        loadUsers();
      } catch (error) {
        showAlert('Unable to create user.', 'error');
      }
    });

    setCurrentDate();
    loadUsers();
  </script>
</body>
</html>
