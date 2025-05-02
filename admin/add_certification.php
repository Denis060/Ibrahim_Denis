<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $issuer = $_POST['issuer'];
    $issue_date = $_POST['issue_date'];
    $skills = $_POST['skills'];
    $credential_url = $_POST['credential_url'];
    $details = $_POST['details'];

    $certificate_img = '';
    if (!empty($_FILES['certificate_img']['name'])) {
        $certificate_img = time() . '_' . $_FILES['certificate_img']['name'];
        move_uploaded_file($_FILES['certificate_img']['tmp_name'], '../uploads/' . $certificate_img);
    }

    $stmt = $pdo->prepare("INSERT INTO certifications (title, issuer, issue_date, skills, credential_url, details, certificate_img) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $issuer, $issue_date, $skills, $credential_url, $details, $certificate_img]);

    header("Location: manage_certifications.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Add Certification</title></head>
<body>
<h2>Add New Certification</h2>
<form method="POST" enctype="multipart/form-data">
    Title: <input type="text" name="title" required><br><br>
    Issuer: <input type="text" name="issuer" required><br><br>
    Issue Date: <input type="date" name="issue_date"><br><br>
    Skills (comma-separated): <input type="text" name="skills"><br><br>
    Credential URL: <input type="text" name="credential_url"><br><br>
    Details:<br><textarea name="details" rows="4" cols="50"></textarea><br><br>
    Certificate Image: <input type="file" name="certificate_img"><br><br>
    <button type="submit">Add Certification</button>
</form>

<br>
<a href="manage_certifications.php">&larr; Back to Certification List</a>
</body>
</html>
