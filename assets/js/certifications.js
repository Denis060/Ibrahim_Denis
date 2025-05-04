// certifications.js

document.addEventListener("DOMContentLoaded", function () {
  const expandButtons = document.querySelectorAll(".expand-btn");

  expandButtons.forEach(button => {
    button.addEventListener("click", function () {
      const card = this.closest(".cert-card");
      const expandedSection = card.querySelector(".cert-expanded");

      // Toggle expanded class
      card.classList.toggle("expanded");
      expandedSection.classList.toggle("open");

      // Swap chevron icon
      const icon = this.querySelector("i");
      icon.classList.toggle("fa-chevron-down");
      icon.classList.toggle("fa-chevron-up");
    });
  });
});
