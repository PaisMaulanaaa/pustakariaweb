// Safe JavaScript for Perpustakaan Web - No Loading Issues

console.log('Safe script loaded');

// Basic DOM ready
document.addEventListener("DOMContentLoaded", function () {
  console.log('DOM ready - safe mode');
  
  // Only essential functionality
  try {
    // Password toggle for login form
    const togglePassword = document.getElementById('togglePassword');
    if (togglePassword) {
      togglePassword.addEventListener('click', function() {
        const password = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if (password.type === 'password') {
          password.type = 'text';
          icon.classList.remove('fa-eye');
          icon.classList.add('fa-eye-slash');
        } else {
          password.type = 'password';
          icon.classList.remove('fa-eye-slash');
          icon.classList.add('fa-eye');
        }
      });
    }
    
    // Basic form validation
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(form => {
      form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      });
    });
    
  } catch (error) {
    console.log("Error in safe script:", error);
  }
});

console.log('Safe script initialized');
