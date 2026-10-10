/**
 * Guru Video Page JavaScript
 * Video player mode toggle, modal management, and video form handling
 */

/**
 * Toggle active video player between wide and compact modes
 * Saves preference to localStorage
 */
function togglePlayerMode() {
  const grid = document.getElementById('activePlayerGrid');
  const btn = document.getElementById('btnToggleMode');
  if (!grid || !btn) return;

  const isWide = grid.classList.toggle('mode-wide');
  localStorage.setItem('guru_video_player_mode', isWide ? 'wide' : 'compact');
  btn.innerHTML = isWide 
    ? '<i class="fa-solid fa-compress"></i> Mode Ringkas' 
    : '<i class="fa-solid fa-expand"></i> Mode Lebar';
}

/**
 * Initialize video player mode from localStorage
 */
document.addEventListener('DOMContentLoaded', function() {
  const savedMode = localStorage.getItem('guru_video_player_mode');
  if (savedMode === 'wide') {
    const grid = document.getElementById('activePlayerGrid');
    const btn = document.getElementById('btnToggleMode');
    if (grid && btn) {
      grid.classList.add('mode-wide');
      btn.innerHTML = '<i class="fa-solid fa-compress"></i> Mode Ringkas';
    }
  }
});

/**
 * Open modal to add new video
 */
function openModalVideo() {
  const modal = document.getElementById('modalVideo');
  if (modal) {
    modal.style.display = 'flex';
  }
}

/**
 * Close modal to add new video
 */
function closeModalVideo() {
  const modal = document.getElementById('modalVideo');
  if (modal) {
    modal.style.display = 'none';
  }
}

/**
 * Open modal to edit existing video
 * @param {Object} video - Video data object
 */
function openEditModal(video) {
  const modal = document.getElementById('modalEditVideo');
  const form = document.getElementById('formEditVideo');
  if (!modal || !form || !video) return;

  // Set action route dynamically
  form.action = window.videoEditBaseUrl + '/' + video.id;

  // Populate fields
  document.getElementById('edit_title').value = video.title || '';
  document.getElementById('edit_subject').value = video.subject || '';
  document.getElementById('edit_class_level').value = video.class_level || '';
  document.getElementById('edit_duration').value = video.duration || '';
  document.getElementById('edit_description').value = video.description || '';

  const effectiveUrl = video.video_url || video.youtube_url || '';
  document.getElementById('edit_video_url').value = effectiveUrl;

  // Set platform source radio
  const sourceType = video.source_type || 'youtube';
  if (sourceType === 'google_drive') {
    document.getElementById('edit_source_google_drive').checked = true;
    toggleSourceTypeHelp('edit', 'google_drive');
  } else if (sourceType === 'youtube') {
    document.getElementById('edit_source_youtube').checked = true;
    toggleSourceTypeHelp('edit', 'youtube');
  } else {
    document.getElementById('edit_source_auto').checked = true;
    toggleSourceTypeHelp('edit', 'auto');
  }

  modal.style.display = 'flex';
}

/**
 * Close modal to edit video
 */
function closeEditModal() {
  const modal = document.getElementById('modalEditVideo');
  if (modal) {
    modal.style.display = 'none';
  }
}

/**
 * Toggle source type help box and update input labels/placeholders
 * @param {string} context - 'create' or 'edit'
 * @param {string} type - 'youtube', 'google_drive', or 'auto'
 */
function toggleSourceTypeHelp(context, type) {
  const isCreate = (context === 'create');
  const pills = document.querySelectorAll(isCreate ? '.source-pill' : '.source-pill-edit');
  const helpBox = document.getElementById(isCreate ? 'driveHelpBox-create' : 'driveHelpBox-edit');
  const urlLabel = document.getElementById(isCreate ? 'urlLabel-create' : 'urlLabel-edit');
  const urlInput = document.getElementById(isCreate ? 'videoUrlInput-create' : 'edit_video_url');
  const urlHelp = document.getElementById(isCreate ? 'urlHelp-create' : 'urlHelp-edit');

  // Update pills active styling
  pills.forEach(pill => {
    const pillFor = pill.getAttribute('data-for');
    if (pillFor === type) {
      if (type === 'youtube') {
        pill.style.border = '2px solid #ef4444';
        pill.style.background = '#fef2f2';
        pill.style.color = '#b91c1c';
      } else if (type === 'google_drive') {
        pill.style.border = '2px solid #0284c7';
        pill.style.background = '#f0f9ff';
        pill.style.color = '#0369a1';
      } else {
        pill.style.border = '2px solid #8b5cf6';
        pill.style.background = '#f5f3ff';
        pill.style.color = '#6d28d9';
      }
    } else {
      pill.style.border = '2px solid #e2e8f0';
      pill.style.background = '#ffffff';
      pill.style.color = '#64748b';
    }
  });

  // Toggle Google Drive Guidance Box & Input Placeholders
  if (type === 'google_drive') {
    if (helpBox) helpBox.style.display = 'block';
    if (urlLabel) urlLabel.textContent = 'Tautan Berkas Google Drive *';
    if (urlInput) urlInput.placeholder = 'https://drive.google.com/file/d/1A2b3C.../view?usp=sharing';
    if (urlHelp) urlHelp.textContent = 'Tempel tautan berkas video Google Drive dengan setelan akses "Siapa saja yang memiliki link".';
  } else if (type === 'youtube') {
    if (helpBox) helpBox.style.display = 'none';
    if (urlLabel) urlLabel.textContent = 'Tautan Video YouTube *';
    if (urlInput) urlInput.placeholder = 'https://www.youtube.com/watch?v=... atau https://youtu.be/...';
    if (urlHelp) urlHelp.textContent = 'Mendukung URL video YouTube standar, video Shorts, maupun link share youtu.be.';
  } else {
    if (helpBox) helpBox.style.display = 'none';
    if (urlLabel) urlLabel.textContent = 'Tautan Video (YouTube atau Google Drive) *';
    if (urlInput) urlInput.placeholder = 'https://www.youtube.com/watch?v=... atau https://drive.google.com/file/d/.../view';
    if (urlHelp) urlHelp.textContent = 'Sistem akan mendeteksi platform (YouTube / Google Drive) secara otomatis dari URL yang Anda masukkan.';
  }
}

/**
 * Close modals when clicking outside overlay
 */
window.addEventListener('click', function(e) {
  const modalCreate = document.getElementById('modalVideo');
  if (e.target === modalCreate) {
    closeModalVideo();
  }

  const modalEdit = document.getElementById('modalEditVideo');
  if (e.target === modalEdit) {
    closeEditModal();
  }
});
