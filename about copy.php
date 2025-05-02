<?php
require_once 'includes/db.php';

// Fetch about data
$stmt = $pdo->query("SELECT * FROM about LIMIT 1");
$about = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php include 'includes/header.php'; ?>

<!-- About Section -->
<div class="hero-card">
<section id="about" class="about-section">
  <h2 class="section-title">About Me</h2>
  <div class="section-underline"></div>

  <div class="about-container">
    <!-- Typing effect area -->
    <p id="typedText" data-text="<?= htmlspecialchars($about['summary'], ENT_QUOTES) ?>"></p>
<span class="cursor">|</span>


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
</div>





<?php include 'includes/footer.php'; ?>
