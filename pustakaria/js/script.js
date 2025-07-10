// Enhanced JavaScript for Perpustakaan Web

// Dark Mode Toggle
function initDarkMode() {
  try {
    const themeToggle = document.createElement("button");
    themeToggle.className = "theme-toggle";
    themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
    themeToggle.setAttribute("aria-label", "Toggle Dark Mode");
    document.body.appendChild(themeToggle);

    // Check for saved theme preference
    const savedTheme = localStorage.getItem("theme") || "light";
    document.documentElement.setAttribute("data-theme", savedTheme);
    updateThemeIcon(savedTheme);

    themeToggle.addEventListener("click", () => {
      const currentTheme = document.documentElement.getAttribute("data-theme");
      const newTheme = currentTheme === "dark" ? "light" : "dark";

      document.documentElement.setAttribute("data-theme", newTheme);
      localStorage.setItem("theme", newTheme);
      updateThemeIcon(newTheme);
    });
  } catch (error) {
    console.log("Dark mode initialization failed");
  }
}

function updateThemeIcon(theme) {
  const themeToggle = document.querySelector(".theme-toggle");
  if (themeToggle) {
    themeToggle.innerHTML =
      theme === "dark"
        ? '<i class="fas fa-sun"></i>'
        : '<i class="fas fa-moon"></i>';
  }
}

// Add smooth scrolling to all links
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute("href"));
    if (target) {
      target.scrollIntoView({
        behavior: "smooth",
        block: "start",
      });
    }
  });
});

// Enhanced Form Animations
function initFormAnimations() {
  const formControls = document.querySelectorAll(".form-control");

  formControls.forEach((input) => {
    // Add floating label effect
    input.addEventListener("focus", () => {
      input.parentElement.classList.add("focused");
      input.classList.add("fade-in");
    });

    input.addEventListener("blur", () => {
      if (!input.value) {
        input.parentElement.classList.remove("focused");
      }
      input.classList.remove("fade-in");
    });

    // Add typing animation
    input.addEventListener("input", () => {
      input.classList.add("pulse");
      setTimeout(() => input.classList.remove("pulse"), 200);
    });
  });
}

// Loading States for Buttons - DISABLED (causing issues)
function initButtonLoadingStates() {
  // Disabled to prevent loading issues
  console.log("Button loading states disabled");
}

// Minimal DOM initialization
document.addEventListener("DOMContentLoaded", function () {
  console.log("DOM loaded - minimal script");

  // Only essential functionality
  try {
    // Basic form handling without loading states
    const forms = document.querySelectorAll("form");
    forms.forEach((form) => {
      form.addEventListener("submit", function () {
        console.log("Form submitted");
      });
    });
  } catch (error) {
    console.log("Error:", error);
  }
});

// Add hover effect to navigation links
document.querySelectorAll(".nav-link").forEach((link) => {
  link.addEventListener("mouseenter", function () {
    this.style.transform = "translateY(-2px)";
  });
  link.addEventListener("mouseleave", function () {
    this.style.transform = "translateY(0)";
  });
});

// Add loading animation
window.addEventListener("load", function () {
  document.body.classList.add("loaded");
});

// Add scroll to top button
window.onscroll = function () {
  const scrollTopBtn = document.getElementById("scrollTop");
  if (scrollTopBtn) {
    if (
      document.body.scrollTop > 20 ||
      document.documentElement.scrollTop > 20
    ) {
      scrollTopBtn.style.display = "block";
    } else {
      scrollTopBtn.style.display = "none";
    }
  }
};

// Initialize tooltips
try {
  if (typeof bootstrap !== "undefined") {
    var tooltipTriggerList = [].slice.call(
      document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  }
} catch (error) {
  console.log("Bootstrap tooltips not available");
}

// Add animation to dashboard cards
try {
  document.querySelectorAll(".dashboard-card").forEach((card, index) => {
    card.style.animation = `slideIn 0.5s ease forwards ${index * 0.1}s`;
  });
} catch (error) {
  console.log("Dashboard cards animation not available");
}

// Add keyframe animations
const style = document.createElement("style");
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    .loaded {
        transition: opacity 0.3s ease-in;
    }
`;
document.head.appendChild(style);
