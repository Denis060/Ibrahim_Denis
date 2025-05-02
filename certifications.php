<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

// Fetch certifications from DB
$stmt = $pdo->query("SELECT * FROM certifications ORDER BY issue_date DESC");
$certifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="cert-section">
  <h2 class="section-title">Certifications</h2>
  <div class="section-underline"></div>

  <div class="cert-cards">
    <?php foreach ($certifications as $cert): ?>
      <div class="cert-card">
        <!-- Card Header -->
        <div class="cert-header">
          <!-- Icon -->
          <div class="cert-logo">
            <i class="fas fa-graduation-cap"></i>
          </div>

          <!-- Info -->
          <div class="cert-info">
            <h3 class="cert-title"><?= htmlspecialchars($cert['title']) ?></h3>
            <p class="cert-issuer"><?= htmlspecialchars($cert['issuer']) ?></p>

            <div class="cert-meta">
              <span><i class="fas fa-calendar-alt"></i> <?= date('F Y', strtotime($cert['issue_date'])) ?></span>
              <?php if (!empty($cert['skills'])): ?>
  <div class="cert-skills">
    <?php foreach (explode(',', $cert['skills']) as $skill): ?>
      <span class="skill-badge"><?= htmlspecialchars(trim($skill)) ?></span>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

            </div>
          </div>

          <!-- Expand Button -->
          <button class="expand-btn" aria-label="Toggle More Info">
            <i class="fas fa-chevron-down"></i>
          </button>
        </div>

        <!-- Expandable Body -->
        <div class="cert-expanded">
          <?php if (!empty($cert['details'])): ?>
            <p class="cert-details"><?= nl2br(htmlspecialchars($cert['details'])) ?></p>
          <?php endif; ?>

          <?php if (!empty($cert['credential_url'])): ?>
            <a href="<?= htmlspecialchars($cert['credential_url']) ?>" target="_blank" class="cert-link">
              <i class="fas fa-external-link-alt"></i> View Credential
            </a>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>

<!-- CSS + JS -->
<link rel="stylesheet" href="assets/css/certifications.css">
<script defer src="assets/js/certifications.js"></script>
