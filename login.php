<?php
session_start();
require_once __DIR__ . '/database/db.php';

$error = $dbInitError ?? '';
$successMessage = '';
if (isset($_GET['registered']) && $_GET['registered'] === '1') {
    $successMessage = 'Registration successful. Please log in with your new credentials.';
}

if (isset($_SESSION['user'])) {
    header('Location: ' . (($_SESSION['user']['role'] ?? '') === 'Administrator' ? 'admin/index.php' : 'index.php'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    try {
        $pdo = getDbConnection();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => (int)$user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
            ];

            if ($user['role'] === 'Administrator') {
                header('Location: admin/index.php');
            } else {
                header('Location: index.php');
            }
            exit;
        }

        $error = 'Invalid username or password.';
    } catch (Throwable $e) {
        $error = 'Database error. Please check MySQL setup.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - CA Certificate Manager</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Outfit:wght@500;600;700;800;900&display=swap');

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Inter', sans-serif;
      background:
        radial-gradient(circle at top left, rgba(200, 155, 60, 0.12), transparent 30%),
        radial-gradient(circle at bottom right, rgba(45, 95, 84, 0.12), transparent 25%),
        linear-gradient(135deg, #f7f4ee 0%, #f8faf7 45%, #eef3f0 100%);
      color: #1a1f1b;
    }

    .login-container {
      width: 100%;
      max-width: 430px;
      padding: 20px;
    }

    .login-card {
      position: relative;
      background: rgba(255, 255, 255, 0.88);
      border: 1px solid rgba(148, 163, 184, 0.18);
      border-radius: 24px;
      box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12);
      padding: 32px 28px 28px;
      backdrop-filter: blur(8px);
      overflow: hidden;
    }

    .login-card::before {
      content: "";
      position: absolute;
      inset: 0 0 auto 0;
      height: 6px;
      background: linear-gradient(90deg, #171d1b, #2d5f54, #c89b3c);
    }

    .brand-logo {
      width: 62px;
      height: 62px;
      border-radius: 18px;
      margin: 0 auto 18px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #171d1b 0%, #2d5f54 100%);
      color: #f1c75a;
      box-shadow: 0 16px 30px rgba(45, 95, 84, 0.18);
    }

    .login-header {
      text-align: center;
      margin-bottom: 26px;
    }

    .login-header h1 {
      font-family: 'Outfit', sans-serif;
      font-size: clamp(1.6rem, 2vw, 2rem);
      font-weight: 800;
      letter-spacing: -0.04em;
      color: #0f172a;
      margin: 0;
    }

    .login-header p {
      margin: 8px 0 0;
      font-size: 0.74rem;
      font-weight: 700;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: #64748b;
    }

    .form-group {
      margin-bottom: 18px;
    }

    .form-label {
      display: block;
      margin-bottom: 8px;
      font-size: 0.8rem;
      font-weight: 700;
      color: #334155;
    }

    .input-wrapper {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #64748b;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .form-control {
      width: 100%;
      height: 48px;
      border: 1px solid #cbd5e1;
      border-radius: 12px;
      background: #f8fafc;
      color: #0f172a;
      padding: 0 14px 0 42px;
      font-size: 0.94rem;
      transition: all 0.2s ease;
    }

    .form-control:focus {
      outline: none;
      border-color: rgba(29, 78, 216, 0.6);
      box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12);
      background: #fff;
    }

    .btn-login {
      width: 100%;
      height: 48px;
      border: none;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin-top: 20px;
      background: linear-gradient(135deg, #171d1b 0%, #c89b3c 100%);
      color: #fff;
      font-size: 0.96rem;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0 12px 24px rgba(200, 155, 60, 0.18);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-login:hover {
      transform: translateY(-1px);
      box-shadow: 0 16px 28px rgba(29, 78, 216, 0.22);
    }

    .error-alert {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 20px;
      padding: 10px 12px;
      border-radius: 10px;
      background: #fef2f2;
      border: 1px solid #fecaca;
      color: #b91c1c;
      font-size: 0.85rem;
      font-weight: 600;
    }

    @media (max-width: 480px) {
      .login-card {
        padding: 26px 20px 22px;
      }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-card">
      <div style="text-align: center; margin-bottom: 26px;">
        <div class="brand-logo">
          <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16"><path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.622-.058-.006a2.89 2.89 0 0 0-3.322 3.322l.006.058-.622.622a2.89 2.89 0 0 0 0 4.134l.622.622-.006.058a2.89 2.89 0 0 0 3.322 3.322l.058-.006.622.622a2.89 2.89 0 0 0 4.134 0l.622-.622.058.006a2.89 2.89 0 0 0 3.322-3.322l-.006-.058.622-.622a2.89 2.89 0 0 0 0-4.134l-.622-.622.006-.058a2.89 2.89 0 0 0-3.322-3.322l-.058.006zm-5.69 2.477a1.89 1.89 0 0 1 2.174-2.174l.08.008.835-.835a1.89 1.89 0 0 1 2.67 0l.836.835.08-.008a1.89 1.89 0 0 1 2.174 2.174l-.008.08.835.836a1.89 1.89 0 0 1 0 2.67l-.835.835.008.08a1.89 1.89 0 0 1-2.174 2.174l-.08-.008-.835.835a1.89 1.89 0 0 1-2.67 0l-.836-.835-.08.008a1.89 1.89 0 0 1-2.174-2.174l.008-.08-.835-.836a1.89 1.89 0 0 1 0-2.67l.835-.835-.008-.08zm1.968 4.398a.5.5 0 0 0-.83.604l1.5 2.062a.5.5 0 0 0 .747.078l2.5-2.5a.5.5 0 0 0-.707-.708L7.75 9.423z"/></svg>
        </div>
        <div class="login-header">
          <h1>CA Certificate Manager</h1>
          <p>Simple • Fast • Accurate</p>
        </div>
      </div>

      <?php if ($error): ?>
        <div class="error-alert">
          <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044 10.396a.75.75 0 1 0-1.5 0 .75.75 0 0 0 1.5 0zM8 5a.5.5 0 0 0-.5.5v3.793l-1.354-1.354a.5.5 0 1 0-.708.708l2.207 2.207a.5.5 0 0 0 .708 0l2.207-2.207a.5.5 0 0 0-.708-.708L8.5 9.293V5.5A.5.5 0 0 0 8 5z"/></svg>
          <span><?=htmlspecialchars($error)?></span>
        </div>
      <?php endif; ?>

      <?php if (!empty($successMessage)): ?>
        <div class="error-alert" style="background:#ecfdf5; border-color:#bbf7d0; color:#166534;">
          <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM7.998 4.5a.75.75 0 1 0-1.5 0v3.25a.75.75 0 0 0 .75.75h2.5a.75.75 0 0 0 0-1.5H7.998V4.5zm0 7a.875.875 0 1 0 0-1.75.875.875 0 0 0 0 1.75z"/></svg>
          <span><?=htmlspecialchars($successMessage)?></span>
        </div>
      <?php endif; ?>

      <form method="post" autocomplete="off">
        <div class="form-group">
          <label for="username" class="form-label">Username</label>
          <div class="input-wrapper">
            <span class="input-icon">
              <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/></svg>
            </span>
            <input id="username" name="username" class="form-control" required placeholder="Your username" value="">
          </div>
        </div>

        <div class="form-group">
          <label for="password" class="form-label">Password</label>
          <div class="input-wrapper">
            <span class="input-icon">
              <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/></svg>
            </span>
            <input id="password" name="password" type="password" class="form-control" required placeholder="••••••••" value="">
          </div>
        </div>

        <button type="submit" class="btn-login">
          <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/><path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/></svg>
          Sign In
        </button>
      </form>
      <div style="margin-top: 20px; text-align: center; font-size: 0.9rem; color: #475569;">
        <span>New to CA Certificate Manager?</span>
        <a href="register.php" style="color: #1d4ed8; text-decoration: none; font-weight: 700;">Create an account</a>
      </div>
      <div style="margin-top: 10px; text-align: center; font-size: 0.9rem; color: #475569;">
        <a href="home.php" style="color: #1d4ed8; text-decoration: none; font-weight: 700;">Back to Home</a>
      </div>
    </div>
  </div>
</body>
</html>
