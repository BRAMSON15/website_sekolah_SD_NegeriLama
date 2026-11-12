<?php

echo "PPDB Activity Seeder\n";

require "vendor/autoload.php";
$app = require_once "bootstrap/app.php";
$app->make("Illuminate\Contracts\Console\Kernel")->bootstrap();

$registration = \App\Models\PpdbRegistration::first();

if (!$registration) {
    echo "No registrations found\n";
    exit;
}

$activities = [
    [
        "activity_type" => "registration_created",
        "description" => "Registrasi baru dari " . $registration->parent_name,
        "metadata" => ["student_name" => $registration->student_name],
    ],
    [
        "activity_type" => "file_uploaded",
        "description" => "File Kartu Keluarga diunggah",
        "metadata" => ["file_type" => "supporting_file_kk"],
    ],
    [
        "activity_type" => "notes_added",
        "description" => "Catatan: Data lengkap dan valid",
        "metadata" => ["notes" => "Data lengkap dan valid"],
    ],
    [
        "activity_type" => "status_changed",
        "description" => "Status berubah dari pending menjadi diterima",
        "metadata" => ["status_from" => "pending", "status_to" => "diterima"],
    ],
    [
        "activity_type" => "registration_verified",
        "description" => "Registrasi telah diverifikasi",
        "metadata" => ["verified_by" => "admin"],
    ],
];

foreach ($activities as $i => $activity) {
    \App\Models\Monitoring\PpdbActivity::create([
        "registration_id" => $registration->id,
        "user_id" => 1,
        "activity_type" => $activity["activity_type"],
        "description" => $activity["description"],
        "metadata" => $activity["metadata"],
        "created_at" => now()->subMinutes(45 - ($i * 10)),
    ]);
}

echo "Added " . count($activities) . " activities\n";
