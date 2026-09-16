<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;
use App\Models\SchoolSetting;
use App\Models\Feature;
use Illuminate\Support\Str;

class HomeSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed School Settings
        $settings = [
            'school_name' => 'SD NEGERI LAMA',
            'school_tagline' => 'UNGGUL & BERKARAKTER',
            'phone' => '(021) 555-0192',
            'email' => 'info@sdnegerilama.sch.id',
            'address' => 'Jl. Pendidikan No. 45, Indonesia',
            'facebook' => 'https://facebook.com',
            'instagram' => 'https://instagram.com',
            'youtube' => 'https://youtube.com',
            'hero_badge' => 'Sekolah Penggerak & Akreditasi A',
            'hero_title' => 'Mewujudkan Generasi Cerdas, Kreatif & Berkarakter',
            'hero_description' => 'Selamat datang di portal resmi SD Negeri Lama. Kami berkomitmen memberikan pendidikan berkualitas tinggi berbasis teknologi dan nilai-nilai luhur bangsa.',
            'stat_kelulusan' => '100%',
            'stat_akreditasi' => 'A',
            'stat_guru' => '25+',
            'stat_eskul' => '15+',
            'principal_name' => 'Drs. H. Ahmad Dahlan, M.Pd.',
            'principal_title' => 'Kepala Sekolah SD Negeri Lama',
            'principal_message' => 'Selamat datang di SD Negeri Lama. Kami senantiasa berkomitmen untuk menciptakan lingkungan belajar yang aman, nyaman, dan menginspirasi bagi seluruh peserta didik. Dengan dukungan tenaga pendidik yang profesional serta sarana pembelajaran modern, kami siap mencetak generasi masa depan yang unggul dan berdaya saing.',
        ];

        foreach ($settings as $key => $value) {
            SchoolSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // 2. Seed Features
        Feature::truncate();
        Feature::create([
            'title' => 'Kelas Digital',
            'description' => 'Pembelajaran interaktif berbasis teknologi modern.',
            'icon' => 'fa-solid fa-laptop-code',
            'icon_color_class' => 'icon-blue',
            'order' => 1,
        ]);

        Feature::create([
            'title' => 'Kurikulum Merdeka',
            'description' => 'Pengembangan potensi siswa secara optimal dan fleksibel.',
            'icon' => 'fa-solid fa-book-bookmark',
            'icon_color_class' => 'icon-green',
            'order' => 2,
        ]);

        Feature::create([
            'title' => 'Prestasi Tinggi',
            'description' => 'Berbagai capaian akademik & non-akademik tingkat nasional.',
            'icon' => 'fa-solid fa-trophy',
            'icon_color_class' => 'icon-purple',
            'order' => 3,
        ]);

        Feature::create([
            'title' => 'Pendidikan Karakter',
            'description' => 'Membentuk akhlak mulia dan kepribadian siswa yang tangguh.',
            'icon' => 'fa-solid fa-shield-heart',
            'icon_color_class' => 'icon-orange',
            'order' => 4,
        ]);

        // 3. Seed Announcements
        Announcement::truncate();
        Announcement::create([
            'title' => 'Pelaksanaan Asesmen Nasional Berbasis Komputer (ANBK)',
            'slug' => Str::slug('Pelaksanaan Asesmen Nasional Berbasis Komputer (ANBK)'),
            'content' => 'Diberitahukan kepada seluruh siswa kelas 5 bahwa pelaksanaan ANBK akan diselenggarakan pekan depan.',
            'published_at' => now()->subDays(2),
            'is_active' => true,
        ]);

        Announcement::create([
            'title' => 'Penerimaan Peserta Didik Baru (PPDB) Gelombang II',
            'slug' => Str::slug('Penerimaan Peserta Didik Baru (PPDB) Gelombang II'),
            'content' => 'Pendaftaran PPDB untuk calon siswa baru Gelombang II resmi dibuka hingga akhir bulan ini.',
            'published_at' => now()->subDays(5),
            'is_active' => true,
        ]);

        Announcement::create([
            'title' => 'Juara 1 Lomba Seni & Olahraga Siswa Tingkat Kabupaten',
            'slug' => Str::slug('Juara 1 Lomba Seni & Olahraga Siswa Tingkat Kabupaten'),
            'content' => 'Selamat kepada kontingen SD Negeri Lama yang berhasil meraih juara umum pada perhelatan FLS2N.',
            'published_at' => now()->subDays(12),
            'is_active' => true,
        ]);
        // 4. Seed Default Users
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@sdnegerilama.sch.id'],
            [
                'name' => 'Administrator Sekolah',
                'role' => 'admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            ]
        );

        \App\Models\User::updateOrCreate(
            ['nip' => '198507122010011002'],
            [
                'name' => 'Budi Santoso, S.Pd',
                'email' => 'budisantoso@sdnegerilama.sch.id',
                'nip' => '198507122010011002',
                'subject' => 'Matematika',
                'role' => 'guru',
                'password' => \Illuminate\Support\Facades\Hash::make('198507122010011002'),
            ]
        );

        \App\Models\User::updateOrCreate(
            ['nip' => '199003152015022001'],
            [
                'name' => 'Siti Aminah, M.Pd',
                'email' => 'sitiaminah@sdnegerilama.sch.id',
                'nip' => '199003152015022001',
                'subject' => 'Bahasa Indonesia',
                'role' => 'guru',
                'password' => \Illuminate\Support\Facades\Hash::make('199003152015022001'),
            ]
        );

        \App\Models\User::updateOrCreate(
            ['email' => 'siswa@sdnegerilama.sch.id'],
            [
                'name' => 'Andi Pratama',
                'role' => 'siswa',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            ]
        );
    }
}
