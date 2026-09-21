@extends('layouts.guru')

@section('title', 'Input Nilai: ' . $assignment->title . ' - ' . ($settings['school_name'] ?? 'SD NEGERI LAMA'))

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
        <i class="fa-solid fa-circle-exclamation"></i> Terjadi kesalahan simpan nilai:
    </div>
    <ul style="margin: 0; padding-left: 20px; font-size: 0.9rem;">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- NAVIGATION BACK & HEADER -->
<div style="margin-bottom: 20px;">
    <a href="{{ route('guru.tugas') }}" style="display: inline-flex; align-items: center; gap: 8px; color: var(--primary); font-weight: 700; font-size: 0.9rem; text-decoration: none; margin-bottom: 12px;">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Tugas
    </a>
</div>

<!-- WELCOME / HERO BANNER -->
<div class="welcome" style="margin-bottom: 25px;">
    <div class="welcome-text">
        <h1>
            <i class="fa-solid fa-pen-to-square"></i> Lembar Penilaian Siswa
        </h1>
        <p>
            Input nilai angka dan catatan umpan balik hasil pengerjaan tugas peserta didik untuk penilaian kurikulum.
        </p>
    </div>
    <div class="teacher-illustration">
        <div class="teacher">
            <div class="teacher-head"></div>
            <div class="teacher-body"></div>
        </div>
        <div class="board">
            <span>{{ $assignment->class_level }}</span>
            <small>{{ $assignment->subject }}</small>
        </div>
    </div>
</div>

<!-- ASSIGNMENT DETAILS CARD -->
<div class="section-card" style="margin-bottom: 25px; padding: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 15px; margin-bottom: 16px;">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                <span style="background: #e0f2fe; color: #0369a1; padding: 3px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                    {{ $assignment->class_level }} • {{ $assignment->subject }}
                </span>
                @if($assignment->status === 'Aktif')
                    <span style="background: #dcfce7; color: #15803d; padding: 3px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                        <i class="fa-solid fa-circle-dot"></i> Status: Aktif
                    </span>
                @else
                    <span style="background: #ede9fe; color: #6d28d9; padding: 3px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                        <i class="fa-solid fa-check-double"></i> Selesai Dinilai
                    </span>
                @endif
            </div>
            <h2 style="font-size: 1.35rem; font-weight: 800; color: var(--text); margin: 0 0 8px 0;">{{ $assignment->title }}</h2>
            <div style="font-size: 0.88rem; color: #ef4444; font-weight: 600; margin-bottom: 12px;">
                <i class="fa-regular fa-calendar-xmark"></i> Batas Pengumpulan: {{ $assignment->deadline }}
            </div>
            <div style="background: var(--background); padding: 12px 16px; border-radius: 8px; font-size: 0.9rem; color: #475569; line-height: 1.5;">
                <strong>Petunjuk Pengerjaan:</strong> {{ $assignment->description }}
            </div>
        </div>

        @php
            $validGrades = $grades->whereNotNull('grade');
            $avgScore = $validGrades->count() > 0 ? round($validGrades->avg('grade'), 1) : '-';
        @endphp
        <div style="display: flex; gap: 14px;">
            <div style="background: #f8fafc; border: 1px solid var(--border); padding: 14px 20px; border-radius: 12px; text-align: center;">
                <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary);">{{ $assignment->submitted_count }} / {{ $students->count() }}</div>
                <div style="font-size: 0.78rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Siswa Dinilai</div>
            </div>
            <div style="background: #f8fafc; border: 1px solid var(--border); padding: 14px 20px; border-radius: 12px; text-align: center;">
                <div style="font-size: 1.5rem; font-weight: 800; color: #16a34a;">{{ $avgScore }}</div>
                <div style="font-size: 0.78rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Rata-rata Kelas</div>
            </div>
        </div>
    </div>
</div>

<!-- GRADING FORM -->
<div class="section-card">
    <div class="section-header" style="margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
        <div class="section-title">
            <div class="title-icon blue-icon">
                <i class="fa-solid fa-list-ol"></i>
            </div>
            <div>
                <h2>Daftar Nilai Siswa ({{ $students->count() }} Siswa)</h2>
                <p>Masukkan perolehan nilai angka (skala 0 - 100) dan umpan balik belajar</p>
            </div>
        </div>

        <button type="button" onclick="setKkmScore(75)" style="background: #f1f5fa; border: 1px solid var(--border); color: #334155; padding: 8px 14px; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer;">
            <i class="fa-solid fa-wand-magic-sparkles"></i> Isi Nilai KKM (75) bagi yang kosong
        </button>
    </div>

    <form action="{{ route('guru.tugas.nilai', $assignment->id) }}" method="POST">
        @csrf

        <div style="overflow-x: auto; border: 1px solid var(--border); border-radius: 12px; margin-bottom: 24px;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 2px solid var(--border);">
                        <th style="padding: 12px 16px; color: var(--muted); font-weight: 700; width: 50px;">No</th>
                        <th style="padding: 12px 16px; color: var(--muted); font-weight: 700; width: 130px;">NISN</th>
                        <th style="padding: 12px 16px; color: var(--muted); font-weight: 700; width: 220px;">Nama Siswa</th>
                        <th style="padding: 12px 16px; color: var(--muted); font-weight: 700; width: 140px;">Nilai (0 - 100)</th>
                        <th style="padding: 12px 16px; color: var(--muted); font-weight: 700;">Catatan / Feedback Guru</th>
                        <th style="padding: 12px 16px; color: var(--muted); font-weight: 700; width: 120px; text-align: center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $index => $student)
                    @php
                        $gradeObj = $grades[$student->id] ?? null;
                        $gradeVal = $gradeObj ? $gradeObj->grade : '';
                        $feedbackVal = $gradeObj ? $gradeObj->feedback : '';
                        $isGraded = ($gradeVal !== '' && $gradeVal !== null);
                    @endphp
                    <tr style="border-bottom: 1px solid var(--border); background: {{ $index % 2 === 0 ? '#ffffff' : '#fcfcfd' }};">
                        <td style="padding: 12px 16px; font-weight: 700; color: var(--muted);">{{ $index + 1 }}</td>
                        <td style="padding: 12px 16px; font-family: monospace; color: var(--text);">{{ $student->nisn }}</td>
                        <td style="padding: 12px 16px; font-weight: 700; color: var(--text);">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-user" style="color: {{ $student->gender == 'L' ? '#2563eb' : '#ec4899' }}; font-size: 0.85rem;"></i>
                                {{ $student->name }}
                            </div>
                        </td>
                        <td style="padding: 12px 16px;">
                            <input 
                                type="number" 
                                min="0" 
                                max="100" 
                                name="grades[{{ $student->id }}]" 
                                value="{{ $gradeVal }}"
                                placeholder="0 - 100"
                                class="grade-input"
                                style="width: 100px; padding: 8px 12px; border: 1px solid {{ $isGraded ? '#16a34a' : '#cbd5e1' }}; border-radius: 8px; font-weight: 700; font-size: 0.95rem; text-align: center; outline: none; background: {{ $isGraded ? '#f0fdf4' : '#ffffff' }};"
                            >
                        </td>
                        <td style="padding: 12px 16px;">
                            <input 
                                type="text" 
                                name="feedbacks[{{ $student->id }}]" 
                                value="{{ $feedbackVal }}"
                                placeholder="Komentar pembinaan belajar..."
                                style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; outline: none; box-sizing: border-box;"
                            >
                        </td>
                        <td style="padding: 12px 16px; text-align: center;">
                            @if($isGraded)
                                <span style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 15px; font-size: 0.78rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-check"></i> Dinilai
                                </span>
                            @else
                                <span style="background: #f1f5f9; color: #64748b; padding: 4px 10px; border-radius: 15px; font-size: 0.78rem; font-weight: 600;">
                                    Belum
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding: 30px; text-align: center; color: var(--muted);">
                            Tidak ada siswa terdaftar pada kelas ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="display: flex; justify-content: flex-end; align-items: center; gap: 12px;">
            <a href="{{ route('guru.tugas') }}" style="padding: 12px 20px; border: 1px solid #cbd5e1; background: #f8fafc; color: #475569; border-radius: 9px; font-weight: 700; font-size: 13px; text-decoration: none;">
                Kembali
            </a>
            <button type="submit" style="background: #16a34a; color: white; border: none; padding: 12px 28px; border-radius: 9px; font-weight: 700; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.25);">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Rekap Nilai Tugas
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function setKkmScore(val) {
        const inputs = document.querySelectorAll('.grade-input');
        inputs.forEach(inp => {
            if (!inp.value || inp.value === '') {
                inp.value = val;
                inp.style.borderColor = '#16a34a';
                inp.style.backgroundColor = '#f0fdf4';
            }
        });
    }
</script>
@endsection
