<?php
require 'vendor/autoload.php';
require 'bootstrap/app.php';

use App\Models\User;

$users = User::select('user_id', 'name', 'email', 'role')->get();

echo "=== ALL USERS IN DATABASE ===\n";
foreach ($users as $user) {
    echo "ID: {$user->user_id}, Name: {$user->name}, Email: {$user->email}, Role: {$user->role}\n";
}
echo "\n";
