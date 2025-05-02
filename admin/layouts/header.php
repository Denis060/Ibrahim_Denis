<?php
require_once '../includes/auth.php'; // Always protect the page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="assets/css/admin.css">
 <!-- Use correct path -->
</head>
<body>

<header>
    <h1>Admin Dashboard</h1>
    <nav class="dashboard-links">
    <a href="manage_about.php">Manage About</a>
    <a href="manage_experience.php">Manage Experience</a>
    <a href="manage_projects.php">Manage Projects</a>
    <a href="manage_education.php">Manage Education</a>
    <a href="manage_certifications.php">Manage Certifications</a>
    <a href="manage_recognition.php">Manage Recognition</a>
    <a href="logout.php">Logout</a>
    </nav>
</header>

<main>
