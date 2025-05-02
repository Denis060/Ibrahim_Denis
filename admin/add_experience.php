<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize form inputs
    $company = $_POST['company'] ?? '';
    $role = $_POST['role'] ?? '';
    $location = $_POST['location'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    $is_current = isset($_POST['is_current']) ? 1 : 0;
    $description = $_POST['description'] ?? '';
    $technologies = $_POST['technologies'] ?? '';
    $logo = '';

// Handle file upload
if (!empty($_FILES['logo']['name'])) {
    $logo = time() . '_' . basename($_FILES['logo']['name']);
    move_uploaded_file($_FILES['logo']['tmp_name'], '../uploads/' . $logo);
}

// Insert into DB
$stmt = $pdo->prepare("INSERT INTO experience (company, role, location, start_date, end_date, is_current, description, logo, technologies) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$company, $role, $location, $start_date, $end_date, $is_current, $description, $logo, $technologies]);

header('Location: manage_experience.php');
exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Add Experience</title></head>
<body>
<h2>Add New Experience</h2>
<form method="post" enctype="multipart/form-data">
    Company: <input type="text" name="company" required><br><br>
    Role: <input type="text" name="role" required><br><br>
    Location: <input type="text" name="location"><br><br>
    Start Date: <input type="date" name="start_date" required><br><br>
    End Date: <input type="date" name="end_date"><br><br>
    Currently Working Here: 
    <input type="checkbox" name="is_current" value="1"><br><br>
    Technologies Used: <input type="text" name="technologies"><br><br>
    Description:<br>
    <textarea name="description" rows="5" cols="50"></textarea><br><br>
    Logo: <input type="file" name="logo"><br><br>
    <button type="submit">Add Experience</button>
</form>


<br>
<a href="manage_experience.php">← Back</a>
</body>
</html>
