<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $organization = $_POST['organization'];
    $location = $_POST['location'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $description = $_POST['description'];
    $external_link = $_POST['external_link'];

    $stmt = $pdo->prepare("INSERT INTO recognition (title, organization, location, start_date, end_date, description, external_link)
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $organization, $location, $start_date, $end_date, $description, $external_link]);

    header("Location: manage_recognition.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Add Recognition</title></head>
<body>
<h2>Add Recognition</h2>

<form method="POST">
    Title: <input type="text" name="title" required><br><br>
    Organization: <input type="text" name="organization" required><br><br>
    Location: <input type="text" name="location"><br><br>
    Start Date: <input type="date" name="start_date"><br><br>
    End Date: <input type="date" name="end_date"><br><br>
    Description:<br><textarea name="description" rows="4" cols="50"></textarea><br><br>
    External Link (optional): <input type="text" name="external_link"><br><br>
    <button type="submit">Add Recognition</button>
</form>

<br><a href="manage_recognition.php">← Back</a>
</body>
</html>
