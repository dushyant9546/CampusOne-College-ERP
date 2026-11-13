<?php
require_once __DIR__.'/config.php';
if (current_user()) redirect_dashboard();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    $users = load_json(USERS_FILE);
    foreach ($users as $user) {
        if ($user['email'] === $email && $user['role'] === $role && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user'] = array_diff_key($user, ['password'=>true]);
            redirect_dashboard();
        }
    }
    $error = 'Invalid email, password, or selected account type.';
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>CampusOne — Sign in</title><link rel="stylesheet" href="assets/style.css"></head>
<body class="login-body">
<div class="login-shell">
  <section class="login-brand">
    <a class="brand light" href="#"><span class="brand-mark">C</span><span><b>CampusOne</b><small>COLLEGE ERP PORTAL</small></span></a>
    <div class="brand-copy"><span class="kicker">ONE CAMPUS. ONE CONNECTED EXPERIENCE.</span><h1>Your campus life,<br><em>all in one place.</em></h1><p>Stay on top of your academics, connect with faculty, and keep campus operations moving.</p>
      <div class="feature-points"><span>✓ Academic updates</span><span>✓ Role-based workspace</span><span>✓ One secure sign-in</span></div></div>
    <div class="brand-foot">A unified digital campus experience.</div>
  </section>
  <section class="login-panel">
    <div class="mobile-brand"><span class="brand-mark">C</span><b>CampusOne</b></div>
    <div class="login-card"><span class="kicker purple">WELCOME TO CAMPUSONE</span><h2>Sign in to your portal</h2><p class="muted">Choose your account type to continue.</p>
      <?php if ($error): ?><div class="alert"><?=e($error)?></div><?php endif; ?>
      <form method="post" class="login-form">
        <input type="hidden" name="csrf" value="<?=e(csrf_token())?>">
        <label>Login as</label><div class="role-picker">
          <label class="role-option"><input type="radio" name="role" value="student" checked><span>🎓<b>Student</b></span></label>
          <label class="role-option"><input type="radio" name="role" value="faculty"><span>📚<b>Faculty</b></span></label>
          <label class="role-option"><input type="radio" name="role" value="admin"><span>⚙️<b>Admin</b></span></label>
        </div>
        <label for="email">Email address</label><input id="email" name="email" type="email" placeholder="you@college.edu" required autocomplete="username">
        <label for="password">Password</label><div class="password-wrap"><input id="password" name="password" type="password" placeholder="Enter your password" required autocomplete="current-password"><button type="button" id="togglePassword">Show</button></div>
        <button class="btn primary full" type="submit">Sign in <span>→</span></button>
      </form>
      <div class="demo-box"><b>Demo login credentials</b><div><span>Student</span><code>student@campusone.demo</code><code>Student@123</code></div><div><span>Faculty</span><code>faculty@campusone.demo</code><code>Faculty@123</code></div><div><span>Admin</span><code>admin@campusone.demo</code><code>Admin@123</code></div></div>
      <p class="login-note">Demo project only · Use sample credentials above.</p>
    </div>
  </section>
</div><script src="assets/app.js"></script></body></html>
