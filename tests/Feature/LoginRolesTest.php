<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginRolesTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'database.default' => 'mysql',
            'database.connections.mysql.database' => 'dbnegerilama',
            'database.connections.mysql.username' => env('DB_USERNAME', 'root'),
            'database.connections.mysql.password' => env('DB_PASSWORD', ''),
        ]);
        \Illuminate\Support\Facades\DB::purge('mysql');
    }

    public function test_guest_can_access_separate_login_portals_without_tabs(): void
    {
        // 1. Portal Guru (/login or /login/guru)
        $responseGuru = $this->get('/login/guru');
        $responseGuru->assertStatus(200);
        $responseGuru->assertSee('Portal Guru Pengajar');
        $responseGuru->assertSee('Nama Lengkap, NIP, atau Email Guru');
        // Pastikan tidak ada tab selector role
        $responseGuru->assertDontSee('tab-guru');
        $responseGuru->assertDontSee('tab-kepsek');
        $responseGuru->assertDontSee('tab-admin');

        // 2. Portal Kepala Sekolah (/login/kepsek)
        $responseKepsek = $this->get('/login/kepsek');
        $responseKepsek->assertStatus(200);
        $responseKepsek->assertSee('Supervisi Kepala Sekolah');
        $responseKepsek->assertSee('NIP, Email, atau Nama Kepala Sekolah');
        $responseKepsek->assertDontSee('tab-guru');
        $responseKepsek->assertDontSee('tab-kepsek');
        $responseKepsek->assertDontSee('tab-admin');

        // 3. Portal Admin (/login/admin)
        $responseAdmin = $this->get('/login/admin');
        $responseAdmin->assertStatus(200);
        $responseAdmin->assertSee('Administrator Portal');
        $responseAdmin->assertSee('Email atau Username Admin');
        $responseAdmin->assertDontSee('tab-guru');
        $responseAdmin->assertDontSee('tab-kepsek');
        $responseAdmin->assertDontSee('tab-admin');
    }

    public function test_authenticated_user_can_still_see_login_form_and_session_banner(): void
    {
        $admin = User::where('role', 'admin')->first();
        $response = $this->actingAs($admin)->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Sesi Sedang Masuk');
        $response->assertSee($admin->name);
    }

    public function test_siswa_can_access_via_nisn_on_akademik_page(): void
    {
        // 1. Cek halaman akademik memiliki form input NISN
        $response = $this->get('/akademik');
        $response->assertStatus(200);
        $response->assertSee(route('siswa.akses.nisn'), false);
        $response->assertSee('Masukkan Nomor NISN Terdaftar');

        // 2. Submit NISN yang valid
        $postResponse = $this->post('/siswa/akses-nisn', [
            'nisn' => '009123401',
        ]);

        $postResponse->assertRedirect(route('siswa.beranda'));
        $this->assertAuthenticated();
        $this->assertEquals('siswa', auth()->user()->role);
    }

    public function test_invalid_nisn_is_rejected_with_error(): void
    {
        $response = $this->post('/siswa/akses-nisn', [
            'nisn' => '999999999',
        ]);

        $response->assertSessionHas('error_nisn');
        $this->assertGuest();
    }

    public function test_guru_can_login_with_nip(): void
    {
        $response = $this->post('/login', [
            'login_type' => 'guru',
            'name' => '198507122010011002',
            'nip' => '198507122010011002',
        ]);

        $response->assertRedirect(route('guru.dashboard'));
        $this->assertAuthenticated();
        $this->assertEquals('guru', auth()->user()->role);
    }

    public function test_guru_can_login_with_name(): void
    {
        $response = $this->post('/login', [
            'login_type' => 'guru',
            'name' => 'Budi Santoso, S.Pd',
            'nip' => '198507122010011002',
        ]);

        $response->assertRedirect(route('guru.dashboard'));
        $this->assertAuthenticated();
        $this->assertEquals('guru', auth()->user()->role);
    }

    public function test_admin_can_login_with_email(): void
    {
        $response = $this->post('/login', [
            'login_type' => 'admin',
            'email' => 'admin@sdnegerilama.sch.id',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
        $this->assertEquals('admin', auth()->user()->role);
    }

    public function test_logout_redirects_to_login_with_success_message(): void
    {
        $admin = User::where('role', 'admin')->first();
        $response = $this->actingAs($admin)->post('/logout');

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_logout_via_get_request(): void
    {
        $admin = User::where('role', 'admin')->first();
        $response = $this->actingAs($admin)->get('/logout');

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_admin_dashboard_renders_successfully(): void
    {
        $admin = User::where('role', 'admin')->first();
        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
        $response->assertSee($admin->name);
    }

    public function test_guru_dashboard_renders_successfully(): void
    {
        $guru = User::where('role', 'guru')->first();
        $response = $this->actingAs($guru)->get('/guru/dashboard');

        $response->assertStatus(200);
        $response->assertSee($guru->name);
    }

    public function test_kepala_sekolah_can_login_with_nip(): void
    {
        $response = $this->post('/login', [
            'login_type' => 'kepala_sekolah',
            'kepsek_identifier' => '197505081999031001',
            'kepsek_password' => '197505081999031001',
        ]);

        $response->assertRedirect(route('kepsek.dashboard'));
        $this->assertAuthenticated();
        $this->assertContains(auth()->user()->role, ['kepala_sekolah', 'kepsek']);
    }

    public function test_kepala_sekolah_can_login_with_email_and_password(): void
    {
        $response = $this->post('/login', [
            'login_type' => 'kepala_sekolah',
            'kepsek_identifier' => 'kepsek@sdnegerilama.sch.id',
            'kepsek_password' => 'password123',
        ]);

        $response->assertRedirect(route('kepsek.dashboard'));
        $this->assertAuthenticated();
        $this->assertContains(auth()->user()->role, ['kepala_sekolah', 'kepsek']);
    }

    public function test_kepsek_dashboard_renders_successfully(): void
    {
        $kepsek = User::whereIn('role', ['kepala_sekolah', 'kepsek'])->first();
        $response = $this->actingAs($kepsek)->get('/kepsek/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Panel Supervisi Kepala Sekolah');
        $response->assertSee($kepsek->name);
    }

    public function test_kepsek_monitoring_subpages_render_successfully(): void
    {
        $kepsek = User::whereIn('role', ['kepala_sekolah', 'kepsek'])->first();

        // 1. Guru
        $this->actingAs($kepsek)->get('/kepsek/monitoring/guru')->assertStatus(200);
        // 2. Pembelajaran
        $this->actingAs($kepsek)->get('/kepsek/monitoring/pembelajaran')->assertStatus(200);
        // 3. PPDB
        $this->actingAs($kepsek)->get('/kepsek/monitoring/ppdb')->assertStatus(200);
        // 4. Sistem
        $this->actingAs($kepsek)->get('/kepsek/monitoring/sistem')->assertStatus(200);
    }
}
