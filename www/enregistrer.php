<?php
require_once '../src/Database.php';

if(!(isset($_GET['auteur']))) {
    http_response_code(400);
}
if(!(isset($_GET['contenu']))) {
    http_response_code(400);
}

/** @var PDO $pdo */
$pdo = Database::getInstance()->getPDO();
$date = date('Y-m-d H:i:s');
$auteur = htmlspecialchars($_GET['auteur']);
$contenu = htmlspecialchars($_GET['contenu']);

$req = $pdo->prepare("INSERT INTO chat(date_envoi, auteur, contenu) VALUES(:date_envoi, :auteur, :contenu)");
$req->execute([
    'date_envoi' => $date,
    'auteur' => $auteur,
    'contenu' => $contenu
]);

echo(json_encode([
    'id' => $pdo->lastInsertId(),
    'date_envoi' => $date,
    'auteur' => $auteur,
    'contenu' => $contenu
]));
die();