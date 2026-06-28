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
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .profile-page { min-height: 100vh; background: #eef2f7; }
    .profile-shell { display: flex; min-height: 100vh; }
    .profile-main { flex: 1; padding: 32px; }
    .profile-header { display: flex; flex-wrap: wrap; justify-content: space-between; gap: 18px; margin-bottom: 28px; }
    .profile-card { background: #fff; border-radius: 24px; box-shadow: 0 24px 80px rgba(15,23,42,.08); padding: 28px; max-width: 840px; margin: 0 auto; }
    .profile-banner { display: flex; align-items: center; gap: 18px; margin-bottom: 18px; }
    .profile-avatar { width: 80px; height: 80px; border-radius: 24px; background: linear-gradient(135deg,#2563eb,#22c55e); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.75rem; font-weight: 800; }
    .profile-info h1 { margin: 0; font-size: 1.9rem; color: #0f172a; }
    .profile-info p { margin: 6px 0 0; color: #64748b; line-height: 1.7; }
    .profile-grid { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 20px; margin-top: 22px; }
    .profile-box { background: #f8fafc; border-radius: 20px; padding: 22px; }
    .profile-box h3 { margin: 0 0 12px; font-size: 1rem; color: #334155; }
    .profile-box p { margin: 0; color: #475569; line-height: 1.8; }
    .profile-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 20px; }
    .profile-actions a { display: inline-flex; align-items: center; justify-content: center; min-width: 160px; text-align: center; border-radius: 16px; background: #10b981; color: #fff; padding: 14px 18px; font-weight: 700; text-decoration: none; transition: transform .2s ease, filter .2s ease; }
    .profile-actions a.logout { background: #ef4444; }
    .profile-actions a:hover { transform: translateY(-1px); filter: brightness(1.05); }
    @media (max-width: 760px) { .profile-grid { grid-template-columns: 1fr; } .profile-banner { flex-direction: column; align-items: flex-start; } }
  </style>
</head>
<body class="profile-page">
  <div class="profile-shell">
    <main class="profile-main">
      <div class="profile-card">
        <div class="profile-banner">
          <div class="profile-avatar">A</div>
          <div class="profile-info">
            <h1>Admin Profile</h1>
            <p>Your access to CA Certificate Management is protected by session-based login. Client records are stored in browser memory and local storage.</p>
          </div>
        </div>

        <div class="profile-grid">
          <div class="profile-box">
            <h3>Profile Details</h3>
            <p><strong>Username:</strong> <?=htmlspecialchars($user['username'])?></p>
            <p><strong>Role:</strong> <?=htmlspecialchars($user['role'])?></p>
          </div>
          <div class="profile-box">
            <h3>Session Data</h3>
            <p>This page uses PHP session data to keep you signed in. All certificate information remains local to the browser, not in an external database.</p>
          </div>
        </div>

        <div class="profile-actions">
          <a href="index.php">Go to Dashboard</a>
          <a class="logout" href="logout.php">Logout</a>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
