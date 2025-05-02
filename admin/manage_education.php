<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';

// Handle deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM education WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: manage_education.php");
    exit;
}

// Fetch all education entries
$stmt = $pdo->query("SELECT * FROM education ORDER BY start_year DESC");
$educations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Education</title>
</head>
<body>
<h2>Educational Background</h2>

<a href="add_education.php">+ Add New Education</a><br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>Institution</th>
        <th>Degree</th>
        <th>Field</th>
        <th>Start</th>
        <th>End</th>
        <th>Location</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($educations as $edu): ?>
    <tr>
        <td><?= htmlspecialchars($edu['institution']) ?></td>
        <td><?= htmlspecialchars($edu['degree']) ?></td>
        <td><?= htmlspecialchars($edu['field']) ?></td>
        <td><?= htmlspecialchars($edu['start_year']) ?></td>
        <td><?= htmlspecialchars($edu['end_year']) ?></td>
        <td><?= htmlspecialchars($edu['location']) ?></td>
        <td>
            <a href="edit_education.php?id=<?= $edu['id'] ?>">Edit</a> |
            <a href="manage_education.php?delete=<?= $edu['id'] ?>" onclick="return confirm('Delete this record?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<br>
<a href="dashboard.php">&larr; Back to Dashboard</a>
</body>
</html>
