<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolSetting;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    private function getSettings(): array
    {
        return SchoolSetting::pluck('value', 'key')->toArray();
    }

    /**
     * Beranda Dashboard Guru
     */
    public function dashboard()
    {
        $settings = $this->getSettings();
        $user = Auth::user();

        return view('guru.dashboard', compact('settings', 'user'));
    }

    /**
     * Halaman Kelas Saya
     */
    public function kelas()
    {
        $settings = $this->getSettings();
        $user = Auth::user();

        $classes = [
            [
                'id' => 1,
                'name' => 'Kelas 4A',
                'badge' => 'IV',
                'badge_color' => 'cyan',
                'students_count' => 28,
                'homeroom' => 'Siti Rahma, S.Pd',
                'schedule' => 'Senin & Rabu (08:00 - 09:30)',
                'room' => 'Ruang 102 (Lantai 1)',
            ],
            [
                'id' => 2,
                'name' => 'Kelas 5A',
                'badge' => 'V',
                'badge_color' => 'purple',
                'students_count' => 30,
                'homeroom' => $user->name,
                'schedule' => 'Selasa & Kamis (09:45 - 11:15)',
                'room' => 'Ruang 201 (Lantai 2)',
            ],
            [
                'id' => 3,
                'name' => 'Kelas 6B',
                'badge' => 'VI',
                'badge_color' => 'orange',
                'students_count' => 26,
                'homeroom' => 'Ahmad Syahrir, S.Pd',
                'schedule' => 'Jumat (08:00 - 10:00)',
                'room' => 'Ruang 303 (Lantai 3)',
            ],
        ];

        return view('guru.kelas', compact('settings', 'user', 'classes'));
    }

    /**
     * Halaman Materi Pembelajaran
     */
    public function materi()
    {
        $settings = $this->getSettings();
        $user = Auth::user();

        $materials = [
            [
                'id' => 1,
                'title' => 'Modul Tematik & Karakter Siswa',
                'subject' => $user->subject ?: 'Tematik Umum',
                'class' => 'Kelas V',
                'type' => 'PDF Dokumen',
                'size' => '2.4 MB',
                'downloads' => 45,
                'date' => '18 Sep 2026',
                'icon' => 'fa-solid fa-file-pdf',
                'color' => '#ef4444'
            ],
            [
                'id' => 2,
                'title' => 'Latihan Soal & Ringkasan Bab 3',
                'subject' => $user->subject ?: 'Matematika',
                'class' => 'Kelas IV',
                'type' => 'DOCX Lembar Kerja',
                'size' => '1.1 MB',
                'downloads' => 38,
                'date' => '15 Sep 2026',
                'icon' => 'fa-solid fa-file-word',
                'color' => '#2563eb'
            ],
            [
                'id' => 3,
                'title' => 'Panduan Evaluasi & Kisi-Kisi Ujian',
                'subject' => $user->subject ?: 'Kurikulum Merdeka',
                'class' => 'Kelas VI',
                'type' => 'PDF Buku Saku',
                'size' => '3.5 MB',
                'downloads' => 52,
                'date' => '12 Sep 2026',
                'icon' => 'fa-solid fa-file-powerpoint',
                'color' => '#ea580c'
            ],
            [
                'id' => 4,
                'title' => 'Lembar Kerja Eksperimen Sains',
                'subject' => 'Ilmu Pengetahuan Alam',
                'class' => 'Kelas V',
                'type' => 'PDF Modul Praktikum',
                'size' => '1.8 MB',
                'downloads' => 29,
                'date' => '08 Sep 2026',
                'icon' => 'fa-solid fa-flask',
                'color' => '#10b981'
            ],
        ];

        return view('guru.materi', compact('settings', 'user', 'materials'));
    }

    /**
     * Halaman Video Edukasi
     */
    public function video()
    {
        $settings = $this->getSettings();
        $user = Auth::user();

        $videos = [
            [
                'id' => 1,
                'title' => 'Konsep Dasar & Rumus Praktis ' . ($user->subject ?: 'Matematika'),
                'desc' => 'Membahas pemahaman konsep dasar, visualisasi rumus, dan contoh latihan interaktif.',
                'subject' => $user->subject ?: 'Matematika',
                'class' => 'Kelas V',
                'duration' => '10:24',
                'views' => 142,
                'date' => '17 Sep 2026',
            ],
            [
                'id' => 2,
                'title' => 'Eksperimen Sifat-Sifat Cahaya & Pembiasan',
                'desc' => 'Video demonstrasi percobaan ilmiah sederhana menggunakan alat-alat di sekitar rumah.',
                'subject' => 'IPA',
                'class' => 'Kelas IV',
                'duration' => '08:45',
                'views' => 98,
                'date' => '14 Sep 2026',
            ],
            [
                'id' => 3,
                'title' => 'Literasi Budaya & Nilai Pancasila',
                'desc' => 'Animasi edukatif tentang sikap toleransi, gotong royong, dan cinta tanah air.',
                'subject' => 'PPKn',
                'class' => 'Kelas VI',
                'duration' => '12:15',
                'views' => 186,
                'date' => '10 Sep 2026',
            ],
        ];

        return view('guru.video', compact('settings', 'user', 'videos'));
    }

    /**
     * Halaman Tugas & Penilaian
     */
    public function tugas()
    {
        $settings = $this->getSettings();
        $user = Auth::user();

        $assignments = [
            [
                'id' => 1,
                'title' => 'Tugas Harian: Analisis Soal Cerita Pecahan',
                'subject' => $user->subject ?: 'Matematika',
                'class' => 'Kelas 5A',
                'deadline' => '22 Sep 2026, 23:59',
                'submitted' => 26,
                'total' => 30,
                'status' => 'Aktif',
                'status_color' => 'green'
            ],
            [
                'id' => 2,
                'title' => 'Latihan Mandiri: Pengamatan Ekosistem Lingkungan',
                'subject' => 'IPA',
                'class' => 'Kelas 4A',
                'deadline' => '24 Sep 2026, 17:00',
                'submitted' => 19,
                'total' => 28,
                'status' => 'Aktif',
                'status_color' => 'green'
            ],
            [
                'id' => 3,
                'title' => 'Ulangan Harian Bab 2: Perkalian & Pembagian',
                'subject' => $user->subject ?: 'Matematika',
                'class' => 'Kelas 6B',
                'deadline' => '15 Sep 2026, 12:00',
                'submitted' => 26,
                'total' => 26,
                'status' => 'Selesai Dinilai',
                'status_color' => 'blue'
            ],
        ];

        return view('guru.tugas', compact('settings', 'user', 'assignments'));
    }

    /**
     * Halaman Kalender Akademik
     */
    public function kalender()
    {
        $settings = $this->getSettings();
        $user = Auth::user();

        $events = [
            [
                'date' => '25 September 2026',
                'title' => 'Penilaian Tengah Semester (PTS) Ganjil',
                'type' => 'Ujian',
                'badge_color' => '#dc2626',
                'desc' => 'Pelaksanaan evaluasi pembelajaran tengah semester untuk seluruh jenjang kelas 1-6.'
            ],
            [
                'date' => '05 Oktober 2026',
                'title' => 'Rapat Pleno Dewan Guru & Evaluasi Kurikulum Merdeka',
                'type' => 'Rapat Guru',
                'badge_color' => '#2563eb',
                'desc' => 'Pembahasan perkembangan capaian pembelajaran dan persiapan projek P5 di ruang guru.'
            ],
            [
                'date' => '15 Oktober 2026',
                'title' => 'Pentas Seni & Gelar Karya P5 Siswa',
                'type' => 'Kegiatan',
                'badge_color' => '#16a34a',
                'desc' => 'Unjuk bakat dan pameran hasil karya siswa hasil pembelajaran tematik dan kearifan lokal.'
            ],
            [
                'date' => '28 Oktober 2026',
                'title' => 'Upacara Peringatan Hari Sumpah Pemuda',
                'type' => 'Upacara',
                'badge_color' => '#d97706',
                'desc' => 'Upacara bendera gabungan guru dan seluruh siswa di lapangan utama sekolah.'
            ],
        ];

        return view('guru.kalender', compact('settings', 'user', 'events'));
    }

    /**
     * Halaman Pengumuman Guru
     */
    public function pengumuman()
    {
        $settings = $this->getSettings();
        $user = Auth::user();
        $announcements = Announcement::active()->latest('published_at')->paginate(10);

        return view('guru.pengumuman', compact('settings', 'user', 'announcements'));
    }
}
