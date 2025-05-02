<?php
require_once 'includes/auth.php'; // Ensure only authenticated admins can access
require_once 'includes/db.php';   // Include database connection

// Handle deletion of a project
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: manage_projects.php");
    exit;
}

// Fetch all projects from the database
$stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
$projects = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Projects</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 8px 12px; border: 1px solid #ccc; }
        th { background-color: #f2f2f2; }
        a { text-decoration: none; color: #0066cc; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<h2>📁 Project Showcase</h2>

<!-- Add New Project Link -->
<p><a href="add_project.php">+ Add New Project</a></p>

<!-- Projects Table -->
<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Type</th>
            <th>Status</th>
            <th>Tags</th>
            <th>Tech Stack</th>
            <th>Impact</th>
            <th>Preview Link</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if (count($projects) > 0): ?>
        <?php foreach ($projects as $proj): ?>
        <tr>
            <td><?= htmlspecialchars($proj['title']) ?></td>
            <td><?= htmlspecialchars($proj['type']) ?></td>
            <td><?= htmlspecialchars($proj['status']) ?></td>
            <td><?= htmlspecialchars($proj['tags']) ?></td>
            <td><?= htmlspecialchars($proj['tech_stack']) ?></td>
            <td><?= htmlspecialchars($proj['impact']) ?></td>
            <td>
                <?php if (!empty($proj['preview_link'])): ?>
                    <a href="<?= htmlspecialchars($proj['preview_link']) ?>" target="_blank">Preview</a>
                <?php else: ?>
                    N/A
                <?php endif; ?>
            </td>
            <td>
                <a href="edit_project.php?id=<?= $proj['id'] ?>">Edit</a> |
                <a href="?delete=<?= $proj['id'] ?>" onclick="return confirm('Are you sure you want to delete this project?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="8">No projects added yet.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

<br>
<a href="dashboard.php">← Back to Dashboard</a>

</body>
</html>
