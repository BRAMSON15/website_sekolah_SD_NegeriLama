<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::create('/', 'GET')
);

echo "HTTP Status: " . $response->getStatusCode() . "\n";
$html = $response->getContent();

$checks = [
    'mobileNavToggle' => strpos($html, 'mobileNavToggle') !== false,
    'mobileNavDropdown' => strpos($html, 'mobileNavDropdown') !== false,
    'mobileNavOverlay' => strpos($html, 'mobileNavOverlay') !== false,
    'Beranda Link' => strpos($html, 'Beranda') !== false,
    'PPDB Online Link' => strpos($html, 'PPDB Online') !== false,
    'Fasilitas Link' => strpos($html, 'Fasilitas') !== false,
];

foreach ($checks as $name => $passed) {
    echo "Check [{$name}]: " . ($passed ? "PASSED" : "FAILED") . "\n";
}
