<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';

// Get the ID of the experience to edit from the URL
$id = $_GET['id'] ?? null;

// Fetch that experience entry from the database
$stmt = $pdo->prepare("SELECT * FROM experience WHERE id = ?");
$stmt->execute([$id]);
$exp = $stmt->fetch();

// If no experience is found, redirect back to manage page
if (!$exp) {
    header("Location: manage_experience.php");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get updated values from form
    $company = $_POST['company'];
    $role = $_POST['role'];
    $location = $_POST['location'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $is_current = isset($_POST['is_current']) ? 1 : 0;
    $description = $_POST['description'];
    $technologies = $_POST['technologies'];
    $logo = $exp['logo']; // Use existing logo unless a new one is uploaded

    // Handle file upload for logo (optional)
    if (!empty($_FILES['logo']['name'])) {
        $filename = time() . '_' . $_FILES['logo']['name'];
        move_uploaded_file($_FILES['logo']['tmp_name'], '../uploads/' . $filename);
        $logo = $filename;
    }

    // Update the experience in the database
    $stmt = $pdo->prepare("UPDATE experience 
        SET company=?, role=?, location=?, start_date=?, end_date=?, is_current=?, description=?, logo=?, technologies=? 
        WHERE id=?");
    $stmt->execute([$company, $role, $location, $start_date, $end_date, $is_current, $description, $logo, $technologies, $id]);

    // Redirect after update
    header("Location: manage_experience.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Experience</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<h2>Edit Experience</h2>

<form method="post" enctype="multipart/form-data">
    Company: <input type="text" name="company" value="<?= htmlspecialchars($exp['company']) ?>" required><br><br>
    Role: <input type="text" name="role" value="<?= htmlspecialchars($exp['role']) ?>" required><br><br>
    Location: <input type="text" name="location" value="<?= htmlspecialchars($exp['location']) ?>"><br><br>
    Start Date: <input type="date" name="start_date" value="<?= $exp['start_date'] ?>" required><br><br>
    End Date: <input type="date" name="end_date" value="<?= $exp['end_date'] ?>"><br><br>
    Currently Working Here:
    <input type="checkbox" name="is_current" value="1" <?= $exp['is_current'] ? 'checked' : '' ?>><br><br>
    Technologies Used: <input type="text" name="technologies" value="<?= htmlspecialchars($exp['technologies']) ?>"><br><br>
    Description:<br>
    <textarea name="description" rows="5" cols="50"><?= htmlspecialchars($exp['description']) ?></textarea><br><br>

    Logo: <input type="file" name="logo"><br>
    <?php if ($exp['logo']): ?>
        <img src="../uploads/<?= $exp['logo'] ?>" width="100"><br>
    <?php endif; ?>
    <br>
    <button type="submit">Update Experience</button>
</form>

<br>
<a href="manage_experience.php">← Back</a>

</body>
</html>
