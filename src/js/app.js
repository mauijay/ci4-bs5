import 'bootstrap';


function highlightKeyword(keyword) {
  if (!keyword) return;

  const elements = document.querySelectorAll("p, h1, h2, h3, h4, h5, h6");

  const regex = new RegExp(`\\b${keyword}\\b`, "gi");

  elements.forEach(el => {
    el.innerHTML = el.innerHTML.replace(regex, (match) => {
      return `<span class="highlight">${match}</span>`;
    });
  });
}

// Example 1: From search query (?q=bootstrap)
const params = new URLSearchParams(window.location.search);
const q = params.get("q");
highlightKeyword(q);

// Example 2: Manual keyword highlight
// highlightKeyword("bootstrap");
