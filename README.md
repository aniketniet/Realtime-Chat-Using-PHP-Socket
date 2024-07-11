# Real-Time Chat Application

A real-time chat application using PHP, WebSockets, and MySQL. It includes user login, real-time communication, and message storage.

## Features

- User login
- Real-time communication using WebSockets
- Online user list
- Private messaging
- Message storage in MySQL

## Requirements

- PHP 7.0+
- Composer
- MySQL
- OpenSSL (for secure WebSocket connections)
- A web server (e.g., Apache, Nginx)

## Installation

1. **Clone the Repository:**

    ```bash
    git clone https://github.com/aniketniet/Realtime-Chat-Using-PHP-Socket.git
    cd real-time-chat-app
    ```

2. **Install Dependencies:**

    ```bash
    composer install
    ```

3. **Configure MySQL Database:**

    - Create a MySQL database and import the `chat_db.sql` file.
    - Update `config.php` with your database credentials.

4. **Configure SSL:**

   currently not avalable

5. **Start the WebSocket Server:**

    ```bash
    php server.php
    ```

6. **Place Client Files on Web Server:**

    - Ensure `index.html`, `chat.php`, `store_message.php`, and `config.php` are in your web server’s document root.

7. **Access the Application:**

    - Open a web browser and navigate to your server’s address, e.g., `https://yourserver.com/index.html`.

## Acknowledgements

- [Ratchet](http://socketo.me/) - PHP WebSocket library
- [Bootstrap](https://getbootstrap.com/) - Front-end framework



