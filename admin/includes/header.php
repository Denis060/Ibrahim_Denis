<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Admin Stylesheet -->
  <link rel="stylesheet" href="assets/css/admin.css">
  <script src="assets/js/admin.js" defer></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="dark-mode">

  <!-- 🔹 Admin Top Header Bar -->
  <div class="admin-header">
    <h1>🛠️ Admin Panel</h1>
    <div class="admin-header-right">
      <span>👋 <?= $_SESSION['admin_username'] ?? 'Admin' ?></span>
      <a href="logout.php" class="btn btn-delete" style="margin-left: 15px;">🚪 Logout</a>
    </div>
    

  </div>

  <!-- 🔹 Content Container -->
  <div class="admin-content">
