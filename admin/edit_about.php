<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';

// Load current data
$stmt = $pdo->query("SELECT * FROM about WHERE id = 1");
$about = $stmt->fetch();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $title = $_POST['title'];
    $summary = $_POST['summary'];
    
    $profile_picture = $about['profile_picture'];
    
    // Handle image upload
    if (!empty($_FILES['profile_picture']['name'])) {
        $target_dir = "../uploads/";
        $filename = uniqid() . "_" . basename($_FILES["profile_picture"]["name"]);
        $target_file = $target_dir . $filename;

        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $profile_picture = $filename;
        }
    }

    // Update DB
    $stmt = $pdo->prepare("UPDATE about SET name=?, title=?, summary=?, profile_picture=? WHERE id=1");
    $stmt->execute([$name, $title, $summary, $profile_picture]);

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Edit About</title></head>
<body>
<h2>Edit About Section</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Name:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($about['name']) ?>"><br><br>

    <label>Title:</label><br>
    <input type="text" name="title" value="<?= htmlspecialchars($about['title']) ?>"><br><br>

    <label>Summary:</label><br>
    <textarea name="summary" rows="5" cols="50"><?= htmlspecialchars($about['summary']) ?></textarea><br><br>

    <label>Profile Picture:</label><br>
    <?php if ($about['profile_picture']): ?>
        <img src="../uploads/<?= $about['profile_picture'] ?>" width="120"><br>
    <?php endif; ?>
    <input type="file" name="profile_picture"><br><br>

    <button type="submit">Update</button>
</form>

<a href="dashboard.php">← Back to Dashboard</a>
</body>
</html>
