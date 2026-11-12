/**
 * Mobile Navigation Dropdown JavaScript
 * Handles toggle, overlay, keyboard, and responsive behavior
 */

document.addEventListener('DOMContentLoaded', function () {
  const toggleBtn = document.getElementById('mobileNavToggle');
  const navDropdown = document.getElementById('mobileNavDropdown');
  const navOverlay = document.getElementById('mobileNavOverlay');
  const navIcon = document.getElementById('mobileNavIcon');

  if (!toggleBtn || !navDropdown) return;

  /**
   * Toggle mobile navigation menu open/closed state
   * @param {boolean|undefined} forceState - Force open (true) or closed (false), toggle if undefined
   */
  function toggleMenu(forceState) {
    const shouldOpen = forceState !== undefined ? forceState : !navDropdown.classList.contains('is-open');

    if (shouldOpen) {
      navDropdown.classList.add('is-open');
      toggleBtn.classList.add('is-active');
      toggleBtn.setAttribute('aria-expanded', 'true');
      navDropdown.setAttribute('aria-hidden', 'false');
      if (navOverlay) navOverlay.classList.add('is-visible');
      if (navIcon) {
        navIcon.classList.remove('fa-bars');
        navIcon.classList.add('fa-xmark');
      }
    } else {
      navDropdown.classList.remove('is-open');
      toggleBtn.classList.remove('is-active');
      toggleBtn.setAttribute('aria-expanded', 'false');
      navDropdown.setAttribute('aria-hidden', 'true');
      if (navOverlay) navOverlay.classList.remove('is-visible');
      if (navIcon) {
        navIcon.classList.remove('fa-xmark');
        navIcon.classList.add('fa-bars');
      }
    }
  }

  // Toggle button click handler
  toggleBtn.addEventListener('click', function (e) {
    e.stopPropagation();
    toggleMenu();
  });

  // Overlay click to close
  if (navOverlay) {
    navOverlay.addEventListener('click', function () {
      toggleMenu(false);
    });
  }

  // Close when clicking outside of navbar & dropdown
  document.addEventListener('click', function (e) {
    if (!navDropdown.contains(e.target) && !toggleBtn.contains(e.target)) {
      toggleMenu(false);
    }
  });

  // Close on Escape key press
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && navDropdown.classList.contains('is-open')) {
      toggleMenu(false);
    }
  });

  // Auto close when clicking any navigation link inside dropdown
  const links = navDropdown.querySelectorAll('a');
  links.forEach(function (link) {
    link.addEventListener('click', function () {
      toggleMenu(false);
    });
  });

  // Auto close if window resized above mobile breakpoint (768px)
  window.addEventListener('resize', function () {
    if (window.innerWidth > 768 && navDropdown.classList.contains('is-open')) {
      toggleMenu(false);
    }
  });
});
