<?php
$host = "127.0.0.1";
$db = "dbnegerilama";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the first registration
$result = $conn->query("SELECT id FROM ppdb_registrations LIMIT 1");
$row = $result->fetch_assoc();

if (!$row) {
    echo "No registrations found";
    exit;
}

$reg_id = $row["id"];

// Insert test activities
$activities = [
    ["registration_created", "Registrasi baru dari orang tua", 45],
    ["file_uploaded", "File Kartu Keluarga diunggah", 40],
    ["notes_added", "Catatan: Data lengkap dan valid", 20],
    ["status_changed", "Status berubah dari pending menjadi diterima", 10],
    ["registration_verified", "Registrasi telah diverifikasi", 5],
];

foreach ($activities as $activity) {
    $type = $activity[0];
    $desc = $activity[1];
    $mins = $activity[2];
    $sql = "INSERT INTO ppdb_activities (registration_id, user_id, activity_type, description, metadata, created_at, updated_at) 
             VALUES ($reg_id, 1, \"$type\", \"$desc\", \"{}\", DATE_SUB(NOW(), INTERVAL $mins MINUTE), NOW())";
    $conn->query($sql);
}

echo "Added 5 test activities for registration ID " . $reg_id;
$conn->close();
?>