$(() => {
    const conversation = $("#conversation-body")
    const messageInput = $("#message")
    const messageForm = $("#message-form")
    const nameInput = $("#name")
    const alivesCount = $("#alives-count")
    const alivesList = $("#alives-list")
    const user = nameInput.val()

    const messagesIds = []

    const renderMessage = (message) => {
        if (messagesIds.includes(parseInt(message.id))) {
            return
        }
        const date = new Date(Date.parse(message.date_envoi))
        const dateString = date.toLocaleDateString("fr-FR", {
            month: "numeric",
            day: "numeric",
        })

        const hoursString = date.toLocaleTimeString("fr-FR", {
            timeStyle: "short",
        })

        messagesIds.push(parseInt(message.id))
        conversation.append($(`<div data-chat-id='${message.id}' class="message ${user === message.auteur ? "me" : "other"}" >
            <p class="message-author">${message.auteur}</p>
            <p class="message-content">${message.contenu}</p>
            <p class="message-time">le ${dateString} à ${hoursString}</p>
        </div>`))

        conversation.scrollTop(conversation.prop("scrollHeight"))
    }

    const fetchMessages = () => {
        $.ajax({
            url: "./recuperer.php",
            method: "GET"
        }).done((response) => {
            const messages = JSON.parse(response).data;
            messages.forEach(renderMessage);
        });
    }

    const renderAlives = (alives) => {
        // ajout des nouveaux vivants
        alives.forEach((alive) => {
            if(alivesList.find(`[data-username="${alive.username}"]`).length > 0) {
                return;
            }

            alivesList.append($(`<div class="alive" data-username="${alive.username}">
                <img src="${alive.avatar}" alt="">
                <p>${alive.username}</p>
            </div>`))
        })

        // suppression des morts
        alivesList.find(".alive").each((index, alive) => {
            const aliveUsername = $(alive).data("username");
            if(!alives.find((alive) => alive.username === aliveUsername)) {
                $(alive).remove();
            }
        });
    }
    const fecthAlives = () => {
        $.ajax({
            url: "./alives.php",
            method: "GET"
        }).done((response) => {
            const alives = JSON.parse(response)
            alivesCount.text(alives.count)

            renderAlives(alives.users)
        })
    }

    messageForm.submit((event) => {
        event.preventDefault()
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

    setInterval(fetchMessages, 2000)
    setInterval(fecthAlives, 5000)

    fetchMessages()
    fecthAlives()
})