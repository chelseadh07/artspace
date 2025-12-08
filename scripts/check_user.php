<?php
$email = $argv[1] ?? null;
if (! $email) {
    echo "Usage: php scripts/check_user.php email\n";
    exit(1);
}
$dbPath = __DIR__ . '/../database/database.sqlite';
if (! file_exists($dbPath)) {
    echo json_encode(['error' => 'database file not found', 'path' => $dbPath]);
    exit(1);
}
try {
    $db = new PDO('sqlite:' . $dbPath);
    $stmt = $db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row ?: null, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
