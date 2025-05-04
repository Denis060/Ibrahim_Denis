<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Ibrahim Denis Fofanah</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Fonts & Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/experience.css">
  <link rel="stylesheet" href="assets/css/certifications.css">
  <link rel="stylesheet" href="assets/css/about.css">
  <link rel="stylesheet" href="assets/css/index.css">
  <link rel="stylesheet" href="assets/css/projects.css">
  <link rel="stylesheet" href="assets/css/education.css">
  <link rel="stylesheet" href="assets/css/expertise.css">
  <link rel="stylesheet" href="assets/css/recognition.css">
  <link rel="stylesheet" href="assets/css/scrollbar.css">
  <!-- Scripts -->
  <script defer src="assets/js/main.js"></script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="<?= isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'light' ? 'light-mode' : 'dark-mode' ?>">

  <!-- Top Navigation -->
  <nav id="navbar" class="navbar">
    <ul class="nav-links">
      <li><a href="about.php"><span>👋</span> About</a></li>
      <li><a href="experience.php"><span>💼</span> Experience</a></li>
      <li><a href="education.php"><span>🎓</span> Education</a></li>
      <li><a href="certifications.php"><span>🏆</span> Certifications</a></li>
      <li><a href="projects.php"><span>🚀</span> Projects</a></li>
      <li><a href="expertise.php"><span>⭐</span> Expertise</a></li>
      <li><a href="recognition.php"><span>🏅</span> Recognition</a></li>
    </ul>
  </nav>

  <!-- Floating Action Buttons -->
  <div class="floating-buttons">
    <button class="theme-toggle"><i class="fas fa-moon"></i></button>
    <a href="index.php" class="floating-icon"><i class="fas fa-home"></i></a>
    <button class="social-toggle"><i class="fas fa-users"></i></button>
  </div>

  <!-- Social Media Popup -->
  <div class="social-popup hidden">
    <a href="https://www.linkedin.com/in/ibrahim-denis-fofanahnah-3a38261ab/" target="_blank"><i class="fab fa-linkedin"></i></a>
    <a href="https://x.com/fofanah_denis" target="_blank"><i class="fab fa-twitter"></i></a>
    <a href="https://www.facebook.com/AIHustleWithDenis/" target="_blank"><i class="fab fa-facebook"></i></a>
    <a href="mailto:ibrahimdenisfofanah060@gmail.com"><i class="fas fa-envelope"></i></a>
  </div>
