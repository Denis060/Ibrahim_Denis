// Toggle Navigation Menu
document.querySelector('.theme-toggle').addEventListener('click', () => {
  const body = document.body;
  const isDark = body.classList.contains('dark-mode');

  if (isDark) {
    body.classList.remove('dark-mode');
    body.classList.add('light-mode');
    document.cookie = "theme=light; path=/";
  } else {
    body.classList.remove('light-mode');
    body.classList.add('dark-mode');
    document.cookie = "theme=dark; path=/";
  }
});

// Typing Effect for About Section from data-text
document.addEventListener("DOMContentLoaded", function () {
    const typedText = document.getElementById("typedText");
    if (!typedText) return;
  
    const fullText = typedText.getAttribute("data-text") || "";
    let index = 0;
  
    function typeChar() {
      if (index < fullText.length) {
        typedText.textContent += fullText.charAt(index);
        index++;
        setTimeout(typeChar, 30); // Adjust speed if needed
      }
    }
  
    if (fullText) typeChar();
  });
  

// EXPERIENCE for Navigation Links
function toggleDescription(button) {
  const desc = button.closest('.experience-card').querySelector('.experience-description');
  desc.classList.toggle('collapsed');
  button.textContent = desc.classList.contains('collapsed') ? '▼' : '▲';
}
// Typing effect for summary on the home page
document.addEventListener("DOMContentLoaded", function () {
  const typedSummary = document.getElementById("typedSummary");
  if (!typedSummary) return;

  const fullText = typedSummary.getAttribute("data-text") || "";
  let index = 0;

  function typeSummary() {
    if (index < fullText.length) {
      typedSummary.textContent += fullText.charAt(index);
      index++;
      setTimeout(typeSummary, 30);
    }
  }

  if (fullText) typeSummary();
});
