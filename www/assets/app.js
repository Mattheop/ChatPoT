$(() => {
    const conversation = $("#conversation-body");
    const messageInput = $("#message");
    const messageForm = $("#message-form");
    const nameInput = $("#name");
    const user = nameInput.val();

    const messagesIds = [];

    const renderMessage = (message) => {
        if (messagesIds.includes(parseInt(message.id))) {
            return;
        }
        const date = new Date(Date.parse(message.date_envoi));
        const dateString = date.toLocaleDateString("fr-FR", {
            month: "numeric",
            day: "numeric",
        });

        const hoursString = date.toLocaleTimeString("fr-FR", {
            timeStyle: "short",
        });

        messagesIds.push(parseInt(message.id));
        console.log(messagesIds);
        conversation.append($(`<div data-chat-id='${message.id}' class="message ${user === message.auteur ? "me" : "other"}" >
            <p class="message-author">${message.auteur}</p>
            <p class="message-content">${message.contenu}</p>
            <p class="message-time">le ${dateString} à ${hoursString}</p>
        </div>`));

        conversation.scrollTop(conversation.prop("scrollHeight"));
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
        }).done((response) => {
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