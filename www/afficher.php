<?php

if (empty($_GET['user'])) {
    header("Location: login.php");
    die();
}

$user = $_GET['user'];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatPoT</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <style>
        .me {
            color: red;
        }
    </style>
    <script defer>
        $(() => {
            const conversation = $("#conversation");
            const messageInput = $("#message");
            const messageForm = $("#message-form");
            const nameInput = $("#name");
            const user = nameInput.val();

            const messagesIds = [];

            const renderMessage = (message) => {
                if (messagesIds.includes(parseInt(message.id))) {
                    return;
                }
                messagesIds.push(parseInt(message.id));
                console.log(messagesIds)
                conversation.append($(`<li data-chat-id='${message.id}' class="${user === message.auteur ? "me" : "other"}" ><strong>${message.contenu}</strong> par ${message.auteur}</li>`));
            }

            $.ajax({
                url: "./recuperer.php",
                method: "GET"
            })
                .done((response) => {
                    const messages = JSON.parse(response).data;
                    messages.forEach(renderMessage);
                });

            messageForm.submit((event) => {
                event.preventDefault();
                if (nameInput.val().trim() === "") {
                    window.alert("Rentre ton nom gros débile");
                    return;
                }

                if (messageInput.val().trim() === "") {
                    window.alert("Tu n'as pas mis de message abruti");
                    return;
                }

                const auteur = nameInput.val().trim();
                const contenu = messageInput.val().trim();

                $.ajax({
                    url: "./enregistrer.php",
                    method: "GET",
                    data: {
                        auteur,
                        contenu
                    }
                })
                    .done((response) => {
                        const message = JSON.parse(response);
                        renderMessage(message);
                        messageInput.val("");
                    });
            })

            setInterval(() => {
                $.ajax({
                    url: "./recuperer.php",
                    method: "GET"
                })
                    .done((response) => {
                        const messages = JSON.parse(response).data;
                        messages.forEach(renderMessage);
                    });
            }, 2000)
        })
    </script>
</head>
<body>
<h1>Bonjour <?= $user ?>, <a href="/">Se deconnecter</a></h1>
<input id="name" type="text" disabled placeholder="Entrez votre nom" value="<?= $user ?>">
<ul id="conversation">
</ul>
<form id="message-form" action="">
    <input id="message" type="text" placeholder="Entrez un message">
    <input type="submit" value="ChatPoTer">
</form>
</body>
</html>