/**
 * Guru Materi - Modal Management
 * Handles modal open/close functionality for learning materials
 */

/**
 * Open the materi (learning material) modal
 */
function openModalMateri() {
    const modal = document.getElementById('modalMateri');
    if (modal) {
        modal.style.display = 'flex';
    }
}

/**
 * Close the materi (learning material) modal
 */
function closeModalMateri() {
    const modal = document.getElementById('modalMateri');
    if (modal) {
        modal.style.display = 'none';
    }
}

/**
 * Handle backdrop click to close modal
 * Closes modal when user clicks on the backdrop overlay
 */
window.addEventListener('click', function(e) {
    const modal = document.getElementById('modalMateri');
    if (modal && e.target === modal) {
        closeModalMateri();
    }
});
