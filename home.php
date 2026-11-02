<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: ' . (($_SESSION['user']['role'] ?? '') === 'Administrator' ? 'admin/index.php' : 'index.php'));
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CA Certificate Manager</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Outfit:wght@500;600;700;800;900&display=swap');
    * { box-sizing: border-box; }
    body { margin:0; min-height:100vh; display:flex; align-items:center; justify-content:center; font-family:'Inter',sans-serif; background: linear-gradient(135deg, #eef2ff 0%, #dbeafe 35%, #f8fafc 100%); color:#0f172a; }
    .hero-container { width:100%; max-width:980px; padding:24px; }
    .hero-card { background:#ffffff; border:1px solid #cbd5e1; border-radius:26px; box-shadow:0 24px 60px rgba(15,23,42,0.12); overflow:hidden; display:grid; grid-template-columns:1fr 360px; gap:0; }
    .hero-content { padding:40px; }
    .hero-content h1 { font-family:'Outfit',sans-serif; font-size:clamp(2.4rem,4vw,3.6rem); margin:0 0 18px; color:#0f172a; }
    .hero-content p { max-width:620px; margin:0 0 24px; font-size:1rem; line-height:1.8; color:#475569; }
    .hero-buttons { display:flex; flex-wrap:wrap; gap:14px; }
    .hero-btn { display:inline-flex; align-items:center; justify-content:center; min-width:170px; padding:14px 20px; border-radius:14px; border:none; cursor:pointer; font-size:0.96rem; font-weight:700; text-decoration:none; color:#ffffff; background:#1d4ed8; transition:transform .2s ease,box-shadow .2s ease; }
    .hero-btn.secondary { background:#0f172a; }
    .hero-btn:hover { transform:translateY(-1px); box-shadow:0 16px 28px rgba(15,23,42,0.16); }
    .hero-aside { background:linear-gradient(180deg, #f8fafc 0%, #e2e8f0 100%); padding:40px; display:flex; flex-direction:column; justify-content:center; }
    .feature { display:flex; gap:14px; align-items:flex-start; margin-bottom:20px; }
    .feature-icon { width:44px; height:44px; border-radius:14px; background:#1d4ed8; color:#fff; display:flex; align-items:center; justify-content:center; font-size:1.1rem; }
    .feature-text h3 { margin:0 0 6px; font-size:1rem; color:#0f172a; }
    .feature-text p { margin:0; color:#475569; font-size:0.92rem; line-height:1.6; }
    @media (max-width: 900px) { .hero-card { grid-template-columns:1fr; } }
    @media (max-width: 560px) { .hero-content { padding:28px; } .hero-aside { padding:28px; } }
  </style>
</head>
<body>
  <div class="hero-container">
    <div class="hero-card">
      <div class="hero-content">
        <h1>Welcome to CA Certificate Manager</h1>
        <p>Manage CA firm settings, client certificates, and user access from one secure dashboard. Login to continue or register a new CA account to start managing clients and generating certificates.</p>
        <div class="hero-buttons">
          <a class="hero-btn" href="login.php">Login</a>
          <a class="hero-btn secondary" href="register.php">Register</a>
        </div>
      </div>
      <div class="hero-aside">
        <div class="feature">
          <div class="feature-icon">✓</div>
          <div class="feature-text"><h3>Secure Authentication</h3><p>Password-hashed login with admin and CA roles.</p></div>
        </div>
        <div class="feature">
          <div class="feature-icon">👤</div>
          <div class="feature-text"><h3>Role-Based Access</h3><p>Admin panel for CA account management and site configuration.</p></div>
        </div>
        <div class="feature">
          <div class="feature-icon">📁</div>
          <div class="feature-text"><h3>Multi-Tenant Data</h3><p>Each CA only sees their own firm settings, clients, and certificates.</p></div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
