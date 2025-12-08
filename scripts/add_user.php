<?php
$email = $argv[1] ?? null;
$name = $argv[2] ?? null;
$password = $argv[3] ?? null;
$role = $argv[4] ?? 'client';
if (! $email || ! $name || ! $password) {
    echo "Usage: php scripts/add_user.php email name password [role]\n";
    exit(1);
}
$dbPath = __DIR__ . '/../database/database.sqlite';
if (! file_exists($dbPath)) {
    echo "Database file not found: $dbPath\n";
    exit(1);
}
try {
    $db = new PDO('sqlite:' . $dbPath);
    $stmt = $db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        echo "User already exists: " . json_encode($row) . "\n";
        exit(0);
    }
    $hashed = password_hash($password, PASSWORD_BCRYPT);
    $now = (new DateTime())->format('Y-m-d H:i:s');
    $insert = $db->prepare('INSERT INTO users (name,email,password,role,created_at,updated_at) VALUES (?,?,?,?,?,?)');
    $insert->execute([$name,$email,$hashed,$role,$now,$now]);
    echo "Inserted user $email with role $role\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
