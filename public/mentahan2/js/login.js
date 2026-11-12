/**
 * Login Form JavaScript
 * Password visibility toggle functionality
 */

/**
 * Toggle password visibility
 * Changes input type between password and text
 * Updates icon accordingly
 * 
 * @param {HTMLElement} button - The toggle button element
 */
function togglePasswordVisibility(button) {
  event.preventDefault();
  
  // Cari input password di dalam wrapper yang sama
  const wrapper = button.closest('.password-input-wrapper');
  const input = wrapper.querySelector('input[type="password"], input[type="text"]');
  const icon = button.querySelector('i');
  
  if (input.type === 'password') {
    // Tampilkan password
    input.type = 'text';
    icon.classList.remove('fa-eye');
    icon.classList.add('fa-eye-slash');
    button.title = 'Sembunyikan password';
    button.setAttribute('aria-label', 'Sembunyikan password');
  } else {
    // Sembunyikan password
    input.type = 'password';
    icon.classList.remove('fa-eye-slash');
    icon.classList.add('fa-eye');
    button.title = 'Tampilkan password';
    button.setAttribute('aria-label', 'Tampilkan password');
  }
}
