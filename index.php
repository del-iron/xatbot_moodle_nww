<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot Moodle</title>
    <!-- Inclusão do arquivo CSS -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Botão de chat -->
    <button id="chat-button">💬</button>
    <!-- Contêiner do chat -->
    <div id="chat-container">
        <!-- Cabeçalho do chat -->
        <div id="chat-header">
            <div id="chat-header-left">
                <img src="https://i.imgur.com/6RK7NQp.png" alt="Bot">
                <div id="chat-title">
                    <div>Toinha Moodle</div>
                    <span id="chat-status">Online agora</span>
                </div>
            </div>
            <button id="close-chat">✖</button>
        </div>
        <!-- Área de mensagens do chat -->
        <div id="chat-messages"></div>
        <!-- Área de entrada de texto do chat -->
        <div id="chat-input">
            <input type="text" id="user-input" placeholder="Digite sua pergunta...">
            <button id="send-button">➤</button>
        </div>
    </div>

    <!-- Inclusão do script JavaScript -->
    <script src="js/chatbot.js"></script>
</body>
</html>
