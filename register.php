<?php
session_start();
require_once __DIR__ . '/database/db.php';

$error = $dbInitError ?? '';

if (isset($_SESSION['user'])) {
    header('Location: ' . (($_SESSION['user']['role'] ?? '') === 'Administrator' ? 'admin/index.php' : 'index.php'));
    exit;
}

$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');

    if ($username === '' || $password === '' || $confirmPassword === '') {
        $error = 'All fields are required.';
    } elseif ($password !== $confirmPassword) {
        $error = 'The passwords do not match.';
    } elseif (strtolower($username) === 'admin' || strtolower($password) === 'admin123') {
        $error = 'Reserved admin credentials cannot be used for CA registration.';
    } else {
        try {
            $pdo = getDbConnection();
            $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? LIMIT 1');
            $stmt->execute([$username]);
            if ($stmt->fetch()) {
                $error = 'This username is already taken.';
            } else {
                $stmt = $pdo->prepare('INSERT INTO users (username, password, role) VALUES (?, ?, ?)');
                $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT), 'CA']);
                header('Location: login.php?registered=1');
                exit;
            }
        } catch (Throwable $e) {
            $error = 'Database error. Please contact the administrator.';
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register - CA Certificate Manager</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Outfit:wght@500;600;700;800;900&display=swap');
    * { box-sizing: border-box; }
    body { margin:0; min-height:100vh; display:flex; align-items:center; justify-content:center; font-family:'Inter',sans-serif; background: radial-gradient(circle at top left, rgba(200, 155, 60, 0.12), transparent 30%), radial-gradient(circle at bottom right, rgba(45, 95, 84, 0.12), transparent 25%), linear-gradient(135deg,#f7f4ee 0%,#f8faf7 45%,#eef3f0 100%); color:#1a1f1b; }
    .card { width:100%; max-width:460px; padding:32px; background:rgba(255,255,255,0.92); border:1px solid rgba(148,163,184,0.18); border-radius:24px; box-shadow:0 24px 60px rgba(15,23,42,0.12); }
    .card h1 { margin:0 0 10px; font-family:'Outfit',sans-serif; font-size:2rem; letter-spacing:-0.04em; color:#0f172a; }
    .card p { margin:0 0 24px; color:#475569; }
    .form-group { margin-bottom:18px; }
    .form-label { display:block; margin-bottom:8px; color:#334155; font-weight:700; font-size:0.9rem; }
    .form-control { width:100%; height:48px; border:1px solid #cbd5e1; border-radius:12px; background:#f8fafc; padding:0 14px; font-size:0.95rem; color:#0f172a; }
    .form-control:focus { outline:none; border-color:rgba(29,78,216,0.6); box-shadow:0 0 0 4px rgba(59,130,246,0.12); background:#fff; }
    .btn-submit { width:100%; height:50px; border:none; border-radius:14px; background:linear-gradient(135deg,#171d1b 0%,#c89b3c 100%); color:#fff; font-size:1rem; font-weight:700; cursor:pointer; transition:transform .2s ease,box-shadow .2s ease; }
    .btn-submit:hover { transform:translateY(-1px); box-shadow:0 16px 28px rgba(29,78,216,0.22); }
    .error-note { margin-bottom:20px; padding:12px 14px; border-radius:12px; background:#fee2e2; border:1px solid #fecaca; color:#b91c1c; font-weight:700; }
    .footer-link { margin-top:18px; text-align:center; color:#475569; font-size:0.95rem; }
    .footer-link a { color:#1d4ed8; font-weight:700; text-decoration:none; }
  </style>
</head>
<body>
  <div class="card">
    <h1>Create CA Account</h1>
    <p>Register a CA user account to manage clients and generate certificates.</p>
    <?php if ($error): ?>
      <div class="error-note"><?=htmlspecialchars($error)?></div>
    <?php endif; ?>
    <form method="post" autocomplete="off">
      <div class="form-group">
        <label class="form-label" for="username">Username</label>
        <input id="username" name="username" class="form-control" type="text" placeholder="Choose a username" value="<?=htmlspecialchars($_POST['username'] ?? '')?>" required>
      </div>
      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <input id="password" name="password" class="form-control" type="password" placeholder="Enter password" required>
      </div>
      <div class="form-group">
        <label class="form-label" for="confirm_password">Confirm Password</label>
        <input id="confirm_password" name="confirm_password" class="form-control" type="password" placeholder="Repeat password" required>
      </div>
      <button type="submit" class="btn-submit">Register</button>
    </form>
    <div class="footer-link">
      Already registered? <a href="login.php">Sign in</a>
    </div>
    <div class="footer-link" style="margin-top:10px;">
      <a href="home.php">Back to Home</a>
    </div>
  </div>
</body>
</html>
