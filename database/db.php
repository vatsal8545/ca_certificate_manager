<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$DB_CONFIG = [
    'host' => '127.0.0.1',
    'dbname' => 'ca_certificate_manager',
    'user' => 'root',
    'pass' => '',
    'charset' => 'utf8mb4',
];

$dbInitError = null;

function getDbConnection(): PDO
{
    global $DB_CONFIG;

    $dsn = 'mysql:host=' . $DB_CONFIG['host'] . ';dbname=' . $DB_CONFIG['dbname'] . ';charset=' . $DB_CONFIG['charset'];

    $pdo = new PDO($dsn, $DB_CONFIG['user'], $DB_CONFIG['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => true,
    ]);

    return $pdo;
}

function columnExists(PDO $pdo, string $table, string $column): bool
{
    $table = preg_replace('/[^a-z0-9_]/i', '', $table);
    $column = str_replace("'", "''", $column);
    $stmt = $pdo->query("SHOW COLUMNS FROM `{$table}` LIKE '{$column}'");
    return $stmt ? (bool)$stmt->fetch() : false;
}

function indexExists(PDO $pdo, string $table, string $indexName): bool
{
    $table = preg_replace('/[^a-z0-9_]/i', '', $table);
    $indexName = str_replace("'", "''", $indexName);
    $stmt = $pdo->query("SHOW INDEX FROM `{$table}` WHERE Key_name = '{$indexName}'");
    return $stmt ? (bool)$stmt->fetch() : false;
}

function isDirectDbEndpoint(): bool
{
    return basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'] ?? '');
}

function initDatabase(): void
{
    $host = '127.0.0.1';
    $user = 'root';
    $pass = '';

    $pdo = new PDO("mysql:host={$host};charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS `ca_certificate_manager` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo = getDbConnection();

    $sql = "
    CREATE TABLE IF NOT EXISTS `users` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `username` VARCHAR(100) NOT NULL,
        `password` VARCHAR(255) NOT NULL,
        `role` VARCHAR(50) NOT NULL DEFAULT 'CA',
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `uniq_username` (`username`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    CREATE TABLE IF NOT EXISTS `firm_settings` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `user_id` INT UNSIGNED DEFAULT NULL,
        `firm_name` VARCHAR(255) DEFAULT NULL,
        `frn` VARCHAR(80) DEFAULT NULL,
        `address` TEXT DEFAULT NULL,
        `city` VARCHAR(150) DEFAULT NULL,
        `state` VARCHAR(150) DEFAULT NULL,
        `phone` VARCHAR(50) DEFAULT NULL,
        `email` VARCHAR(150) DEFAULT NULL,
        `gst_number` VARCHAR(80) DEFAULT NULL,
        `pan_number` VARCHAR(80) DEFAULT NULL,
        `udin_number` VARCHAR(80) DEFAULT NULL,
        `signatory_name` VARCHAR(255) DEFAULT NULL,
        `signatory_status` VARCHAR(150) DEFAULT NULL,
        `membership_number` VARCHAR(150) DEFAULT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `uniq_user_id` (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    CREATE TABLE IF NOT EXISTS `clients` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `user_id` INT UNSIGNED NOT NULL DEFAULT 0,
        `name` VARCHAR(255) NOT NULL,
        `status` VARCHAR(80) NOT NULL,
        `pan_number` VARCHAR(80) DEFAULT NULL,
        `gst_number` VARCHAR(80) DEFAULT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `idx_user_id` (`user_id`),
        KEY `idx_pan` (`pan_number`),
        KEY `idx_status` (`status`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    CREATE TABLE IF NOT EXISTS `client_financials` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `client_id` INT UNSIGNED NOT NULL,
        `financial_year` VARCHAR(20) NOT NULL,
        `amount` DECIMAL(18,2) NOT NULL DEFAULT 0.00,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `idx_client_year` (`client_id`, `financial_year`),
        CONSTRAINT `fk_client_financials_client`
            FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    CREATE TABLE IF NOT EXISTS `certificates` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `client_id` INT UNSIGNED NOT NULL,
        `user_id` INT UNSIGNED DEFAULT NULL,
        `certificate_type` VARCHAR(150) NOT NULL,
        `certificate_date` DATE DEFAULT NULL,
        `place_of_signing` VARCHAR(150) DEFAULT NULL,
        `udin_number` VARCHAR(120) DEFAULT NULL,
        `template_style` VARCHAR(150) DEFAULT NULL,
        `pdf_path` VARCHAR(255) DEFAULT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `idx_cert_client` (`client_id`),
        KEY `idx_cert_user` (`user_id`),
        CONSTRAINT `fk_certificates_client`
            FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    CREATE TABLE IF NOT EXISTS `site_settings` (
        `id` INT UNSIGNED NOT NULL DEFAULT 1,
        `site_name` VARCHAR(255) DEFAULT NULL,
        `site_description` TEXT DEFAULT NULL,
        `contact_email` VARCHAR(150) DEFAULT NULL,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";

    $pdo->exec($sql);

    if (!columnExists($pdo, 'users', 'role')) {
        $pdo->exec("ALTER TABLE `users` ADD COLUMN `role` VARCHAR(50) NOT NULL DEFAULT 'CA' AFTER `password`");
    } else {
        $pdo->exec("ALTER TABLE `users` MODIFY `role` VARCHAR(50) NOT NULL DEFAULT 'CA'");
    }

    if (!columnExists($pdo, 'clients', 'user_id')) {
        $pdo->exec("ALTER TABLE `clients` ADD COLUMN `user_id` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `id`");
    }

    if (!columnExists($pdo, 'firm_settings', 'user_id')) {
        $pdo->exec("ALTER TABLE `firm_settings` ADD COLUMN `user_id` INT UNSIGNED DEFAULT NULL AFTER `id`");
    }

    if (!columnExists($pdo, 'firm_settings', 'frn')) {
        $pdo->exec("ALTER TABLE `firm_settings` ADD COLUMN `frn` VARCHAR(80) DEFAULT NULL AFTER `firm_name`");
    }

    if (columnExists($pdo, 'firm_settings', 'user_id')) {
        $duplicateRows = $pdo->query(
            "SELECT user_id, GROUP_CONCAT(id ORDER BY id ASC) AS ids
             FROM firm_settings
             WHERE user_id IS NOT NULL
             GROUP BY user_id
             HAVING COUNT(*) > 1"
        )->fetchAll(PDO::FETCH_ASSOC);

        foreach ($duplicateRows as $row) {
            $ids = explode(',', $row['ids']);
            $keepId = array_shift($ids);
            $deleteIds = array_map('intval', $ids);
            if ($deleteIds) {
                $pdo->exec('DELETE FROM firm_settings WHERE id IN (' . implode(',', $deleteIds) . ')');
            }
        }
    }

    if (!indexExists($pdo, 'firm_settings', 'uniq_user_id')) {
        $pdo->exec("ALTER TABLE `firm_settings` ADD UNIQUE KEY `uniq_user_id` (`user_id`)");
    }

    if (!columnExists($pdo, 'certificates', 'user_id')) {
        $pdo->exec("ALTER TABLE `certificates` ADD COLUMN `user_id` INT UNSIGNED DEFAULT NULL AFTER `client_id`");
        $pdo->exec("ALTER TABLE `certificates` ADD KEY `idx_cert_user` (`user_id`)");
    }

    $existingUsers = $pdo->query("SELECT id, username, password, role FROM `users`")->fetchAll();
    $updatePassword = $pdo->prepare("UPDATE `users` SET `password` = ? WHERE `id` = ?");
    $updateRole = $pdo->prepare("UPDATE `users` SET `role` = ? WHERE `id` = ?");
    $adminId = 0;

    foreach ($existingUsers as $row) {
        if (!password_get_info($row['password'])['algo']) {
            $updatePassword->execute([password_hash($row['password'], PASSWORD_DEFAULT), $row['id']]);
        }
        if (strtolower($row['username']) === 'admin') {
            $adminId = (int)$row['id'];
            if ($row['role'] !== 'Administrator') {
                $updateRole->execute(['Administrator', $row['id']]);
            }
        }
    }

    if ($adminId === 0) {
        $stmt = $pdo->prepare("INSERT INTO `users` (`username`, `password`, `role`) VALUES (?, ?, ?)");
        $stmt->execute(['admin', password_hash('admin123', PASSWORD_DEFAULT), 'Administrator']);
        $adminId = (int)$pdo->lastInsertId();
    }

    if ($adminId > 0) {
        if (columnExists($pdo, 'firm_settings', 'user_id')) {
            $stmt = $pdo->prepare("SELECT id FROM firm_settings WHERE user_id = ? LIMIT 1");
            $stmt->execute([$adminId]);
            $hasAdminFirm = (bool)$stmt->fetch();

            if (!$hasAdminFirm) {
                $existingFirm = $pdo->query("SELECT id FROM firm_settings WHERE user_id IS NULL ORDER BY id ASC LIMIT 1")->fetch();
                if ($existingFirm && isset($existingFirm['id'])) {
                    $stmt = $pdo->prepare("UPDATE firm_settings SET user_id = ? WHERE id = ?");
                    $stmt->execute([$adminId, (int)$existingFirm['id']]);
                }
            }
            $pdo->exec("DELETE FROM firm_settings WHERE user_id IS NULL");
        }
        if (columnExists($pdo, 'clients', 'user_id')) {
            $pdo->exec("UPDATE `clients` SET `user_id` = {$adminId} WHERE `user_id` = 0");
        }
    }
}

function jsonResponse(array $payload, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($payload);
    exit;
}

try {
    initDatabase();
} catch (Throwable $e) {
    $dbInitError = $e->getMessage();
}

$isDbEndpoint = isDirectDbEndpoint();

if ($isDbEndpoint && $dbInitError !== null) {
    jsonResponse(['success' => false, 'error' => $dbInitError], 500);
}

if ($isDbEndpoint) {
    $action = $_GET['action'] ?? '';
    $method = $_SERVER['REQUEST_METHOD'];
    $pdo = getDbConnection();

    $currentUser = $_SESSION['user'] ?? null;
    $currentUserId = isset($currentUser['id']) ? (int)$currentUser['id'] : 0;

    if (!in_array($action, ['login', 'register'], true)) {
        if (!$currentUser) {
            jsonResponse(['success' => false, 'error' => 'Unauthorized'], 401);
        }
    }

    if ($action === 'load_firm') {
        $stmt = $pdo->prepare('SELECT * FROM firm_settings WHERE user_id = ? ORDER BY id DESC LIMIT 1');
        $stmt->execute([$currentUserId]);
        $row = $stmt->fetch();
        jsonResponse(['success' => true, 'firm' => $row ?: null]);
    }

    if ($action === 'save_firm') {
        if ($method !== 'POST') {
            jsonResponse(['success' => false, 'error' => 'POST required'], 405);
        }

        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $firmName = trim((string)($input['firmName'] ?? $input['firm_name'] ?? ''));
        $frn = trim((string)($input['frn'] ?? ''));
        $signatoryName = trim((string)($input['signatoryName'] ?? $input['signatory_name'] ?? ''));
        $signatoryStatus = trim((string)($input['signatoryStatus'] ?? $input['signatory_status'] ?? 'Proprietor'));
        $membershipNumber = trim((string)($input['membershipNumber'] ?? $input['membership_number'] ?? ''));
        $udin = trim((string)($input['udin'] ?? ''));

        $rows = $pdo->prepare('SELECT id FROM firm_settings WHERE user_id = ? ORDER BY id ASC');
        $rows->execute([$currentUserId]);
        $existingRows = $rows->fetchAll();

        if ($existingRows) {
            $keepId = (int)$existingRows[0]['id'];
            $duplicateIds = array_column(array_slice($existingRows, 1), 'id');
            if (!empty($duplicateIds)) {
                $pdo->exec('DELETE FROM firm_settings WHERE id IN (' . implode(',', array_map('intval', $duplicateIds)) . ')');
            }
            $stmt = $pdo->prepare('UPDATE firm_settings SET firm_name = ?, frn = ?, signatory_name = ?, signatory_status = ?, membership_number = ?, udin_number = ? WHERE id = ?');
            $stmt->execute([$firmName, $frn, $signatoryName, $signatoryStatus, $membershipNumber, $udin, $keepId]);
        } else {
            $stmt = $pdo->prepare('INSERT INTO firm_settings (user_id, firm_name, frn, signatory_name, signatory_status, membership_number, udin_number) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$currentUserId, $firmName, $frn, $signatoryName, $signatoryStatus, $membershipNumber, $udin]);
        }

        $stmt = $pdo->prepare('SELECT * FROM firm_settings WHERE user_id = ? ORDER BY id ASC LIMIT 1');
        $stmt->execute([$currentUserId]);
        $row = $stmt->fetch();
        jsonResponse(['success' => true, 'firm' => $row]);
    }

    if ($action === 'list_clients') {
        $stmt = $pdo->prepare('SELECT c.* FROM clients c WHERE c.user_id = ? ORDER BY c.id DESC');
        $stmt->execute([$currentUserId]);
        $rows = $stmt->fetchAll();

        $clients = [];
        foreach ($rows as $c) {
            $years = $pdo->prepare('SELECT financial_year as year, amount FROM client_financials WHERE client_id = ? ORDER BY financial_year DESC');
            $years->execute([$c['id']]);
            $c['years'] = $years->fetchAll();
            $clients[] = $c;
        }
        jsonResponse(['success' => true, 'clients' => $clients]);
    }

    if ($action === 'save_client') {
        if ($method !== 'POST') {
            jsonResponse(['success' => false, 'error' => 'POST required'], 405);
        }

        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $client = $input['client'] ?? $input;
        $name = trim((string)($client['name'] ?? ''));
        $status = trim((string)($client['status'] ?? 'Proprietor'));
        $pan = trim((string)($client['pan'] ?? ''));
        $gst = trim((string)($client['gst'] ?? ''));
        $years = $client['years'] ?? [];

        if ($name === '' || $pan === '') {
            jsonResponse(['success' => false, 'error' => 'Name and PAN are required'], 400);
        }

        $clientId = isset($client['id']) && $client['id'] !== '' ? (int)$client['id'] : null;
        if ($clientId) {
            $stmt = $pdo->prepare('SELECT id FROM clients WHERE id = ? AND user_id = ? LIMIT 1');
            $stmt->execute([$clientId, $currentUserId]);
            if (!$stmt->fetch()) {
                jsonResponse(['success' => false, 'error' => 'Client not found or access denied'], 403);
            }
            $stmt = $pdo->prepare('UPDATE clients SET name = ?, status = ?, pan_number = ?, gst_number = ? WHERE id = ? AND user_id = ?');
            $stmt->execute([$name, $status, $pan, $gst, $clientId, $currentUserId]);
        } else {
            $stmt = $pdo->prepare('INSERT INTO clients (user_id, name, status, pan_number, gst_number) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$currentUserId, $name, $status, $pan, $gst]);
            $clientId = (int)$pdo->lastInsertId();
        }

        $pdo->prepare('DELETE FROM client_financials WHERE client_id = ?')->execute([$clientId]);
        $insertYear = $pdo->prepare('INSERT INTO client_financials (client_id, financial_year, amount) VALUES (?, ?, ?)');
        foreach ($years as $row) {
            $year = trim((string)($row['year'] ?? ''));
            $amount = (float)($row['amount'] ?? 0);
            if ($year !== '' && $amount >= 0) {
                $insertYear->execute([$clientId, $year, $amount]);
            }
        }

        jsonResponse(['success' => true, 'client' => ['id' => $clientId]]);
    }

    if ($action === 'delete_client') {
        $id = (int)($_POST['id'] ?? $_GET['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare('DELETE FROM clients WHERE id = ? AND user_id = ?');
            $stmt->execute([$id, $currentUserId]);
            if ($stmt->rowCount() === 0) {
                jsonResponse(['success' => false, 'error' => 'Client not found or access denied'], 403);
            }
            jsonResponse(['success' => true]);
        }
        jsonResponse(['success' => false, 'error' => 'Invalid client id'], 400);
    }

    if ($action === 'list_users') {
        if (($currentUser['role'] ?? '') !== 'Administrator') {
            jsonResponse(['success' => false, 'error' => 'Admin access required'], 403);
        }

        $rows = $pdo->query('SELECT id, username, role, created_at FROM users WHERE role != "Administrator" ORDER BY created_at DESC')->fetchAll();
        jsonResponse(['success' => true, 'users' => $rows]);
    }

    if ($action === 'load_site_settings') {
        if (($currentUser['role'] ?? '') !== 'Administrator') {
            jsonResponse(['success' => false, 'error' => 'Admin access required'], 403);
        }

        $stmt = $pdo->query('SELECT * FROM site_settings WHERE id = 1 LIMIT 1');
        $row = $stmt->fetch();
        jsonResponse(['success' => true, 'site' => $row ?: null]);
    }

    if ($action === 'save_site_settings') {
        if (($currentUser['role'] ?? '') !== 'Administrator') {
            jsonResponse(['success' => false, 'error' => 'Admin access required'], 403);
        }
        if ($method !== 'POST') {
            jsonResponse(['success' => false, 'error' => 'POST required'], 405);
        }

        $payload = json_decode(file_get_contents('php://input'), true) ?? [];
        $siteName = trim((string)($payload['site_name'] ?? $payload['siteName'] ?? ''));
        $siteDescription = trim((string)($payload['site_description'] ?? $payload['siteDescription'] ?? ''));
        $contactEmail = trim((string)($payload['contact_email'] ?? $payload['contactEmail'] ?? ''));

        $stmt = $pdo->prepare('INSERT INTO site_settings (id, site_name, site_description, contact_email) VALUES (1, ?, ?, ?) ON DUPLICATE KEY UPDATE site_name = VALUES(site_name), site_description = VALUES(site_description), contact_email = VALUES(contact_email)');
        $stmt->execute([$siteName, $siteDescription, $contactEmail]);

        $stmt = $pdo->query('SELECT * FROM site_settings WHERE id = 1 LIMIT 1');
        $row = $stmt->fetch();
        jsonResponse(['success' => true, 'site' => $row]);
    }

    if ($action === 'dashboard_stats') {
        if (($currentUser['role'] ?? '') !== 'Administrator') {
            jsonResponse(['success' => false, 'error' => 'Admin access required'], 403);
        }

        $userCount = (int)$pdo->query('SELECT COUNT(*) AS count FROM users WHERE role = "CA"')->fetchColumn();
        $clientCount = (int)$pdo->query('SELECT COUNT(*) AS count FROM clients')->fetchColumn();
        $siteInfo = $pdo->query('SELECT site_name FROM site_settings WHERE id = 1 LIMIT 1')->fetchColumn();

        jsonResponse(['success' => true, 'stats' => [
            'ca_users' => $userCount,
            'clients' => $clientCount,
            'site_name' => $siteInfo ?: 'CA Certificate Manager',
        ]]);
    }

    if ($action === 'change_password') {
        if ($method !== 'POST') {
            jsonResponse(['success' => false, 'error' => 'POST required'], 405);
        }

        $payload = json_decode(file_get_contents('php://input'), true) ?? [];
        $currentPassword = trim((string)($payload['current_password'] ?? ''));
        $newPassword = trim((string)($payload['new_password'] ?? ''));
        $confirmPassword = trim((string)($payload['confirm_password'] ?? ''));

        if (!$currentUser) {
            jsonResponse(['success' => false, 'error' => 'Unauthorized'], 401);
        }
        if ($newPassword === '' || $confirmPassword === '' || $currentPassword === '') {
            jsonResponse(['success' => false, 'error' => 'All fields are required'], 400);
        }
        if ($newPassword !== $confirmPassword) {
            jsonResponse(['success' => false, 'error' => 'Passwords do not match'], 400);
        }

        $stmt = $pdo->prepare('SELECT password FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$currentUser['id']]);
        $userRow = $stmt->fetch();

        if (!$userRow || !password_verify($currentPassword, $userRow['password'])) {
            jsonResponse(['success' => false, 'error' => 'Current password is incorrect'], 401);
        }

        $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
        $stmt->execute([password_hash($newPassword, PASSWORD_DEFAULT), $currentUser['id']]);
        jsonResponse(['success' => true, 'message' => 'Password updated successfully']);
    }

    if ($action === 'delete_user') {
        if (($currentUser['role'] ?? '') !== 'Administrator') {
            jsonResponse(['success' => false, 'error' => 'Admin access required'], 403);
        }

        $id = (int)($_POST['id'] ?? $_GET['id'] ?? 0);
        if ($id <= 0) {
            jsonResponse(['success' => false, 'error' => 'Invalid user id'], 400);
        }

        $stmt = $pdo->prepare('SELECT role FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $record = $stmt->fetch();
        if (!$record || $record['role'] === 'Administrator') {
            jsonResponse(['success' => false, 'error' => 'Unable to delete this account'], 403);
        }

        $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$id]);
        jsonResponse(['success' => true]);
    }

    if ($action === 'create_user') {
        if (($currentUser['role'] ?? '') !== 'Administrator') {
            jsonResponse(['success' => false, 'error' => 'Admin access required'], 403);
        }

        if ($method !== 'POST') {
            jsonResponse(['success' => false, 'error' => 'POST required'], 405);
        }

        $payload = json_decode(file_get_contents('php://input'), true) ?? [];
        $username = trim((string)($payload['username'] ?? ''));
        $password = trim((string)($payload['password'] ?? ''));

        if ($username === '' || $password === '') {
            jsonResponse(['success' => false, 'error' => 'Username and password are required'], 400);
        }

        $lowerUsername = strtolower($username);
        if ($lowerUsername === 'admin' || strtolower($password) === 'admin123') {
            jsonResponse(['success' => false, 'error' => 'Reserved admin credentials cannot be used for CA registration.'], 400);
        }

        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            jsonResponse(['success' => false, 'error' => 'This username is already taken.'], 409);
        }

        $stmt = $pdo->prepare('INSERT INTO users (username, password, role) VALUES (?, ?, ?)');
        $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT), 'CA']);

        jsonResponse(['success' => true, 'user' => ['id' => (int)$pdo->lastInsertId(), 'username' => $username, 'role' => 'CA']]);
    }

    if ($action === 'login') {
        if ($method !== 'POST') {
            jsonResponse(['success' => false, 'error' => 'POST required'], 405);
        }

        $payload = json_decode(file_get_contents('php://input'), true) ?? [];
        $username = trim((string)($payload['username'] ?? ''));
        $password = trim((string)($payload['password'] ?? ''));

        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = ['id' => (int)$user['id'], 'username' => $user['username'], 'role' => $user['role']];
            jsonResponse(['success' => true, 'user' => $_SESSION['user']]);
        }

        jsonResponse(['success' => false, 'error' => 'Invalid username or password'], 401);
    }

    if ($action === 'register') {
        if ($method !== 'POST') {
            jsonResponse(['success' => false, 'error' => 'POST required'], 405);
        }

        $payload = json_decode(file_get_contents('php://input'), true) ?? [];
        $username = trim((string)($payload['username'] ?? ''));
        $password = trim((string)($payload['password'] ?? ''));

        if ($username === '' || $password === '') {
            jsonResponse(['success' => false, 'error' => 'Username and password are required'], 400);
        }

        $lowerUsername = strtolower($username);
        if ($lowerUsername === 'admin' || strtolower($password) === 'admin123') {
            jsonResponse(['success' => false, 'error' => 'Reserved admin credentials cannot be used for CA registration.'], 400);
        }

        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            jsonResponse(['success' => false, 'error' => 'This username is already taken.'], 409);
        }

        $stmt = $pdo->prepare('INSERT INTO users (username, password, role) VALUES (?, ?, ?)');
        $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT), 'CA']);

        $_SESSION['user'] = ['id' => (int)$pdo->lastInsertId(), 'username' => $username, 'role' => 'CA'];
        jsonResponse(['success' => true, 'user' => $_SESSION['user']]);
    }

    jsonResponse(['success' => false, 'error' => 'Unknown action'], 400);
}
