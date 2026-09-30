<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use App\Services\KepalaSekolahService;
use App\Services\SiswaService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;

class ServicesTest extends TestCase
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

    public function test_kepala_sekolah_service_provides_all_monitoring_datasets(): void
    {
        $service = app(KepalaSekolahService::class);
        $kepsek = User::whereIn('role', ['kepala_sekolah', 'kepsek'])->first();

        // 1. Dashboard Data
        $dashboardData = $service->getDashboardData($kepsek);
        $this->assertArrayHasKey('totalGuru', $dashboardData);
        $this->assertArrayHasKey('totalSiswa', $dashboardData);
        $this->assertArrayHasKey('totalVideo', $dashboardData);
        $this->assertArrayHasKey('totalMateri', $dashboardData);
        $this->assertArrayHasKey('teachers', $dashboardData);

        // 2. Monitoring Guru
        $request = new Request();
        $guruData = $service->getMonitoringGuruData($request);
        $this->assertArrayHasKey('teachers', $guruData);
        $this->assertArrayHasKey('totalTeachers', $guruData);

        // 3. Monitoring Pembelajaran
        $pembelajaranData = $service->getMonitoringPembelajaranData($request);
        $this->assertArrayHasKey('videos', $pembelajaranData);
        $this->assertArrayHasKey('materials', $pembelajaranData);
        $this->assertArrayHasKey('totalCombined', $pembelajaranData);

        // 4. Monitoring PPDB
        $ppdbData = $service->getMonitoringPpdbData($request);
        $this->assertArrayHasKey('registrations', $ppdbData);
        $this->assertArrayHasKey('totalAll', $ppdbData);

        // 5. Monitoring Sistem
        $sistemData = $service->getMonitoringSistemData();
        $this->assertArrayHasKey('stats', $sistemData);
        $this->assertArrayHasKey('serverInfo', $sistemData);
    }

    public function test_siswa_service_provides_beranda_data_and_authenticates_nisn(): void
    {
        $service = app(SiswaService::class);
        $student = Student::first();
        $this->assertNotNull($student);

        // 1. Get Beranda Data
        $request = Request::create('/siswa/beranda', 'GET');
        $berandaData = $service->getBerandaData($request, null);
        $this->assertArrayHasKey('videos', $berandaData);
        $this->assertArrayHasKey('materials', $berandaData);
        $this->assertArrayHasKey('totalCombinedCount', $berandaData);

        // 2. Authenticate NISN
        $authenticatedStudent = $service->authenticateByNisn($student->nisn, $request);
        $this->assertNotNull($authenticatedStudent);
        $this->assertEquals($student->id, $authenticatedStudent->id);
        $this->assertAuthenticated();
        $this->assertEquals('siswa', auth()->user()->role);

        // 3. Invalid NISN
        $invalid = $service->authenticateByNisn('999999999999', $request);
        $this->assertNull($invalid);
    }
}
