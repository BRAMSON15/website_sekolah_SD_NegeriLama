/**
 * Siswa Beranda - Video Player Modal Management
 * Handles opening/closing modal video player and keyboard controls
 */

function playStudentVideo(title, embedUrl, subject, classLevel, platform) {
  const modal = document.getElementById('modalStudentVideo');
  const iframe = document.getElementById('modalStudentVideoIframe');
  const titleEl = document.getElementById('modalStudentVideoTitle');
  const subjectEl = document.getElementById('modalStudentVideoSubject');
  const classEl = document.getElementById('modalStudentVideoClass');
  const platformEl = document.getElementById('modalStudentVideoPlatform');

  if (!modal || !iframe) return;

  titleEl.textContent = title;
  subjectEl.textContent = subject;
  classEl.textContent = classLevel;
  platformEl.textContent = 'Sumber: ' + platform;

  // Set autoplay if embed URL supports it
  const autoplayUrl = embedUrl.includes('?') ? (embedUrl + '&autoplay=1') : (embedUrl + '?autoplay=1');
  iframe.src = autoplayUrl;

  modal.style.display = 'flex';
}

function closeStudentVideo() {
  const modal = document.getElementById('modalStudentVideo');
  const iframe = document.getElementById('modalStudentVideoIframe');
  if (modal) modal.style.display = 'none';
  if (iframe) iframe.src = '';
}

// Close modal when clicking outside (on the backdrop)
window.addEventListener('click', function(e) {
  const modal = document.getElementById('modalStudentVideo');
  if (e.target === modal) {
    closeStudentVideo();
  }
});

// Close modal on Escape key press
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeStudentVideo();
  }
});
