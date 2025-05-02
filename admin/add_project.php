<?php
// Ensure admin is logged in
require_once 'includes/auth.php';
// Include DB connection
require_once 'includes/db.php';

// Initialize message
$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $title = $_POST['title'];
    $type = $_POST['type'];
    $status = $_POST['status'];
    $overview = $_POST['overview'];
    $tags = $_POST['tags'];
    $impact = $_POST['impact'];
    $tech_stack = $_POST['tech_stack'];
    $preview_link = $_POST['preview_link'];
    $created_at = date('Y-m-d H:i:s'); // Current timestamp

    // Prepare insert query using PDO
    $stmt = $pdo->prepare("INSERT INTO projects 
        (title, type, status, overview, tags, impact, tech_stack, preview_link, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Execute the statement with form values
    if ($stmt->execute([$title, $type, $status, $overview, $tags, $impact, $tech_stack, $preview_link, $created_at])) {
        $message = "✅ Project added successfully!";
    } else {
        $message = "❌ Failed to add project.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Project</title>
</head>
<body>
    <h2>Add New Project</h2>

    <?php if ($message): ?>
        <p><strong><?= $message ?></strong></p>
    <?php endif; ?>

    <!-- Project Submission Form -->
    <form method="post">
        Title: <input type="text" name="title" required><br><br>
        Type: <input type="text" name="type" required><br><br>
        Status: 
        <select name="status" required>
            <option value="In Progress">In Progress</option>
            <option value="Completed">Completed</option>
        </select><br><br>
        Overview:<br>
        <textarea name="overview" rows="5" cols="60" required></textarea><br><br>
        Tags (comma-separated): <input type="text" name="tags"><br><br>
        Impact:<br>
        <textarea name="impact" rows="4" cols="60"></textarea><br><br>
        Tech Stack: <input type="text" name="tech_stack"><br><br>
        Preview Link: <input type="url" name="preview_link"><br><br>

        <button type="submit">Add Project</button>
    </form>

    <br>
    <a href="manage_projects.php">← Back to Project List</a>
</body>
</html>
