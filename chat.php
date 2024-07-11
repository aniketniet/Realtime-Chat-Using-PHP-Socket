<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'])) {
    $_SESSION['username'] = $_POST['username'];
    header("Location: chat.php");
    exit();
}

if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

require 'config.php';

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #chatBox {
            height: 300px;
            overflow-y: scroll;
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
        #users {
            list-style-type: none;
            padding: 0;
        }
        #users li {
            cursor: pointer;
        }
        #users li:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h2>Online Users</h2>
                    </div>
                    <div class="card-body">
                        <ul id="users" class="list-group"></ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Chat with <span id="chatWith">...</span></h2>
                    </div>
                    <div class="card-body">
                        <div id="chatBox"></div>
                        <input type="hidden" name="to" id="chatTo">
                        <div class="input-group">
                            <input type="text" id="messageInput" class="form-control" placeholder="Type a message">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" onclick="sendMessage()">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const ws = new WebSocket('ws://127.0.0.1:3000');
        let username = "<?php echo $username; ?>";
        let chatWith = null;

        ws.onopen = function() {
            ws.send(JSON.stringify({ type: 'login', username: username }));
        };

        ws.onmessage = function(event) {
            const data = JSON.parse(event.data);
            if (data.type === 'userlist') {
                const users = document.getElementById('users');
                users.innerHTML = '';
                data.users.forEach(user => {
                    if (user !== username) {
                        const li = document.createElement('li');
                        li.textContent = user;
                        li.classList.add('list-group-item');
                        li.onclick = () => startChat(user);
                        users.appendChild(li);
                    }
                });
            } else if (data.type === 'message') {
                const chatBox = document.getElementById('chatBox');
                chatBox.innerHTML += `<p><strong>${data.from}:</strong> ${data.message}</p>`;
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        };

        function startChat(user) {
            chatWith = user;
            document.getElementById('chatWith').textContent = user;
            document.getElementById('chatTo').value = user;
            document.getElementById('chatBox').innerHTML = '';
        }

        function sendMessage() {
            if (chatWith) {
                const message = document.getElementById('messageInput').value;
                ws.send(JSON.stringify({ type: 'message', to: chatWith, message: message }));
                document.getElementById('messageInput').value = '';

                // Store message in database using AJAX
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "store_message.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("to=" + chatWith + "&message=" + message);
            } else {
                alert('Select a user to chat with');
            }
        }
    </script>
</body>
</html>
