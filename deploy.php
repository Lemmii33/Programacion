<?php
$secret = 'Aa123456'; // Igual que la que configuras en GitHub

$payload = file_get_contents('php://input');
$headers = getallheaders();
$signature = $headers['X-Hub-Signature-256'] ?? '';

$expected = 'sha256=' . hash_hmac('sha256', $payload, $secret);

if (!hash_equals($expected, $signature)) {
    http_response_code(403);
    exit('Invalid signature');
}

// Ejecuta el pull
exec('cd /var/www/html && git pull origin main 2>&1', $output, $status);
echo "Pull ejecutado:\n" . implode("\n", $output);
