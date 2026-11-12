<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Monitoring\TeacherActivity;
use App\Models\Monitoring\TeacherPerformance;

class TeacherMonitoringSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua guru yang sudah ada
        $teachers = User::where('role', 'guru')->take(5)->get();

        $activityTypes = [
            'material_upload' => 'Guru mengunggah materi pembelajaran',
            'video_upload' => 'Guru mengunggah video edukasi',
            'assignment_create' => 'Guru membuat tugas baru',
        ];

        // Generate aktivitas untuk setiap guru
        foreach ($teachers as $teacher) {
            // Buat 3-10 aktivitas random untuk setiap guru dalam 7 hari terakhir
            $activitiesCount = rand(3, 10);

            for ($i = 0; $i < $activitiesCount; $i++) {
                $type = array_rand($activityTypes);
                $description = $activityTypes[$type];

                TeacherActivity::create([
                    'user_id' => $teacher->id,
                    'activity_type' => $type,
                    'description' => $description,
                    'related_model' => null,
                    'related_model_id' => null,
                    'metadata' => [
                        'created_by' => 'seeder',
                        'test_data' => true,
                    ],
                    'created_at' => now()->subDays(rand(0, 7))->subHours(rand(0, 23)),
                ]);
            }

            // Update performa guru berdasarkan aktivitas
            TeacherPerformance::updateOrCreateForTeacher($teacher->id);
        }

        $this->command->info('Teacher monitoring seeder completed successfully!');
    }
}
