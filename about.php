<!-- about.php -->
<?php
require_once 'includes/db.php';         // Database connection
require_once 'includes/header.php';     // Top layout & navbar

// Fetch profile info from the 'about' table
$stmt = $pdo->query("SELECT * FROM about LIMIT 1");
$about = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!-- ========== About Section Starts ========== -->
<section class="about-section">
  <h2 class="section-title">About Me</h2>
  <div class="section-underline"></div>

  <div class="about-card">
    <!-- Optional Role or Title Heading -->
    <h3 class="hero-role"><?= htmlspecialchars($about['title']) ?></h3>

    <!-- Typing Text: ONLY JS populates this (no initial static text) -->
    <p id="typedSummary" class="about-summary typed-text"
       data-text="<?= htmlspecialchars($about['summary']) ?>"></p>

    <!-- Research Interests -->
    <div class="research-interests">
      <h3>Research Interests</h3>
      <div class="badges">
        <span class="badge"><i class="fas fa-brain"></i> Artificial Intelligence</span>
        <span class="badge"><i class="fas fa-robot"></i> Machine Learning</span>
        <span class="badge"><i class="fas fa-dna"></i> Cognitive Science</span>
      </div>
    </div>
  </div>
</section>
<!-- ========== About Section Ends ========== -->

<?php require_once 'includes/footer.php'; ?>

<!-- Load page-specific CSS & JS at the bottom -->
<link rel="stylesheet" href="assets/css/about.css">
<script defer src="assets/js/about.js"></script>
