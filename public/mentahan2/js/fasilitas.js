/**
 * Admin Fasilitas Management JavaScript
 * Dynamic facility row addition and removal
 */

// Initialize facility index from initial count
let facilityIndex = window.initialFacilityCount || 0;

/**
 * Add new facility input row dynamically
 */
function addFacilityRow() {
  facilityIndex++;
  const container = document.getElementById('facilitiesContainer');
  const rowId = 'facility_row_' + facilityIndex;

  const html = `
    <div class="facility-card-item" id="${rowId}" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; position: relative;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
        <span style="font-weight: 700; color: #1e3a8a; font-size: 14px; display: flex; align-items: center; gap: 8px;">
          <span class="facility-badge" style="width: 26px; height: 26px; border-radius: 50%; background: #2563eb; color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 12px;">+</span>
          Fasilitas Baru
        </span>
        <button type="button" class="btn btn-grey" onclick="removeFacilityRow('${rowId}')" style="padding: 5px 12px; font-size: 12px; color: #ef4444; border-color: #fecaca; background: #fff;">
          <i class="fa-solid fa-trash-can"></i> Hapus
        </button>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Nama Fasilitas</label>
            <input type="text" name="facilities[${facilityIndex}][title]" class="form-control" required placeholder="Contoh: Perpustakaan Modern">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Ikon FontAwesome</label>
            <input type="text" name="facilities[${facilityIndex}][icon]" class="form-control" value="fa-solid fa-school" required placeholder="fa-solid fa-school">
          </div>
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 0;">
        <label>Deskripsi Fasilitas</label>
        <textarea name="facilities[${facilityIndex}][desc]" class="form-control" rows="2" required placeholder="Deskripsi ringkas sarana..."></textarea>
      </div>
    </div>
  `;

  container.insertAdjacentHTML('beforeend', html);
}

/**
 * Remove facility input row
 * @param {string} id - The ID of the facility row to remove
 */
function removeFacilityRow(id) {
  const row = document.getElementById(id);
  const container = document.getElementById('facilitiesContainer');
  if (container.getElementsByClassName('facility-card-item').length <= 1) {
    alert('Minimal harus ada satu fasilitas yang terdaftar.');
    return;
  }
  if (row && confirm('Apakah Anda yakin ingin menghapus fasilitas ini?')) {
    row.remove();
  }
}
