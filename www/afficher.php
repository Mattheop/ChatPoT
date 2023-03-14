<?php
session_start();


if (empty($_SESSION['user'])) {
    header("Location: login.php");
    die();
}

$user = $_SESSION['user']['username'];

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ChatPoT - <?= $user ?></title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet"
          href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script defer src="assets/app.js"></script>
</head>
<body>

<main class="main">
    <nav class="sidebar">
        <div class="sidebar-header">
            <img src="assets/images/large-logo.png" alt="">
        </div>
        <div class="room-container">
            <div class="room-item active">
                <img src="https://ui-avatars.com/api/?bold=true&name=General&background=6A1B9A&color=F5F5F5" alt="">
                <p>General</p>
            </div>
        </div>

        <div class="alives-containers">
            <h4><span id="alives-count">0</span> Personnes connectées</h4>
            <div id="alives-list"></div>
        </div>
    </nav>


    <aside class="conversation-container">
        <div class="conversation-header">Bonjour <strong><?= $user ?></strong>, <a href="login.php?logout">Se déconnecter</a></div>
        <div class="conversation-body" id="conversation-body">
        </div>
        <form class="conversation-footer" id="message-form" action="">
            <input type="hidden" id="name" value="<?= $user ?>">
            <input id="message" type="text" placeholder="Tapez ici">
            <button type="submit">
                ChatPoTer
                <i class="las la-paw"></i>
            </button>
        </form>
    </aside>
</main>

</body>
</html>