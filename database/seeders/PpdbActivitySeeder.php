<?php

namespace Database\Seeders;

use App\Models\Monitoring\PpdbActivity;
use App\Models\PpdbRegistration;
use Illuminate\Database\Seeder;

class PpdbActivitySeeder extends Seeder
{
    public function run(): void
    {
        $registration = PpdbRegistration::first();

        if (!$registration) {
            return;
        }

        $activities = [
            [
                "activity_type" => PpdbActivity::TYPE_CREATED,
                "description" => "Registrasi baru dari " . $registration->parent_name,
                "metadata" => ["student_name" => $registration->student_name],
                "created_at" => now()->subMinutes(45),
            ],
            [
                "activity_type" => PpdbActivity::TYPE_FILE_UPLOADED,
                "description" => "File Kartu Keluarga diunggah",
                "metadata" => ["file_type" => "supporting_file_kk"],
                "created_at" => now()->subMinutes(40),
            ],
            [
                "activity_type" => PpdbActivity::TYPE_NOTES_ADDED,
                "description" => "Catatan: Data lengkap dan valid",
                "metadata" => ["notes" => "Data lengkap dan valid"],
                "created_at" => now()->subMinutes(20),
            ],
            [
                "activity_type" => PpdbActivity::TYPE_STATUS_CHANGED,
                "description" => "Status berubah dari pending menjadi diterima",
                "metadata" => ["status_from" => "pending", "status_to" => "diterima"],
                "created_at" => now()->subMinutes(10),
            ],
            [
                "activity_type" => PpdbActivity::TYPE_VERIFIED,
                "description" => "Registrasi telah diverifikasi",
                "metadata" => ["verified_by" => "admin"],
                "created_at" => now()->subMinutes(5),
            ],
        ];

        foreach ($activities as $activity) {
            PpdbActivity::create([
                "registration_id" => $registration->id,
                "user_id" => 1,
                "activity_type" => $activity["activity_type"],
                "description" => $activity["description"],
                "metadata" => $activity["metadata"],
                "created_at" => $activity["created_at"],
                "updated_at" => $activity["created_at"],
            ]);
        }
    }
}
