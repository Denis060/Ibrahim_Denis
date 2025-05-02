<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM recognition WHERE id = ?");
$stmt->execute([$id]);
$rec = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $organization = $_POST['organization'];
    $location = $_POST['location'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $description = $_POST['description'];
    $external_link = $_POST['external_link'];

    $stmt = $pdo->prepare("UPDATE recognition SET title=?, organization=?, location=?, start_date=?, end_date=?, description=?, external_link=? WHERE id=?");
    $stmt->execute([$title, $organization, $location, $start_date, $end_date, $description, $external_link, $id]);

    header("Location: manage_recognition.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Edit Recognition</title></head>
<body>
<h2>Edit Recognition</h2>

<form method="POST">
    Title: <input type="text" name="title" value="<?= htmlspecialchars($rec['title']) ?>" required><br><br>
    Organization: <input type="text" name="organization" value="<?= htmlspecialchars($rec['organization']) ?>" required><br><br>
    Location: <input type="text" name="location" value="<?= htmlspecialchars($rec['location']) ?>"><br><br>
    Start Date: <input type="date" name="start_date" value="<?= $rec['start_date'] ?>"><br><br>
    End Date: <input type="date" name="end_date" value="<?= $rec['end_date'] ?>"><br><br>
    Description:<br><textarea name="description" rows="4" cols="50"><?= htmlspecialchars($rec['description']) ?></textarea><br><br>
    External Link: <input type="text" name="external_link" value="<?= htmlspecialchars($rec['external_link']) ?>"><br><br>
    <button type="submit">Update Recognition</button>
</form>

<br><a href="manage_recognition.php">← Back</a>
</body>
</html>
