<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';

// Get project ID from URL
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: manage_projects.php");
    exit;
}

// Fetch project from the database
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch();

if (!$project) {
    header("Location: manage_projects.php");
    exit;
}

// Handle update submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $type = $_POST['type'];
    $status = $_POST['status'];
    $overview = $_POST['overview'];
    $tags = $_POST['tags'];
    $impact = $_POST['impact'];
    $tech_stack = $_POST['tech_stack'];
    $preview_link = $_POST['preview_link'];

    $stmt = $pdo->prepare("UPDATE projects SET title = ?, type = ?, status = ?, overview = ?, tags = ?, impact = ?, tech_stack = ?, preview_link = ? WHERE id = ?");
    $stmt->execute([$title, $type, $status, $overview, $tags, $impact, $tech_stack, $preview_link, $id]);

    header("Location: manage_projects.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Project</title>
</head>
<body>
<h2>Edit Project</h2>
<form method="post">
    Title: <input type="text" name="title" value="<?= htmlspecialchars($project['title']) ?>" required><br><br>
    Type: <input type="text" name="type" value="<?= htmlspecialchars($project['type']) ?>" required><br><br>
    Status: <input type="text" name="status" value="<?= htmlspecialchars($project['status']) ?>" required><br><br>
    Overview:<br>
    <textarea name="overview" rows="5" cols="60" required><?= htmlspecialchars($project['overview']) ?></textarea><br><br>
    Tags (comma-separated): <input type="text" name="tags" value="<?= htmlspecialchars($project['tags']) ?>"><br><br>
    Impact:<br>
    <textarea name="impact" rows="4" cols="60"><?= htmlspecialchars($project['impact']) ?></textarea><br><br>
    Tech Stack: <input type="text" name="tech_stack" value="<?= htmlspecialchars($project['tech_stack']) ?>"><br><br>
    Preview Link: <input type="url" name="preview_link" value="<?= htmlspecialchars($project['preview_link']) ?>"><br><br>
    <button type="submit">Update Project</button>
</form>
<br>
<a href="manage_projects.php">← Back</a>
</body>
</html>
