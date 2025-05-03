<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

// Fetch public recognitions
$stmt = $pdo->prepare("SELECT * FROM recognition WHERE visibility = 'public' ORDER BY start_date DESC");
$stmt->execute();
$recognitions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="recognition-section">
  <h2 class="section-title">🎖️ Recognition</h2>
  <div class="section-underline"></div>
    <p class="section-description">Here are some of the recognitions I've received over the years.</p>
  <!-- Search Bar -->
  <div class="recognition-search">
    <input type="text" id="recognitionSearchInput" placeholder="🔍 Search recognitions by title, org, or type...">
  </div>
  
  <div class="recognition-cards">
    <?php foreach ($recognitions as $rec): ?>
      <div class="recognition-card">
        <!-- Header -->
        <div class="recognition-header">
          <!-- Badge Icon -->
          <div class="badge-icon">
            <?php if (!empty($rec['badge_icon'])): ?>
              <img src="<?= htmlspecialchars($rec['badge_icon']) ?>" alt="Badge Icon">
            <?php else: ?>
              <i class="fas fa-award"></i>
            <?php endif; ?>
          </div>

          <!-- Recognition Info -->
          <div class="recognition-info">
            <h3 class="recognition-title"><?= htmlspecialchars($rec['title']) ?></h3>
            <p class="recognition-org">
              <?= htmlspecialchars($rec['organization']) ?>
              <?php if (!empty($rec['location'])): ?>
                - <?= htmlspecialchars($rec['location']) ?>
              <?php endif; ?>
            </p>
            <p class="recognition-dates">
              <?= date('F Y', strtotime($rec['start_date'])) ?>
              <?php if (!empty($rec['end_date'])): ?>
                &ndash; <?= date('F Y', strtotime($rec['end_date'])) ?>
              <?php endif; ?>
            </p>
          </div>

          <!-- Expand Button -->
          <button class="expand-btn" title="Expand"><i class="fas fa-chevron-down"></i></button>
        </div>

        <!-- Expandable Section -->
        <div class="recognition-expanded">
          <?php if (!empty($rec['type'])): ?>
            <p class="recognition-type"><strong>Type:</strong> <?= htmlspecialchars($rec['type']) ?></p>
          <?php endif; ?>

          <?php if (!empty($rec['description'])): ?>
            <p class="recognition-description"><?= nl2br(htmlspecialchars($rec['description'])) ?></p>
          <?php endif; ?>

          <?php if (!empty($rec['external_link'])): ?>
            <a href="<?= htmlspecialchars($rec['external_link']) ?>" class="recognition-link" target="_blank">
              <i class="fas fa-external-link-alt"></i> Learn More
            </a>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>

<!-- Page-specific CSS and JS -->
<link rel="stylesheet" href="assets/css/recognition.css">
<script defer src="assets/js/recognition.js"></script>
