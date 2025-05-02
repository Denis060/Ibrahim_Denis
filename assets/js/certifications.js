// assets/js/certifications.js

document.addEventListener('DOMContentLoaded', () => {
  const expandBtns = document.querySelectorAll('.expand-btn');

  expandBtns.forEach(button => {
    button.addEventListener('click', () => {
      const card = button.closest('.cert-card');
      card.classList.toggle('expanded');

      const icon = button.querySelector('i');
      icon.classList.toggle('fa-chevron-down');
      icon.classList.toggle('fa-chevron-up');
    });
  });
});
