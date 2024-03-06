// Fonction pour ouvrir/fermer la fenêtre du chatbot
function toggleChatbot() {
    var chatbot = document.getElementById('chatbot');
    chatbot.classList.toggle('open');
}

// Fonction pour envoyer un message à l'API Chatbot
function sendMessage() {
    var messageInput = document.getElementById('chatbot-message');
    var userMessage = messageInput.value;

    // Remplacez l'URL par l'URL correcte de votre API Chatbot
    //var apiUrl = 'https://app.chatbot.com/dashboard/65e7b5c4106b510007b3a1ed';
    var apiUrl = 'http://127.0.0.1:8000/chatbot';

    // Remplacez 'YOUR_CHATBOT_API_KEY' par votre clé d'API Chatbot
    var requestData = {
        key: 'aOs72PVrOL9_Dtgsmvj4ODc_C8MHnmgI',
        message: userMessage,
    };

    fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(requestData),
    })
    .then(response => response.json())
    .then(data => {
        // Traiter la réponse du Chatbot API ici
        var chatWindow = document.getElementById('chatbot-window');
        var messageElement = document.createElement('div');
        messageElement.className = 'message bot';
        messageElement.innerHTML = data.message;
        chatWindow.appendChild(messageElement);

        messageInput.value = '';
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Événement pour ouvrir/fermer la fenêtre du chatbot lorsqu'on clique sur l'icône
document.getElementById('chatbot-icon').addEventListener('click', function() {
    toggleChatbot();
});

// Événement pour envoyer un message lorsque l'utilisateur appuie sur Entrée
document.getElementById('chatbot-message').addEventListener('keydown', function(event) {
    if (event.keyCode === 13) { // Le code 13 correspond à la touche Entrée
        event.preventDefault(); // Empêcher le saut de ligne dans le champ de texte
        sendMessage(); // Appeler la fonction pour envoyer le message
    }

    
});
