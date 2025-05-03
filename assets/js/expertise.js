document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("expertiseSearchInput");
  
    // Live search filter
    if (searchInput) {
      searchInput.addEventListener("input", function () {
        const query = this.value.toLowerCase();
        const cards = document.querySelectorAll(".expertise-card");
  
        cards.forEach(card => {
          const title = card.querySelector(".expertise-title")?.textContent.toLowerCase() || "";
          const summary = card.querySelector(".expertise-summary")?.textContent.toLowerCase() || "";
          const match = title.includes(query) || summary.includes(query);
          card.style.display = match ? "block" : "none";
        });
      });
    }
  
    // Expand/collapse toggle
    const buttons = document.querySelectorAll(".expand-btn");
    buttons.forEach(button => {
      button.addEventListener("click", function () {
        const card = this.closest(".expertise-card");
        const expanded = card.querySelector(".expertise-expanded");
        expanded.classList.toggle("open");
  
        const icon = this.querySelector("i");
        icon.classList.toggle("fa-chevron-down");
        icon.classList.toggle("fa-chevron-up");
      });
    });
  });
  