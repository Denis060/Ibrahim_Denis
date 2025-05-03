// Wait for the DOM to fully load
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("projectSearchInput");
  
    // 🔍 Filter projects by search input (title or tags)
    if (searchInput) {
      searchInput.addEventListener("input", function () {
        const searchText = this.value.trim().toLowerCase();
        const projectCards = document.querySelectorAll(".project-card");
  
        projectCards.forEach(card => {
          // Get values from data attributes
          const title = card.dataset.title || "";
          const tags = card.dataset.tags || "";
          const category = card.dataset.category || "";
  
          // Match if search string is found in title, tags or category
          const isMatch = title.includes(searchText) || tags.includes(searchText) || category.includes(searchText);
  
          // Show or hide based on match
          card.style.display = isMatch ? "block" : "none";
        });
      });
    }
  
    // 🔽 Expand/Collapse Logic for each project card
    const expandButtons = document.querySelectorAll(".expand-btn");
  
    expandButtons.forEach(button => {
      button.addEventListener("click", function () {
        const card = this.closest(".project-card");
        const expandedSection = card.querySelector(".project-expanded");
        const icon = this.querySelector("i");
  
        // Toggle expanded state
        card.classList.toggle("expanded");
        expandedSection.classList.toggle("open");
  
        // Rotate icon
        if (icon.classList.contains("fa-chevron-down")) {
          icon.classList.remove("fa-chevron-down");
          icon.classList.add("fa-chevron-up");
          this.setAttribute("aria-expanded", "true");
        } else {
          icon.classList.remove("fa-chevron-up");
          icon.classList.add("fa-chevron-down");
          this.setAttribute("aria-expanded", "false");
        }
      });
    });
  });
  