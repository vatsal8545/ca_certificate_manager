<?php
session_start();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    // For now use a single hardcoded admin credential. You can replace this with DB lookup.
    $adminUser = 'admin';
    $adminPass = 'admin123';
    if ($username === $adminUser && $password === $adminPass) {
        $_SESSION['user'] = [
            'username' => $username,
            'role' => 'Administrator',
        ];
        header('Location: index.php');
        exit;
    }
    $error = 'Invalid username or password.';
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - CA Certificate Manager</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    body { margin: 0; font-family: 'Inter', sans-serif; background: linear-gradient(135deg,#eef2f7 0%,#dbeafe 45%,#eff6ff 100%); color: #0f172a; }
    .login-page { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; }
    .login-box { width: 100%; max-width: 420px; background: rgba(255,255,255,.96); border-radius: 28px; box-shadow: 0 30px 80px rgba(15,23,42,.12); padding: 36px; }
    .login-brand { display: flex; align-items: center; gap: 14px; margin-bottom: 26px; }
    .login-brand-mark { width: 52px; height: 52px; border-radius: 18px; background: linear-gradient(135deg,#2563eb,#22c55e); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 1.1rem; }
    .login-title h1 { margin: 0; font-size: 1.55rem; line-height: 1.1; }
    .login-title p { margin: 6px 0 0; color: #475569; font-size: .95rem; line-height: 1.7; }
    .login-note { margin-bottom: 24px; color: #475569; font-size: .95rem; line-height: 1.7; }
    .login-field { margin-bottom: 18px; }
    .login-field label { display: block; margin-bottom: 10px; color: #334155; font-size: .95rem; }
    .login-field input { width: 100%; height: 52px; padding: 0 18px; border-radius: 16px; border: 1px solid #dbeafe; background: #f8fbff; color: #0f172a; font-size: 1rem; transition: border-color .2s ease, box-shadow .2s ease; }
    .login-field input:focus { border-color: #2563eb; box-shadow: 0 0 0 10px rgba(37,99,235,.12); outline: none; }
    .login-actions { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-top: 12px; }
    .login-actions button { width: 100%; border-radius: 16px; padding: 14px 20px; border: none; background: linear-gradient(135deg,#2563eb,#22c55e); color: #fff; font-weight: 700; font-size: 1rem; cursor: pointer; box-shadow: 0 16px 32px rgba(37,99,235,.16); }
    .login-actions a { color: #2563eb; font-size: .95rem; text-decoration: none; white-space: nowrap; }
    .login-footer { margin-top: 22px; color: #64748b; font-size: .93rem; line-height: 1.6; }
    .error { color: #dc2626; margin-bottom: 16px; font-size: .94rem; }
    @media (max-width: 520px) { .login-box { padding: 28px 22px; } }
  </style>
</head>
<body>
  <div class="login-page">
    <div class="login-box">
      <div class="login-brand">
        <div class="login-brand-mark">CA</div>
        <div class="login-title">
          <h1>CA Certificate Manager</h1>
            <p>Simple • Fast • Accurate</p>
        </div>
      </div>
      
      <?php if ($error): ?><div class="error"><?=htmlspecialchars($error)?></div><?php endif; ?>
      <form method="post">
        <div class="login-field">
          <label for="username">Username</label>
          <input id="username" name="username" required autocomplete="username" placeholder="admin">
        </div>
        <div class="login-field">
          <label for="password">Password</label>
          <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="••••••••">
        </div>
        <div class="login-actions">
          <button type="submit">Login</button>
        </div>
      </form>
       
    </div>
  </div>
</body>
</html>
