<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';

// Get the ID of the certification to edit
$id = $_GET['id'] ?? null;

// Fetch that certification entry from the database
$stmt = $pdo->prepare("SELECT * FROM certifications WHERE id = ?");
$stmt->execute([$id]);
$cert = $stmt->fetch();

// If no certification is found, redirect back to manage page
if (!$cert) {
    header("Location: manage_certifications.php");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get updated values from form
    $title = $_POST['title'];
    $issuer = $_POST['issuer'];
    $issue_date = $_POST['issue_date'];
    $skills = $_POST['skills'];
    $credential_url = $_POST['credential_url'];
    $details = $_POST['details'];
    $certificate_img = $cert['certificate_img']; // Keep old image by default

    // Handle file upload for new certificate image (optional)
    if (!empty($_FILES['certificate_img']['name'])) {
        $filename = time() . '_' . $_FILES['certificate_img']['name'];
        move_uploaded_file($_FILES['certificate_img']['tmp_name'], '../uploads/' . $filename);
        $certificate_img = $filename;
    }

    // Update the certification in the database
    $stmt = $pdo->prepare("UPDATE certifications 
        SET title = ?, issuer = ?, issue_date = ?, skills = ?, credential_url = ?, details = ?, certificate_img = ?
        WHERE id = ?");
    $stmt->execute([$title, $issuer, $issue_date, $skills, $credential_url, $details, $certificate_img, $id]);

    header("Location: manage_certifications.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Edit Certification</title></head>
<body>

<h2>Edit Certification</h2>

<form method="post" enctype="multipart/form-data">
    Title: <input type="text" name="title" value="<?= htmlspecialchars($cert['title']) ?>" required><br><br>
    Issuer: <input type="text" name="issuer" value="<?= htmlspecialchars($cert['issuer']) ?>" required><br><br>
    Issue Date: <input type="date" name="issue_date" value="<?= $cert['issue_date'] ?>"><br><br>
    Skills (comma-separated): <input type="text" name="skills" value="<?= htmlspecialchars($cert['skills']) ?>"><br><br>
    Credential URL: <input type="text" name="credential_url" value="<?= htmlspecialchars($cert['credential_url']) ?>"><br><br>
    Details:<br>
    <textarea name="details" rows="5" cols="50"><?= htmlspecialchars($cert['details']) ?></textarea><br><br>

    Certificate Image: <input type="file" name="certificate_img"><br>
    <?php if ($cert['certificate_img']): ?>
        <img src="../uploads/<?= $cert['certificate_img'] ?>" width="120" alt="Certificate Image"><br>
    <?php endif; ?>
    <br>
    <button type="submit">Update Certification</button>
</form>

<br>
<a href="manage_certifications.php">← Back to Certifications</a>

</body>
</html>
