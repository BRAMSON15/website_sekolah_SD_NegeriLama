@extends('layouts.guru')

@section('title', 'Tugas & Penilaian - ' . ($settings['school_name'] ?? 'SD NEGERI LAMA'))

@section('content')
<!-- NOTIFICATION ALERTS -->
@if(session('success'))
<div style="background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 14px 18px; border-radius: 12px; margin-bottom: 22px; display: flex; align-items: center; gap: 12px; font-weight: 600; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.08);">
    <i class="fa-solid fa-circle-check" style="font-size: 1.3rem; color: #16a34a;"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

@if($errors->any())
<div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 14px 18px; border-radius: 12px; margin-bottom: 22px;">
    <div style="font-weight: 700; margin-bottom: 6px; display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-circle-exclamation"></i> Terjadi kesalahan input tugas:
    </div>
    <ul style="margin: 0; padding-left: 20px; font-size: 0.9rem;">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- BREADCRUMB / HERO -->
<div class="welcome" style="margin-bottom: 25px;">
    <div class="welcome-text">
        <h1>
            <i class="fa-solid fa-clipboard-check"></i> Tugas & Penilaian Siswa
        </h1>
        <p>
            Kelola pembuatan tugas harian, pekerjaan rumah (PR), lembar evaluasi, dan input nilai peserta didik.
        </p>
    </div>
    <div class="teacher-illustration">
        <div class="teacher">
            <div class="teacher-head"></div>
            <div class="teacher-body"></div>
        </div>
        <div class="board">
            <span>{{ count($assignments) }} Tugas</span>
            <small>Semester Ini</small>
        </div>
    </div>
</div>

<!-- STATS -->
<div class="stats" style="margin-bottom: 25px;">
    <div class="stat-card orange">
        <div class="stat-icon"><i class="fa-solid fa-hourglass-half"></i></div>
        <h2>{{ $activeCount }}</h2>
        <p>Tugas Berjalan (Aktif)</p>
        <span style="font-size: 11px; color: var(--muted);"><i class="fa-solid fa-clock"></i> Belum Selesai Dinilai</span>
    </div>
    <div class="stat-card green">
        <div class="stat-icon"><i class="fa-solid fa-check-double"></i></div>
        <h2>{{ $completedCount }}</h2>
        <p>Selesai Dinilai</p>
        <span style="font-size: 11px; color: var(--muted);"><i class="fa-solid fa-circle-check"></i> Sudah Tuntas Diisi</span>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
        <h2>{{ $totalSubmissions }}</h2>
        <p>Total Pengumpulan Dinilai</p>
        <span style="font-size: 11px; color: var(--muted);"><i class="fa-solid fa-chart-simple"></i> Lembar Nilai Siswa</span>
    </div>
    <div class="stat-card purple">
        <div class="stat-icon"><i class="fa-solid fa-award"></i></div>
        <h2>{{ count($assignments) }}</h2>
        <p>Total Tugas / Ulangan</p>
        <span style="font-size: 11px; color: var(--muted);"><i class="fa-solid fa-thumbs-up"></i> Seluruh Kelas</span>
    </div>
</div>

<!-- ACTIONS BAR -->
<div class="section-card" style="margin-bottom: 25px; padding: 18px 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
    <h2 style="font-size: 1.15rem; font-weight: 800; color: var(--text); margin: 0;">
        <i class="fa-solid fa-list-check" style="color: var(--primary);"></i> Daftar Tugas & Ulangan Siswa
    </h2>

    <button type="button" onclick="openModalTugas()" style="background: #ea580c; color: white; border: none; padding: 10px 20px; border-radius: 9px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(234, 88, 12, 0.25);">
        <i class="fa-solid fa-plus"></i> Buat Tugas / Ulangan Baru
    </button>
</div>

<!-- ASSIGNMENT LIST -->
<div style="display: flex; flex-direction: column; gap: 18px; margin-bottom: 30px;">
    @forelse($assignments as $asg)
    @php
        $total = max($asg->total_students, 1);
        $percent = round(($asg->submitted_count / $total) * 100);
    @endphp
    <div class="section-card" style="padding: 22px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 15px; margin-bottom: 16px;">
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                    <span style="background: #e0f2fe; color: #0369a1; padding: 3px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                        {{ $asg->class_level }} • {{ $asg->subject }}
                    </span>
                    @if($asg->status === 'Aktif')
                        <span style="background: #dcfce7; color: #15803d; padding: 3px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                            <i class="fa-solid fa-circle-dot"></i> Aktif
                        </span>
                    @else
                        <span style="background: #ede9fe; color: #6d28d9; padding: 3px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                            <i class="fa-solid fa-check"></i> Selesai Dinilai
                        </span>
                    @endif
                </div>
                <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--text); margin: 0 0 6px 0;">{{ $asg->title }}</h3>
                <span style="font-size: 0.85rem; color: #ef4444; font-weight: 600;">
                    <i class="fa-regular fa-calendar-xmark"></i> Batas Pengumpulan: {{ $asg->deadline }}
                </span>
                <p style="font-size: 0.88rem; color: #64748b; margin: 8px 0 0 0; line-height: 1.5;">
                    {{ Str::limit($asg->description, 140) }}
                </p>
            </div>

            <div style="display: flex; gap: 10px; align-items: center;">
                <a href="{{ route('guru.tugas.detail', $asg->id) }}" style="background: #2875dc; color: #fff; text-decoration: none; padding: 9px 18px; border-radius: 8px; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 10px rgba(40, 117, 220, 0.2);">
                    <i class="fa-solid fa-user-check"></i> Periksa & Input Nilai ({{ $asg->submitted_count }}/{{ $asg->total_students }})
                </a>
                <form action="{{ route('guru.tugas.destroy', $asg->id) }}" method="POST" onsubmit="return confirm('Hapus tugas ini beserta seluruh data nilainya?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: #fee2e2; color: #dc2626; border: none; padding: 9px 12px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer;" title="Hapus Tugas">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </form>
            </div>
        </div>

        <div style="background: var(--background); padding: 14px 18px; border-radius: 10px;">
            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; margin-bottom: 8px;">
                <span style="font-weight: 600; color: var(--text);">Kemajuan Penilaian Siswa:</span>
                <span style="font-weight: 800; color: var(--primary);">{{ $asg->submitted_count }} dari {{ $asg->total_students }} Siswa ({{ $percent }}%)</span>
            </div>
            <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 10px; overflow: hidden;">
                <div style="width: {{ min($percent, 100) }}%; height: 100%; background: {{ $percent >= 100 ? '#16a34a' : '#2875dc' }}; border-radius: 10px; transition: width 0.3s;"></div>
            </div>
        </div>
    </div>
    @empty
    <div class="section-card" style="padding: 40px; text-align: center; color: var(--muted);">
        <i class="fa-solid fa-clipboard-list" style="font-size: 2.5rem; margin-bottom: 12px; color: #cbd5e1; display: block;"></i>
        <h3 style="font-size: 1.1rem; color: var(--text); margin-bottom: 6px;">Belum Ada Tugas Dibuat</h3>
        <p style="font-size: 0.9rem; margin-bottom: 16px;">Buat tugas atau ulangan baru untuk siswa sekarang.</p>
        <button type="button" onclick="openModalTugas()" style="background: #ea580c; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer;">
            <i class="fa-solid fa-plus"></i> Buat Tugas Baru
        </button>
    </div>
    @endforelse
</div>

<!-- MODAL BUAT TUGAS -->
<div id="modalTugas" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); z-index: 9999; justify-content: center; align-items: center; padding: 20px; backdrop-filter: blur(2px);">
    <div style="background: #ffffff; width: 100%; max-width: 560px; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.25);">
        <div style="background: #ea580c; color: #ffffff; padding: 18px 24px; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 1.1rem;">
                <i class="fa-solid fa-plus-circle"></i> Buat Tugas / Evaluasi Baru
            </div>
            <button type="button" onclick="closeModalTugas()" style="background: transparent; border: none; color: #ffffff; font-size: 1.4rem; cursor: pointer; line-height: 1;">&times;</button>
        </div>

        <form action="{{ route('guru.tugas.store') }}" method="POST" style="padding: 24px;">
            @csrf
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Judul Tugas / Ulangan *</label>
                <input type="text" name="title" required placeholder="Contoh: Penilaian Harian Bab 2: Operasi Hitung Campuran" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Mata Pelajaran *</label>
                    <input type="text" name="subject" required placeholder="Contoh: Matematika" value="{{ Auth::user()->subject ?: 'Matematika' }}" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Tingkat Kelas *</label>
                    <select name="class_level" required style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; background: #fff; box-sizing: border-box;">
                        <option value="Kelas 4A">Kelas 4A</option>
                        <option value="Kelas 5A" selected>Kelas 5A</option>
                        <option value="Kelas 6B">Kelas 6B</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Batas Waktu Pengumpulan (Deadline) *</label>
                <input type="text" name="deadline" required placeholder="Contoh: 28 September 2026, 23:59 WIT" value="{{ date('d M Y', strtotime('+7 days')) }}, 23:59 WIT" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 22px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Petunjuk Pengerjaan Tugas *</label>
                <textarea name="description" rows="3" required placeholder="Tuliskan petunjuk pengerjaan soal atau tugas yang harus dikumpulkan siswa..." style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box; resize: vertical;">Kerjakan latihan soal di buku tugas masing-masing dan kumpulkan tepat waktu.</textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeModalTugas()" style="padding: 10px 18px; border: 1px solid #cbd5e1; background: #f1f5fa; color: #475569; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer;">
                    Batal
                </button>
                <button type="submit" style="padding: 10px 22px; background: #ea580c; border: none; color: #ffffff; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-plus-circle"></i> Terbitkan Tugas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openModalTugas() {
        document.getElementById('modalTugas').style.display = 'flex';
    }

    function closeModalTugas() {
        document.getElementById('modalTugas').style.display = 'none';
    }

    window.addEventListener('click', function(e) {
        const modal = document.getElementById('modalTugas');
        if (e.target === modal) {
            closeModalTugas();
        }
    });
</script>
@endsection
