<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';

// Handle deletion logic
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM experience WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: manage_experience.php");
    exit;
}

// Fetch all experiences
$stmt = $pdo->query("SELECT * FROM experience ORDER BY start_date DESC");
$experiences = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Experience</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<h2>Professional Experience</h2>

<a href="add_experience.php">+ Add New Experience</a><br><br>

<table border="1" cellpadding="10">
<tr>
    <th>Company</th>
    <th>Position</th>
    <th>Location</th>
    <th>Start</th>
    <th>End</th>
    <th>Description</th>
    <th>Actions</th>
</tr>


    <?php foreach ($experiences as $exp): ?>
        <tr>
    <td><?= htmlspecialchars($exp['company']) ?></td>
    <td><?= htmlspecialchars($exp['role']) ?></td>
    <td><?= htmlspecialchars($exp['location']) ?></td>
    <td><?= htmlspecialchars($exp['start_date']) ?></td>
    <td><?= $exp['is_current'] ? 'Present' : htmlspecialchars($exp['end_date']) ?></td>
    <td><?= nl2br(htmlspecialchars($exp['description'])) ?></td>
    <td>
        <a href="edit_experience.php?id=<?= $exp['id'] ?>">Edit</a> |
        <a href="manage_experience.php?delete=<?= $exp['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
    </td>
</tr>

    <?php endforeach; ?>
</table>

<br>
<a href="dashboard.php">← Back to Dashboard</a>

</body>
</html>
