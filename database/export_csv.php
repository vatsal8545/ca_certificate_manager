<?php

$host = '127.0.0.1';
$db   = 'ca_certificate_manager';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host={$host};dbname={$db};charset={$charset}";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    die('Database connection failed: ' . $e->getMessage());
}

$exportDir = __DIR__ . '/../exports';
if (!is_dir($exportDir)) {
    mkdir($exportDir, 0777, true);
}

$filename = 'ca_clients_export.csv';
$filePath = $exportDir . '/' . $filename;

$fp = fopen($filePath, 'w');

fputcsv($fp, ['id', 'client_name', 'status', 'pan_number', 'gst_number', 'financial_year', 'amount', 'created_at']);

$stmt = $pdo->query(
    "SELECT c.id, c.name AS client_name, c.status, c.pan_number, c.gst_number, cf.financial_year, cf.amount, c.created_at
     FROM clients c
     LEFT JOIN client_financials cf ON cf.client_id = c.id
     ORDER BY c.id, cf.financial_year"
);

while ($row = $stmt->fetch()) {
    fputcsv($fp, [
        $row['id'],
        $row['client_name'],
        $row['status'],
        $row['pan_number'],
        $row['gst_number'],
        $row['financial_year'] ?? '',
        $row['amount'] ?? '',
        $row['created_at']
    ]);
}

fclose($fp);

header('Content-Type: text/plain; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
readfile($filePath);
exit;
