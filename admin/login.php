<?php
session_start();
require_once '../includes/db.php';

// Redirect if already logged in
if (isset($_SESSION['admin_id'])) {
  header("Location: dashboard.php");
  exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = $_POST['password'];

  $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
  $stmt->execute([$username]);
  $admin = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($admin && password_verify($password, $admin['password_hash'])) {
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_username'] = $admin['username'];
    $_SESSION['admin_role'] = $admin['role'];
    header("Location: dashboard.php");
    exit;
  } else {
    $error = "Invalid username or password.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <link rel="stylesheet" href="styles/admin.css">
  <style>
    body {
      background-color: #0f172a;
      font-family: 'Segoe UI', sans-serif;
      color: #f1f5f9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .login-box {
      background-color: #1e293b;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.2);
      width: 100%;
      max-width: 400px;
    }

    .login-box h2 {
      margin-bottom: 20px;
      text-align: center;
      color: #93c5fd;
    }

    .input {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      background-color: #334155;
      color: #e2e8f0;
      border: none;
      border-radius: 8px;
    }

    .btn {
      width: 100%;
      padding: 10px;
      background-color: #2563eb;
      color: white;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .btn:hover {
      background-color: #1d4ed8;
    }

    .alert-error {
      background-color: #ef4444;
      color: white;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 6px;
      text-align: center;
    }

    .footer-note {
      margin-top: 15px;
      text-align: center;
      font-size: 0.85em;
      color: #64748b;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>🔐 Admin Login</h2>

    <?php if ($error): ?>
      <div class="alert-error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
      <input type="text" name="username" class="input" placeholder="Username" required>
      <input type="password" name="password" class="input" placeholder="Password" required>
      <button type="submit" class="btn">Login</button>
    </form>

    <div class="footer-note">© <?= date('Y') ?> Ibrahim Denis Fofanah</div>
  </div>
</body>
</html>
