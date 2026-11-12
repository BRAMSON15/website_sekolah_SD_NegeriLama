 
    document.addEventListener('DOMContentLoaded', function() {
      const toggleBtn = document.getElementById('sidebarToggleBtn');
      const closeBtn = document.getElementById('sidebarCloseBtn');
      const sidebar = document.getElementById('appSidebar');
      const backdrop = document.getElementById('sidebarBackdrop');

      const isMobile = function() {
        return window.innerWidth <= 992;
      };

      // Restore saved desktop state from localStorage
      const savedClosedState = localStorage.getItem('admin_sidebar_closed') === 'true';
      if (!isMobile() && savedClosedState) {
        document.body.classList.add('sidebar-closed');
      }
      document.documentElement.classList.remove('sidebar-closed-preload');

      function updateToggleTooltip() {
        if (!toggleBtn) return;
        const isClosed = isMobile()
          ? !sidebar.classList.contains('mobile-open')
          : document.body.classList.contains('sidebar-closed');

        const titleText = isClosed ? 'Buka Sidebar' : 'Tutup Sidebar';
        toggleBtn.setAttribute('title', titleText);
        toggleBtn.setAttribute('aria-label', titleText);
      }

      function toggleSidebar() {
        if (isMobile()) {
          const isOpen = sidebar.classList.toggle('mobile-open');
          if (backdrop) {
            backdrop.classList.toggle('active', isOpen);
          }
        } else {
          document.body.classList.toggle('sidebar-closed');
          const isClosed = document.body.classList.contains('sidebar-closed');
          localStorage.setItem('admin_sidebar_closed', isClosed ? 'true' : 'false');
          // Trigger resize for Leaflet map & responsive components
          setTimeout(function() {
            window.dispatchEvent(new Event('resize'));
          }, 320);
        }
        updateToggleTooltip();
      }

      function closeSidebar() {
        if (isMobile()) {
          sidebar.classList.remove('mobile-open');
          if (backdrop) {
            backdrop.classList.remove('active');
          }
        } else {
          document.body.classList.add('sidebar-closed');
          localStorage.setItem('admin_sidebar_closed', 'true');
          setTimeout(function() {
            window.dispatchEvent(new Event('resize'));
          }, 320);
        }
        updateToggleTooltip();
      }

      if (toggleBtn) {
        toggleBtn.addEventListener('click', toggleSidebar);
      }
      if (closeBtn) {
        closeBtn.addEventListener('click', closeSidebar);
      }
      if (backdrop) {
        backdrop.addEventListener('click', closeSidebar);
      }

      // Close on Escape key
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
          if (isMobile() && sidebar.classList.contains('mobile-open')) {
            closeSidebar();
          }
        }
      });

      // Handle screen resize between mobile and desktop
      let prevIsMobile = isMobile();
      window.addEventListener('resize', function() {
        const currentlyMobile = isMobile();
        if (currentlyMobile !== prevIsMobile) {
          prevIsMobile = currentlyMobile;
          if (currentlyMobile) {
            sidebar.classList.remove('mobile-open');
            if (backdrop) backdrop.classList.remove('active');
          } else {
            const isClosed = localStorage.getItem('admin_sidebar_closed') === 'true';
            document.body.classList.toggle('sidebar-closed', isClosed);
          }
          updateToggleTooltip();
        }
      });

      updateToggleTooltip();
    });
  