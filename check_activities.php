<?php
$host = "127.0.0.1";
$db = "dbnegerilama";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);

$result = $conn->query("SELECT COUNT(*) as count FROM ppdb_activities");
$row = $result->fetch_assoc();
echo "Total activities: " . $row["count"] . "\n";

$activities = $conn->query("SELECT * FROM ppdb_activities ORDER BY created_at DESC LIMIT 5");
echo "\nRecent activities:\n";
while ($row = $activities->fetch_assoc()) {
    echo "- " . $row["activity_type"] . ": " . $row["description"] . " (" . $row["created_at"] . ")\n";
}

$conn->close();
?>