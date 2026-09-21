@extends('layouts.guru')

@section('title', 'Kelas Saya & Presensi - ' . ($settings['school_name'] ?? 'SD NEGERI LAMA'))

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
        <i class="fa-solid fa-circle-exclamation"></i> Terjadi kesalahan input:
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
            <i class="fa-solid fa-users-rectangle"></i> Kelas Saya & Presensi
        </h1>
        <p>
            Informasi kelas, jadwal mengajar, dan pencatatan presensi harian peserta didik oleh {{ Auth::user()->name }} pada Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}.
        </p>
    </div>
    <div class="teacher-illustration">
        <div class="teacher">
            <div class="teacher-head"></div>
            <div class="teacher-body"></div>
        </div>
        <div class="board">
            <span>{{ count($classes) }} Rombel</span>
            <small>TA {{ date('Y') }}/{{ date('Y') + 1 }}</small>
        </div>
    </div>
</div>

<!-- STATS -->
<div class="stats" style="margin-bottom: 30px;">
    <div class="stat-card blue">
        <div class="stat-icon"><i class="bi bi-easel2-fill"></i></div>
        <h2>{{ count($classes) }}</h2>
        <p>Kelas Diampu</p>
        <span style="font-size: 11px; color: var(--muted);"><i class="bi bi-check-circle-fill"></i> Aktif Semester Ini</span>
    </div>
    <div class="stat-card green">
        <div class="stat-icon"><i class="bi bi-mortarboard-fill"></i></div>
        <h2>{{ $totalStudents }}</h2>
        <p>Total Siswa Terdaftar</p>
        <span style="font-size: 11px; color: var(--muted);"><i class="bi bi-people-fill"></i> Seluruh Kelas</span>
    </div>
    <div class="stat-card purple">
        <div class="stat-icon"><i class="bi bi-calendar-check-fill"></i></div>
        <h2>{{ $presentPercentage }}%</h2>
        <p>Tingkat Kehadiran</p>
        <span style="font-size: 11px; color: var(--muted);"><i class="bi bi-calendar-day"></i> {{ $selectedClass }} ({{ date('d M Y', strtotime($date)) }})</span>
    </div>
    <div class="stat-card orange">
        <div class="stat-icon"><i class="bi bi-star-fill"></i></div>
        <h2>{{ Auth::user()->subject ?: 'Wali Kelas' }}</h2>
        <p>Mata Pelajaran Utama</p>
        <span style="font-size: 11px; color: var(--muted);"><i class="bi bi-award-fill"></i> Kurikulum Merdeka</span>
    </div>
</div>

<!-- CLASS CARDS -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; margin-bottom: 30px;">
    @foreach($classes as $class)
    @php
        $isSelected = ($class['name'] === $selectedClass);
    @endphp
    <div class="section-card" style="display: flex; flex-direction: column; justify-content: space-between; {{ $isSelected ? 'border: 2px solid var(--primary); box-shadow: 0 6px 20px rgba(37, 99, 235, 0.12);' : '' }}">
        <div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div class="class-icon {{ $class['badge_color'] }}" style="width: 46px; height: 46px; font-size: 1.1rem; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 800;">
                        {{ $class['badge'] }}
                    </div>
                    <div>
                        <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--text); margin-bottom: 2px;">{{ $class['name'] }}</h3>
                        <span style="font-size: 0.85rem; color: var(--muted);"><i class="fa-solid fa-user-tie"></i> Wali: {{ $class['homeroom'] }}</span>
                    </div>
                </div>
                <span style="background: #e0f2fe; color: #0284c7; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                    {{ $class['students_count'] }} Siswa
                </span>
            </div>

            <div style="background: var(--background); padding: 14px 16px; border-radius: 10px; margin-bottom: 16px; display: flex; flex-direction: column; gap: 8px; font-size: 0.88rem;">
                <div style="display: flex; align-items: center; gap: 10px; color: var(--text);">
                    <i class="fa-solid fa-calendar-days" style="color: var(--primary); width: 16px;"></i>
                    <span><strong>Jadwal:</strong> {{ $class['schedule'] }}</span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; color: var(--text);">
                    <i class="fa-solid fa-door-open" style="color: var(--primary); width: 16px;"></i>
                    <span><strong>Ruangan:</strong> {{ $class['room'] }}</span>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 10px; border-top: 1px solid var(--border); padding-top: 15px; margin-top: 5px;">
            <a href="{{ route('guru.kelas', ['class' => $class['name'], 'date' => $date]) }}" class="menu-item" style="flex: 1; height: 38px; justify-content: center; background: {{ $isSelected ? 'var(--primary)' : '#f1f5fa' }}; color: {{ $isSelected ? '#fff' : '#334155' }}; font-size: 12px; font-weight: 700; border-radius: 8px; text-decoration: none;">
                <i class="fa-solid fa-clipboard-user"></i> {{ $isSelected ? 'Kelas Dipilih' : 'Presensi Kelas' }}
            </a>
            <a href="{{ route('guru.tugas') }}" class="menu-item" style="height: 38px; padding: 0 12px; justify-content: center; background: #f8fafc; border: 1px solid var(--border); color: #334155; font-size: 12px; font-weight: 700; border-radius: 8px; text-decoration: none;" title="Tugas">
                <i class="fa-solid fa-clipboard-list"></i>
            </a>
            <a href="{{ route('guru.materi', ['class' => $class['name']]) }}" class="menu-item" style="height: 38px; padding: 0 12px; justify-content: center; background: #f8fafc; border: 1px solid var(--border); color: #334155; font-size: 12px; font-weight: 700; border-radius: 8px; text-decoration: none;" title="Materi">
                <i class="fa-solid fa-book"></i>
            </a>
        </div>
    </div>
    @endforeach
</div>

<!-- PRESENSI DAN DAFTAR SISWA SECTION -->
<div class="section-card" id="presensi-box">
    <div class="section-header" style="margin-bottom: 22px; flex-wrap: wrap; gap: 15px;">
        <div class="section-title">
            <div class="title-icon green-icon">
                <i class="fa-solid fa-clipboard-user"></i>
            </div>
            <div>
                <h2>Presensi Harian: {{ $selectedClass }}</h2>
                <p>Input kehadiran peserta didik tanggal {{ date('d F Y', strtotime($date)) }}</p>
            </div>
        </div>

        <!-- FILTER TANGGAL & KELAS -->
        <form action="{{ route('guru.kelas') }}" method="GET" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <input type="hidden" name="class" value="{{ $selectedClass }}">
            <div style="display: flex; align-items: center; background: var(--background); border: 1px solid var(--border); border-radius: 8px; padding: 4px 10px;">
                <i class="fa-regular fa-calendar" style="color: var(--primary); margin-right: 8px;"></i>
                <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()" style="border: none; background: transparent; outline: none; font-size: 0.88rem; font-weight: 600; color: var(--text);">
            </div>
            <noscript>
                <button type="submit" style="padding: 6px 12px; background: var(--primary); color: #fff; border: none; border-radius: 6px; font-size: 12px; font-weight: 700; cursor: pointer;">Ganti</button>
            </noscript>
        </form>
    </div>

    <!-- TABS PILIHAN KELAS -->
    <div style="display: flex; gap: 8px; margin-bottom: 20px; border-bottom: 1px solid var(--border); padding-bottom: 12px; overflow-x: auto;">
        @foreach($availableClasses as $cls)
            <a href="{{ route('guru.kelas', ['class' => $cls, 'date' => $date]) }}" style="padding: 8px 18px; border-radius: 20px; font-size: 0.88rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; {{ $cls === $selectedClass ? 'background: var(--primary); color: #ffffff;' : 'background: #f1f5fa; color: #475569;' }}">
                <i class="fa-solid {{ $cls === $selectedClass ? 'fa-circle-check' : 'fa-chalkboard' }}"></i>
                {{ $cls }}
            </a>
        @endforeach
    </div>

    <!-- PRESENSI FORM -->
    <form action="{{ route('guru.kelas.presensi') }}" method="POST">
        @csrf
        <input type="hidden" name="class_name" value="{{ $selectedClass }}">
        <input type="hidden" name="date" value="{{ $date }}">

        <!-- QUICK BUTTONS -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
            <div style="font-size: 0.88rem; color: var(--muted);">
                Total Siswa: <strong>{{ $students->count() }} orang</strong> di {{ $selectedClass }}
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="button" onclick="setAllAttendance('Hadir')" style="padding: 6px 14px; background: #dcfce7; color: #166534; border: 1px solid #86efac; border-radius: 6px; font-size: 12px; font-weight: 700; cursor: pointer;">
                    <i class="fa-solid fa-check-double"></i> Set Semua Hadir
                </button>
                <button type="button" onclick="setAllAttendance('Izin')" style="padding: 6px 14px; background: #e0f2fe; color: #0369a1; border: 1px solid #7dd3fc; border-radius: 6px; font-size: 12px; font-weight: 700; cursor: pointer;">
                    Set Semua Izin
                </button>
            </div>
        </div>

        <div style="overflow-x: auto; border: 1px solid var(--border); border-radius: 12px; margin-bottom: 20px;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 2px solid var(--border);">
                        <th style="padding: 12px 16px; color: var(--muted); font-weight: 700; width: 50px;">No</th>
                        <th style="padding: 12px 16px; color: var(--muted); font-weight: 700; width: 140px;">NISN</th>
                        <th style="padding: 12px 16px; color: var(--muted); font-weight: 700;">Nama Lengkap Siswa</th>
                        <th style="padding: 12px 16px; color: var(--muted); font-weight: 700; width: 60px; text-align: center;">L/P</th>
                        <th style="padding: 12px 16px; color: var(--muted); font-weight: 700; min-width: 320px;">Status Kehadiran Hari Ini</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $index => $student)
                    @php
                        $currStatus = $attendances[$student->id] ?? 'Hadir';
                    @endphp
                    <tr style="border-bottom: 1px solid var(--border); background: {{ $index % 2 === 0 ? '#ffffff' : '#fcfcfd' }};">
                        <td style="padding: 12px 16px; font-weight: 700; color: var(--muted);">{{ $index + 1 }}</td>
                        <td style="padding: 12px 16px; font-family: monospace; font-size: 0.92rem; color: var(--text);">{{ $student->nisn }}</td>
                        <td style="padding: 12px 16px; font-weight: 700; color: var(--text);">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-user" style="color: {{ $student->gender == 'L' ? '#2563eb' : '#ec4899' }}; font-size: 0.85rem;"></i>
                                {{ $student->name }}
                            </div>
                        </td>
                        <td style="padding: 12px 16px; text-align: center; font-weight: 700; color: {{ $student->gender == 'L' ? '#2563eb' : '#ec4899' }};">
                            {{ $student->gender }}
                        </td>
                        <td style="padding: 12px 16px;">
                            <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
                                <label style="display: inline-flex; align-items: center; gap: 6px; cursor: pointer; font-weight: 600; font-size: 0.85rem; color: #166534;">
                                    <input type="radio" name="attendance[{{ $student->id }}]" value="Hadir" {{ $currStatus === 'Hadir' ? 'checked' : '' }}>
                                    <span>Hadir</span>
                                </label>
                                <label style="display: inline-flex; align-items: center; gap: 6px; cursor: pointer; font-weight: 600; font-size: 0.85rem; color: #b45309;">
                                    <input type="radio" name="attendance[{{ $student->id }}]" value="Sakit" {{ $currStatus === 'Sakit' ? 'checked' : '' }}>
                                    <span>Sakit</span>
                                </label>
                                <label style="display: inline-flex; align-items: center; gap: 6px; cursor: pointer; font-weight: 600; font-size: 0.85rem; color: #0369a1;">
                                    <input type="radio" name="attendance[{{ $student->id }}]" value="Izin" {{ $currStatus === 'Izin' ? 'checked' : '' }}>
                                    <span>Izin</span>
                                </label>
                                <label style="display: inline-flex; align-items: center; gap: 6px; cursor: pointer; font-weight: 600; font-size: 0.85rem; color: #b91c1c;">
                                    <input type="radio" name="attendance[{{ $student->id }}]" value="Alpa" {{ $currStatus === 'Alpa' ? 'checked' : '' }}>
                                    <span>Alpa</span>
                                </label>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 30px; text-align: center; color: var(--muted);">
                            <i class="fa-solid fa-user-slash" style="font-size: 2rem; margin-bottom: 8px; display: block;"></i>
                            Belum ada data siswa untuk kelas ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="display: flex; justify-content: flex-end; align-items: center; gap: 12px;">
            <button type="submit" style="background: #16a34a; color: white; border: none; padding: 12px 26px; border-radius: 9px; font-weight: 700; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.25);">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Presensi {{ $selectedClass }}
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function setAllAttendance(status) {
        const radios = document.querySelectorAll(`input[type="radio"][value="${status}"]`);
        radios.forEach(r => r.checked = true);
    }
</script>
@endsection
