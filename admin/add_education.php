<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $institution = $_POST['institution'];
    $degree = $_POST['degree'];
    $field = $_POST['field'];
    $start_year = $_POST['start_year'];
    $end_year = $_POST['end_year'];
    $location = $_POST['location'];
    $details = $_POST['details'];

    // Handle image upload
    $logo = null;
    if (!empty($_FILES['logo']['name'])) {
        $targetDir = "uploads/";
        $logo = time() . '_' . basename($_FILES['logo']['name']);
        $targetFile = $targetDir . $logo;
        move_uploaded_file($_FILES['logo']['tmp_name'], $targetFile);
    }

    $stmt = $pdo->prepare("INSERT INTO education (institution, degree, field, start_year, end_year, location, details, logo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$institution, $degree, $field, $start_year, $end_year, $location, $details, $logo]);

    header("Location: manage_education.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Add Education</title></head>
<body>
<h2>Add New Education</h2>

<form method="post" enctype="multipart/form-data">
    Institution: <input type="text" name="institution" required><br><br>
    Degree: <input type="text" name="degree" required><br><br>
    Field of Study: <input type="text" name="field"><br><br>
    Start Year: <input type="number" name="start_year" required><br><br>
    End Year: <input type="number" name="end_year"><br><br>
    Location: <input type="text" name="location"><br><br>
    Details:<br>
    <textarea name="details" rows="5" cols="50"></textarea><br><br>
    Institution Logo: <input type="file" name="logo"><br><br>

    <button type="submit">Add Education</button>
</form>

<br><a href="manage_education.php">&larr; Back to Education List</a>
</body>
</html>
