<?php
require_once '../src/Database.php';

if (empty($_GET['room_id'])) {
    echo(json_encode([
        'error' => 'room_id is required'
    ]));
    die();
}

$roomID = (int)$_GET['room_id'];

/** @var PDO $pdo */
$pdo = Database::getInstance()->getPDO();
$req = $pdo->prepare("SELECT * FROM chat WHERE room_id = :room_id ORDER BY date_envoi desc LIMIT 10");
$req->execute([
    'room_id' => $roomID
]);

echo(json_encode([
    'data' => array_reverse($req->fetchAll(PDO::FETCH_ASSOC))
]));
die();