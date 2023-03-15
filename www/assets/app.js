$(() => {
    const conversation = $("#conversation-body")
    const messageInput = $("#message")
    const messageForm = $("#message-form")
    const nameInput = $("#name")
    const alivesCount = $("#alives-count")
    const alivesList = $("#alives-list")
    const user = nameInput.val()
    const roomContainer = $("#room-container")

    const alreadyRenderedMessagesIds = []

    const renderMessage = (message) => {
        if (alreadyRenderedMessagesIds.includes(parseInt(message.id))) {
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

        alreadyRenderedMessagesIds.push(parseInt(message.id))
        conversation.append($(`<div data-chat-id='${message.id}' class="message ${user === message.auteur ? "me" : "other"}" >
            <p class="message-author">${message.auteur}</p>
            <p class="message-content">${message.contenu}</p>
            <p class="message-time">le ${dateString} à ${hoursString}</p>
        </div>`))

        conversation.scrollTop(conversation.prop("scrollHeight"))
    }

    const fetchMessages = (roomID) => {
        $.ajax({
            url: "./recuperer.php",
            method: "GET",
            data: {
                room_id: roomID ?? roomContainer.find(".active").data("room-id")
            }
        }).done((response) => {
            const messages = JSON.parse(response).data;
            messages.forEach(renderMessage);
        });
    }

    const renderAlives = (alives) => {
        // ajout des nouveaux vivants
        alives.forEach((alive) => {
            if (alivesList.find(`[data-username="${alive.username}"]`).length > 0) {
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
            if (!alives.find((alive) => alive.username === aliveUsername)) {
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

    const roomClickHandler = (event) => {
        const roomElement = $(event.currentTarget);
        const roomId = roomElement.data("room-id");

        roomContainer.find(".active").removeClass("active");
        roomElement.addClass("active");

        conversation.empty();
        alreadyRenderedMessagesIds.length = 0;
        fetchMessages(roomId);
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
                contenu,
                room_id: roomContainer.find(".active").data("room-id")
            }
        }).done((response) => {
            const message = JSON.parse(response);
            renderMessage(message);
            messageInput.val("");
        });
    })

    $.ajax({
        url: "./rooms.php",
        method: "GET",
    }).done((response) => {
        const payload = JSON.parse(response);
        payload.rooms.forEach((room, index) => {
            const roomElement = $(`<div class="room-item ${index === 0 ? 'active' : ''}" data-room-id="${room.id}">
                <img src="https://ui-avatars.com/api/?bold=true&name=${room.name}&background=6A1B9A&color=F5F5F5" alt="">
                <p>${room.name}</p>
            </div>`);

            roomElement.click(roomClickHandler)
            roomContainer.append(roomElement);
        });

        // on commence à récupérer les messages de la room active (ici la première)
        fetchMessages();
        setInterval(fetchMessages, 2000);
    });

    // On récupère les connectés
    setInterval(fecthAlives, 5000);
    fecthAlives();
})