<!DOCTYPE html>
<html>
<head>
    <title>Chat avec RAGBot</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Chat avec RAGBot</h1>

    <div id="chat-box" style="border:1px solid #ccc; padding:10px; width:400px; height:300px; overflow-y:scroll;"></div>

    <input type="text" id="question" placeholder="Tapez votre message..." style="width:300px;">
    <button onclick="sendQuestion()">Envoyer</button>

    <script>
        async function sendQuestion() {
            let question = document.getElementById('question').value;
            if(!question) return;

            // Ajouter le message utilisateur au chat
            let chatBox = document.getElementById('chat-box');
            chatBox.innerHTML += `<div><b>Vous:</b> ${question}</div>`;

            // Envoyer la question à Laravel
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let response = await fetch('/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({question: question})
            });

            let data = await response.json();

            // Ajouter la réponse du bot au chat
            chatBox.innerHTML += `<div><b>Bot:</b> ${data.answer}</div>`;
            chatBox.scrollTop = chatBox.scrollHeight;

            // Vider l'input
            document.getElementById('question').value = '';
        }
    </script>
</body>
</html>
