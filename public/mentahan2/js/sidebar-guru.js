/**
 * Guru Layout Sidebar Toggle JavaScript
 * Handles sidebar open/close, localStorage persistence, and responsive behavior
 */

document.addEventListener("DOMContentLoaded", function () {
  const body = document.body;
  const toggleBtn = document.getElementById("sidebarToggleBtn");
  const closeBtn = document.getElementById("sidebarCloseBtn");
  const backdrop = document.getElementById("sidebarBackdrop");
  const STORAGE_KEY = "sd_guru_sidebar_closed";

  // Initial check for desktop
  if (window.innerWidth >= 993) {
    const isClosed = localStorage.getItem(STORAGE_KEY) === "true";
    if (isClosed) {
      body.classList.add("sidebar-closed");
    } else {
      body.classList.remove("sidebar-closed");
    }
  }

  /**
   * Toggle sidebar open/closed state
   * Desktop: toggle collapsed state with localStorage
   * Mobile: toggle open overlay
   */
  function toggleSidebar() {
    if (window.innerWidth >= 993) {
      // Desktop toggle
      const willClose = !body.classList.contains("sidebar-closed");
      body.classList.toggle("sidebar-closed", willClose);
      localStorage.setItem(STORAGE_KEY, willClose ? "true" : "false");
    } else {
      // Mobile toggle
      const willOpen = !body.classList.contains("sidebar-open");
      body.classList.toggle("sidebar-open", willOpen);
      if (backdrop) {
        backdrop.classList.toggle("active", willOpen);
      }
    }
  }

  /**
   * Close sidebar
   * Desktop: add sidebar-closed class
   * Mobile: remove sidebar-open class and hide backdrop
   */
  function closeSidebar() {
    if (window.innerWidth >= 993) {
      body.classList.add("sidebar-closed");
      localStorage.setItem(STORAGE_KEY, "true");
    } else {
      body.classList.remove("sidebar-open");
      if (backdrop) {
        backdrop.classList.remove("active");
      }
    }
  }

  // Toggle button click handler
  if (toggleBtn) {
    toggleBtn.addEventListener("click", function (e) {
      e.stopPropagation();
      toggleSidebar();
    });
  }

  // Close button click handler
  if (closeBtn) {
    closeBtn.addEventListener("click", function (e) {
      e.stopPropagation();
      closeSidebar();
    });
  }

  // Backdrop click handler - close sidebar
  if (backdrop) {
    backdrop.addEventListener("click", function () {
      closeSidebar();
    });
  }

  // Close on Escape key
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      if (body.classList.contains("sidebar-open")) {
        closeSidebar();
      }
    }
  });

  // Window resize handler - adjust for viewport changes
  let resizeTimer;
  window.addEventListener("resize", function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {
      if (window.innerWidth >= 993) {
        // Desktop view
        if (backdrop) backdrop.classList.remove("active");
        body.classList.remove("sidebar-open");
        const isClosed = localStorage.getItem(STORAGE_KEY) === "true";
        body.classList.toggle("sidebar-closed", isClosed);
      } else {
        // Mobile view
        body.classList.remove("sidebar-closed");
      }
    }, 100);
  });
});
