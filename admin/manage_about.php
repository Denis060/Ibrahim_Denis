<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

// Fetch the current About details (assuming only one row with ID = 1)
$stmt = $pdo->prepare("SELECT * FROM about WHERE id = 1");
$stmt->execute();
$about = $stmt->fetch(PDO::FETCH_ASSOC);

// Redirect if no about record is found
if (!$about) {
    die("About content not found in the database.");
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $title = $_POST['title'];
    $summary = $_POST['summary'];

    $profile_picture = $about['profile_picture']; // default to existing image
    if (!empty($_FILES['profile_picture']['name'])) {
        $filename = time() . '_' . $_FILES['profile_picture']['name'];
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], '../uploads/' . $filename);
        $profile_picture = $filename;
    }

    $stmt = $pdo->prepare("UPDATE about SET name=?, title=?, summary=?, profile_picture=? WHERE id=1");
    $stmt->execute([$name, $title, $summary, $profile_picture]);

    header("Location: manage_about.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage About</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<h2>Manage About Section</h2>

<form method="post" enctype="multipart/form-data">
    <label>Name:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($about['name']) ?>" required><br><br>

    <label>Title:</label><br>
    <input type="text" name="title" value="<?= htmlspecialchars($about['title']) ?>" required><br><br>

    <label>Summary:</label><br>
    <textarea name="summary" rows="6" cols="60" required><?= htmlspecialchars($about['summary']) ?></textarea><br><br>

    <label>Profile Picture:</label><br>
    <input type="file" name="profile_picture"><br>
    <?php if ($about['profile_picture']): ?>
        <img src="../uploads/<?= $about['profile_picture'] ?>" width="120" alt="Profile Picture"><br>
    <?php endif; ?>
    <br>
    <button type="submit">Update About</button>
</form>

<br>
<a href="dashboard.php">&larr; Back to Dashboard</a>
<?php include '../includes/footer.php'; ?>
</body>
</html>
