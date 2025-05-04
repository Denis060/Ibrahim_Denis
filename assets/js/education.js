// education.js
document.addEventListener('DOMContentLoaded', () => {
  const expandButtons = document.querySelectorAll('.expand-btn');

  expandButtons.forEach(button => {
    button.addEventListener('click', () => {
      const card = button.closest('.education-card');
      card.classList.toggle('expanded');

      const icon = button.querySelector('i');
      icon.classList.toggle('fa-chevron-down');
      icon.classList.toggle('fa-chevron-up');
    });
  });
});
