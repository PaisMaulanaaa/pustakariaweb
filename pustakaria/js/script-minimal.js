// Minimal JavaScript for Perpustakaan Web - Safe Version

console.log('Minimal script loaded');

// Basic DOM ready function
document.addEventListener("DOMContentLoaded", function () {
  console.log('DOM loaded');
  
  // Basic form handling
  const forms = document.querySelectorAll('form');
  forms.forEach(form => {
    form.addEventListener('submit', function() {
      console.log('Form submitted');
    });
  });
  
  // Basic button handling
  const buttons = document.querySelectorAll('.btn');
  buttons.forEach(button => {
    button.addEventListener('click', function() {
      console.log('Button clicked');
    });
  });
});

console.log('Minimal script initialized');
