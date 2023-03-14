<?php
require_once '../src/Database.php';
session_start();
$pass_failed = false;

if(isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    die();
}

if(!empty($_SESSION['user'])) {
    header('Location: afficher.php');
    die();
}

if (!empty($_POST['user']) && !empty($_POST['pass'])) {
    $pdo = Database::getInstance()->getPDO();
    $req = $pdo->prepare("SELECT * FROM users where username = :username LIMIT 1");
    $req->execute([
        'username' => htmlspecialchars($_POST['user'])
    ]);

    $userFind = $req->fetch(PDO::FETCH_ASSOC);

    // Si le compte n'existe pas on le créé
    if (is_bool($userFind) && $userFind === false) {
        $params = [
            'username' => htmlspecialchars($_POST['user']),
            'password' => password_hash($_POST['pass'], PASSWORD_BCRYPT)
        ];
        $req = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $req->execute($params);

        if($req->rowCount() > 0){
            $_SESSION['user'] = $params;
            header('Location: afficher.php');
            die();
        }
    } else {
        // Sinon on vérifie le mot de passe
        if (!password_verify($_POST['pass'], $userFind['password'])) {
            $pass_failed = true;
        } else {
            // On enregistre l'utilisateur en session
            $_SESSION['user'] = $userFind;
            header('Location: afficher.php');
            die();
        }
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Se connecter</title>

    <link rel="stylesheet" href="assets/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet"
          href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

</head>
<body>
    <img id="background" src="assets/images/background.jpg" alt="">

    <main class="container">
        <div id="form-login">
            <img src="assets/images/large-logo.png" alt="">
            <h1>Se connecter</h1>

            <div class="notice">
                <i class="las la-info-circle"></i>
                <p>Si votre compte n'existe pas il sera automatiquement créé, n'oubliez pas votre mot de passe.</p>
            </div>

            <?php if ($pass_failed): ?>
                <div class="notice notice-danger">
                    <i class="las la-exclamation-circle"></i>
                    <p>Le mot de passe est incorrect.</p>
                </div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="form-group">
                    <label for="user">Saisir un nom</label>
                    <input id="user" maxlength="30" type="text" name="user" placeholder="John Doe" value="<?= $userFind['username'] ?? "" ?>">
                </div>


                <div class="form-group">
                    <label for="pass">Saisir le mot de passe</label>
                    <input id="pass" type="password" name="pass" placeholder="Secret...">
                </div>

                <button type="submit">
                    Commencer à ChatPoTer !
                    <i class="las la-paw"></i>
                </button>
            </form>
        </div>
    </main>

</body>
</html>