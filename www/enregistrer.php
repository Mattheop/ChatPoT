<?php
require_once '../src/Database.php';
session_start();

// On vérifie que l'utilisateur est bien connecté
if ($_SESSION['user'] === null) {
    http_response_code(401);
    echo(json_encode([
        'error' => 'Unauthorized'
    ]));
    die();
}

// On vérifie que l'utilisateur est bien l'auteur du message
if (!(isset($_GET['auteur']))) {
    http_response_code(400);
    echo(json_encode([
        'error' => 'auteur is required'
    ]));
    die();
}

// On vérifie que l'utilisateur est bien l'auteur du message
if ($_SESSION['user']['username'] !== $_GET['auteur']) {
    http_response_code(401);
    echo(json_encode([
        'error' => 'Unauthorized'
    ]));
    die();
}

// On vérifie que le contenu du message n'est pas vide
if (!(isset($_GET['contenu']))) {
    http_response_code(400);
    echo(json_encode([
        'error' => 'contenu is required'
    ]));
    die();
}

// On vérifie que le contenu du message n'est pas vide
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

// On enregistre le message dans la base de données
$req = $pdo->prepare("INSERT INTO chat(date_envoi, auteur, contenu, room_id) VALUES(:date_envoi, :auteur, :contenu, :room_id)");
$req->execute([
    'date_envoi' => $date,
    'auteur' => $auteur,
    'contenu' => $contenu,
    'room_id' => $roomID
]);

// On renvoie le message en JSON
echo(json_encode([
    'id' => (int)$pdo->lastInsertId(),
    'date_envoi' => $date,
    'auteur' => $auteur,
    'contenu' => $contenu,
    'room_id' => $roomID
]));
die();