<>
<?php
require_once 'includes/db.php';

// Fetch about data from DB
$stmt = $pdo->query("SELECT * FROM about LIMIT 1");
$about = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php include 'includes/header.php'; ?>
<main>
    <!-- Hero Section Starts -->
<section class="hero-section">
  <div class="hero-card fade-in">
    
    <!-- Profile Image -->
    <img class="profile-img" src="uploads/<?= htmlspecialchars($about['profile_picture']) ?>" alt="<?= htmlspecialchars($about['name']) ?>">

    <!-- Name -->
    <h1 class="hero-name"><?= htmlspecialchars($about['name']) ?></h1>

    <!-- Role -->
    <h2 class="hero-role"><?= htmlspecialchars($about['title']) ?></h2>

    <!-- Summary (Typing Effect Optional) -->
    <p class="hero-description" id="typedSummary" data-text="<?= htmlspecialchars($about['summary'], ENT_QUOTES) ?>"></p>

  </div>
</section>
<!-- Hero Section Ends -->
</main>


<?php include 'includes/footer.php'; ?>
</body>