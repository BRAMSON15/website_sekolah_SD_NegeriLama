/**
 * Akademik Page JavaScript
 * Video modal player functionality
 */

/**
 * Open video modal with embed URL and metadata
 * @param {string} title - Video title
 * @param {string} embedUrl - Embed URL for the video
 * @param {string} subject - Subject/mata pelajaran
 * @param {string} classLevel - Class level/kelas
 * @param {string} platform - Video platform (YouTube, Google Drive, etc)
 */
function playPublicVideo(title, embedUrl, subject, classLevel, platform) {
  const modal = document.getElementById('modalPublicVideo');
  const iframe = document.getElementById('modalVideoIframe');
  const titleEl = document.getElementById('modalVideoTitle');
  const subjectEl = document.getElementById('modalVideoSubject');
  const classEl = document.getElementById('modalVideoClass');
  const platformEl = document.getElementById('modalVideoPlatform');

  if (!modal || !iframe) return;

  titleEl.textContent = title;
  subjectEl.textContent = subject;
  classEl.textContent = classLevel;
  platformEl.textContent = 'Sumber: ' + platform;

  // Set autoplay if embed URL supports it
  const autoplayUrl = embedUrl.includes('?') 
    ? (embedUrl + '&autoplay=1') 
    : (embedUrl + '?autoplay=1');
  iframe.src = autoplayUrl;

  modal.style.display = 'flex';
}

/**
 * Close video modal
 * Clears iframe src to stop video sound immediately
 */
function closePublicVideo() {
  const modal = document.getElementById('modalPublicVideo');
  const iframe = document.getElementById('modalVideoIframe');
  if (modal) modal.style.display = 'none';
  if (iframe) iframe.src = ''; // Clear src so video sound stops immediately
}

/**
 * Close modal when clicking on dark backdrop
 */
window.addEventListener('click', function(e) {
  const modal = document.getElementById('modalPublicVideo');
  if (e.target === modal) {
    closePublicVideo();
  }
});
