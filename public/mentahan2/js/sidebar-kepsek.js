/**
 * Kepsek Layout Sidebar Toggle JavaScript
 * Handles sidebar open/close and overlay toggle
 */

/**
 * Toggle sidebar open/closed state
 * Also toggles overlay visibility
 */
function toggleSidebar() {
  const sidebar = document.getElementById('kepsekSidebar');
  const overlay = document.getElementById('sidebarOverlay');
  if (sidebar && overlay) {
    sidebar.classList.toggle('open');
    overlay.classList.toggle('active');
  }
}
