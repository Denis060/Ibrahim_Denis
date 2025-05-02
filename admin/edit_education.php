<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';

// Get education ID
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: manage_education.php");
    exit;
}

// Fetch existing education record
$stmt = $pdo->prepare("SELECT * FROM education WHERE id = ?");
$stmt->execute([$id]);
$edu = $stmt->fetch();

if (!$edu) {
    header("Location: manage_education.php");
    exit;
}

// Handle form submission for update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $institution = $_POST['institution'];
    $degree = $_POST['degree'];
    $field = $_POST['field'];
    $start_year = $_POST['start_year'];
    $end_year = $_POST['end_year'];
    $location = $_POST['location'];
    $details = $_POST['details'];

    $logo = $edu['logo']; // Keep old logo by default

    if (!empty($_FILES['logo']['name'])) {
        $logo = time() . '_' . basename($_FILES['logo']['name']);
        move_uploaded_file($_FILES['logo']['tmp_name'], '../uploads/' . $logo);
    }

    $stmt = $pdo->prepare("UPDATE education SET institution = ?, degree = ?, field = ?, start_year = ?, end_year = ?, location = ?, details = ?, logo = ? WHERE id = ?");
    $stmt->execute([$institution, $degree, $field, $start_year, $end_year, $location, $details, $logo, $id]);

    header("Location: manage_education.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Edit Education</title></head>
<body>
<h2>Edit Education</h2>

<form method="post" enctype="multipart/form-data">
    Institution: <input type="text" name="institution" value="<?= htmlspecialchars($edu['institution']) ?>" required><br><br>
    Degree: <input type="text" name="degree" value="<?= htmlspecialchars($edu['degree']) ?>" required><br><br>
    Field of Study: <input type="text" name="field" value="<?= htmlspecialchars($edu['field']) ?>"><br><br>
    Start Year: <input type="number" name="start_year" value="<?= htmlspecialchars($edu['start_year']) ?>" required><br><br>
    End Year: <input type="number" name="end_year" value="<?= htmlspecialchars($edu['end_year']) ?>"><br><br>
    Location: <input type="text" name="location" value="<?= htmlspecialchars($edu['location']) ?>"><br><br>
    Details:<br>
    <textarea name="details" rows="5" cols="50"><?= htmlspecialchars($edu['details']) ?></textarea><br><br>
    Institution Logo: <input type="file" name="logo"><br>
    <?php if ($edu['logo']): ?>
        <img src="../uploads/<?= $edu['logo'] ?>" width="100"><br>
    <?php endif; ?>
    <br>
    <button type="submit">Update Education</button>
</form>

<br><a href="manage_education.php">&larr; Back to Education List</a>
</body>
</html>
