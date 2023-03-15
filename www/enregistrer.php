<?php
require_once '../src/Database.php';

if (!(isset($_GET['auteur']))) {
    http_response_code(400);
    echo(json_encode([
        'error' => 'auteur is required'
    ]));
    die();
}
if (!(isset($_GET['contenu']))) {
    http_response_code(400);
    echo(json_encode([
        'error' => 'contenu is required'
    ]));
    die();
}

if (!(isset($_GET['room_id']))) {
    http_response_code(400);
    echo(json_encode([
        'error' => 'room_id is required'
    ]));
    die();
}

$pdo = Database::getInstance()->getPDO();
$date = date('Y-m-d H:i:s');
$auteur = htmlspecialchars($_GET['auteur']);
$contenu = htmlspecialchars($_GET['contenu']);
$roomID = (int)$_GET['room_id'];

$req = $pdo->prepare("INSERT INTO chat(date_envoi, auteur, contenu, room_id) VALUES(:date_envoi, :auteur, :contenu, :room_id)");
$req->execute([
    'date_envoi' => $date,
    'auteur' => $auteur,
    'contenu' => $contenu,
    'room_id' => $roomID
]);

echo(json_encode([
    'id' => (int)$pdo->lastInsertId(),
    'date_envoi' => $date,
    'auteur' => $auteur,
    'contenu' => $contenu,
    'room_id' => $roomID
]));
die();