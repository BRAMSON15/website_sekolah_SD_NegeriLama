/**
 * Kepsek Pembelajaran - Video Modal Management
 * Handles opening/closing video modal and iframe manipulation
 */

function openVideoModal(title, url, type) {
  document.getElementById('modalVideoTitle').innerText = title;
  const iframe = document.getElementById('videoIframe');
  
  let targetSrc = url;
  if (type === 'youtube' && !targetSrc.includes('embed')) {
    const match = targetSrc.match(/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/);
    if (match && match[1]) {
      targetSrc = 'https://www.youtube.com/embed/' + match[1] + '?autoplay=1';
    }
  }
  iframe.src = targetSrc;
  document.getElementById('videoModal').classList.remove('hidden');
}

function closeVideoModal() {
  const modal = document.getElementById('videoModal');
  modal.classList.add('hidden');
  document.getElementById('videoIframe').src = '';
}

// Close on backdrop click
document.getElementById('videoModal').addEventListener('click', function(e) {
  if (e.target === this) {
    closeVideoModal();
  }
});
