<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM recognition WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: manage_recognition.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM recognition ORDER BY start_date DESC");
$recognitions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head><title>Manage Recognition</title></head>
<body>
<h2>Recognition & Outreach</h2>

<a href="add_recognition.php">+ Add New Recognition</a><br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>Title</th>
        <th>Organization</th>
        <th>Start</th>
        <th>End</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($recognitions as $rec): ?>
    <tr>
        <td><?= htmlspecialchars($rec['title']) ?></td>
        <td><?= htmlspecialchars($rec['organization']) ?></td>
        <td><?= $rec['start_date'] ?></td>
        <td><?= $rec['end_date'] ?></td>
        <td>
            <a href="edit_recognition.php?id=<?= $rec['id'] ?>">Edit</a> |
            <a href="?delete=<?= $rec['id'] ?>" onclick="return confirm('Delete this entry?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<br><a href="dashboard.php">← Back to Dashboard</a>
</body>
</html>
