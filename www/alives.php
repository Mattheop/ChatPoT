<?php
require_once '../src/Database.php';
session_start();

if (empty($_SESSION['user'])) {
    header("Location: login.php");
    die();
}

$pdo = Database::getInstance()->getPDO();
$update_me = $pdo->prepare("UPDATE users SET last_alive = NOW() WHERE username = :username");
$update_me->execute(['username' => $_SESSION['user']['username']]);

$usersAlive = $pdo->query("SELECT username FROM users WHERE last_alive > NOW() - INTERVAL 15 SECOND")->fetchAll(PDO::FETCH_FUNC, function ($username) {
    return [
        'username' => $username,
        'avatar' => "https://ui-avatars.com/api/?bold=true&name=$username&background=6A1B9A&color=F5F5F5"
    ];
});

echo(json_encode([
    'count' => count($usersAlive),
    'users' => $usersAlive
]));
die();