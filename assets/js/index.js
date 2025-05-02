
// index.js - Typing effect for homepage hero summary

document.addEventListener("DOMContentLoaded", () => {
  const typedText = document.getElementById("typedText");
  if (!typedText) return;

  const fullText = typedText.getAttribute("data-text") || "";
  let index = 0;

  function typeChar() {
    if (index < fullText.length) {
      typedText.textContent += fullText.charAt(index);
      index++;
      setTimeout(typeChar, 30);
    }
  }

  if (fullText) typeChar();
});
