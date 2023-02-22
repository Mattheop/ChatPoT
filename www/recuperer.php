<?php
require_once '../src/Database.php';

/** @var PDO $pdo */
$pdo = Database::getInstance()->getPDO();
$req = $pdo->prepare("SELECT * FROM chat ORDER BY date_envoi desc LIMIT 10");
$req->execute();

echo(json_encode([
    'data' => array_reverse($req->fetchAll(PDO::FETCH_ASSOC))
]));
die();