<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';

// Handle deletion if requested
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM certifications WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: manage_certifications.php");
    exit;
}

// Fetch all certifications ordered by date
$stmt = $pdo->query("SELECT * FROM certifications ORDER BY issue_date DESC");
$certs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Certifications</title>
</head>
<body>
<h2>Certification Records</h2>
<a href="add_certification.php">+ Add New Certification</a><br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>Title</th>
        <th>Issuer</th>
        <th>Issue Date</th>
        <th>Skills</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($certs as $cert): ?>
        <tr>
            <td><?= htmlspecialchars($cert['title']) ?></td>
            <td><?= htmlspecialchars($cert['issuer']) ?></td>
            <td><?= htmlspecialchars($cert['issue_date']) ?></td>
            <td><?= htmlspecialchars($cert['skills']) ?></td>
            <td>
                <a href="edit_certification.php?id=<?= $cert['id'] ?>">Edit</a> |
                <a href="?delete=<?= $cert['id'] ?>" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<br>
<a href="dashboard.php">&larr; Back to Dashboard</a>
</body>
</html>
