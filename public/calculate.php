<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if ($data === null) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON input']);
    exit;
}

$engine = $data['engine'] ?? 'python';
unset($data['engine']);

$engine_url = 'http://localhost:8001/calculate';

$ch = curl_init($engine_url);
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Accept: application/json'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_CONNECTTIMEOUT => 5,
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);
curl_close($ch);

if ($response === false || $http_code === 0) {
    http_response_code(503);
    echo json_encode([
        'error' => 'The calculation engine is not available. Please ensure the ' . htmlspecialchars($engine) . ' engine is running on port 8001 and try again.'
    ]);
    exit;
}

if ($http_code >= 400) {
    http_response_code($http_code);
    echo $response;
    exit;
}

echo $response;
