<?php
require_once '../src/Database.php';
session_start();

$pdo = Database::getInstance()->getPDO();
$rooms = $pdo->query('SELECT * FROM rooms ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);
echo(json_encode([
    'count' => count($rooms),
    'rooms' => $rooms
]));
die();