// education.js

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function () {
  // Select all expand buttons
  const expandButtons = document.querySelectorAll('.expand-btn');

  expandButtons.forEach(button => {
    button.addEventListener('click', function () {
      const card = this.closest('.education-card');

      // Toggle the expanded class
      card.classList.toggle('expanded');

      // Optional: toggle icon direction (up/down)
      const icon = this.querySelector('i');
      if (icon.classList.contains('fa-chevron-down')) {
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
      } else {
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
      }
    });
  });
});
