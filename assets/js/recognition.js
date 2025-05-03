// Expand/Collapse recognition cards
document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".expand-btn");
  
    buttons.forEach(button => {
      button.addEventListener("click", function () {
        const card = this.closest(".recognition-card");
        const expanded = card.querySelector(".recognition-expanded");
  
        // Toggle expanded state
        expanded.classList.toggle("open");
        card.classList.toggle("expanded");
  
        // Icon toggle
        const icon = this.querySelector("i");
        icon.classList.toggle("fa-chevron-down");
        icon.classList.toggle("fa-chevron-up");
      });
    });
  });
  
  // Search/Filter functionality
const searchInput = document.getElementById("recognitionSearchInput");

if (searchInput) {
  searchInput.addEventListener("input", function () {
    const searchText = this.value.toLowerCase();
    const recognitionCards = document.querySelectorAll(".recognition-card");

    recognitionCards.forEach(card => {
      const title = card.querySelector(".recognition-title")?.textContent.toLowerCase() || "";
      const org = card.querySelector(".recognition-org")?.textContent.toLowerCase() || "";
      const type = card.querySelector(".recognition-type")?.textContent.toLowerCase() || "";
      const match = title.includes(searchText) || org.includes(searchText) || type.includes(searchText);

      card.style.display = match ? "block" : "none";
    });
  });
}
