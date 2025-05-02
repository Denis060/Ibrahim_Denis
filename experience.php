<!-- experience.php -->
<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

// Fetch all experiences from the database
$stmt = $pdo->query("SELECT * FROM experience ORDER BY start_date DESC");
$experiences = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="experience-section">
  <h2 class="section-title">Professional Experience</h2>
  <div class="section-underline"></div>

  <div class="experience-cards">
    <?php foreach ($experiences as $exp): ?>
      <div class="experience-card">
        <div class="experience-header">
          <div class="logo-wrapper">
            <img src="uploads/<?= htmlspecialchars($exp['logo']) ?>" class="company-logo" alt="Logo">
          </div>

          <div class="job-info">
            <h3 class="job-title"><?= htmlspecialchars($exp['role']) ?> <span>@ <?= htmlspecialchars($exp['company']) ?></span></h3>
            <p class="job-location"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($exp['location']) ?></p>
            <p class="job-dates"><i class="fas fa-calendar-alt"></i> <?= $exp['start_date'] ?> - <?= $exp['is_current'] ? 'Present' : $exp['end_date'] ?></p>
          </div>

          <button class="toggle-description" onclick="this.closest('.experience-card').classList.toggle('expanded')">
            <i class="fas fa-chevron-down"></i>
          </button>
        </div>

        <div class="experience-description">
          <p><?= nl2br(htmlspecialchars($exp['description'])) ?></p>

          <?php if (!empty($exp['technologies'])): ?>
            <div class="technologies">
              <strong>Technologies:</strong>
              <?php foreach (explode(',', $exp['technologies']) as $tech): ?>
                <span class="tech-badge"><?= trim($tech) ?></span>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>


<?php require_once 'includes/footer.php'; ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const toggles = document.querySelectorAll('.toggle-description');

  toggles.forEach(button => {
    button.addEventListener('click', () => {
      const card = button.closest('.experience-card');

      // Collapse all other cards
      document.querySelectorAll('.experience-card.expanded').forEach(exp => {
        if (exp !== card) exp.classList.remove('expanded');
      });

      // Toggle this one
      card.classList.toggle('expanded');
    });
  });
});
</script>
