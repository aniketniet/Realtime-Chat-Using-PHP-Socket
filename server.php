<?php
require 'vendor/autoload.php';
require 'config.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

/**
 * The Chat class implements the Ratchet MessageComponentInterface
 * and handles the WebSocket communication for the chat application.
 */
class Chat implements MessageComponentInterface {
    protected $clients;
    protected $users;

    /**
     * Constructor method.
     * Initializes the clients and users arrays.
     */
    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->users = [];
    }

    /**
     * Called when a new connection is opened.
     * Attaches the connection to the clients array and logs the new connection.
     *
     * @param ConnectionInterface $conn The connection object
     */
    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    /**
     * Called when a message is received from a connection.
     * Decodes the message and performs actions based on the message type.
     *
     * @param ConnectionInterface $from The connection object
     * @param string $msg The received message
     */
    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg);
        switch ($data->type) {
            case 'login':
                $this->users[$from->resourceId] = $data->username;
                $this->sendUserList();
                break;
            case 'message':
                $this->sendMessage($from, $data->to, $data->message);
                break;
        }
    }

    /**
     * Called when a connection is closed.
     * Removes the connection from the users array, detaches the connection, and sends the updated user list to all clients.
     *
     * @param ConnectionInterface $conn The connection object
     */
    public function onClose(ConnectionInterface $conn) {
        unset($this->users[$conn->resourceId]);
        $this->clients->detach($conn);
        $this->sendUserList();
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    /**
     * Called when an error occurs on a connection.
     * Logs the error message and closes the connection.
     *
     * @param ConnectionInterface $conn The connection object
     * @param \Exception $e The exception object
     */
    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    /**
     * Sends the updated user list to all connected clients.
     */
    private function sendUserList() {
        $userList = array_values($this->users);
        foreach ($this->clients as $client) {
            $client->send(json_encode(['type' => 'userlist', 'users' => $userList]));
        }
    }

    /**
     * Sends a message from one user to another user.
     *
     * @param ConnectionInterface $from The connection object of the sender
     * @param string $to The username of the recipient
     * @param string $message The message to be sent
     */
    private function sendMessage($from, $to, $message) {
        foreach ($this->clients as $client) {
            if ($this->users[$client->resourceId] === $to) {
                $client->send(json_encode(['type' => 'message', 'from' => $this->users[$from->resourceId], 'message' => $message]));
            }
        }
    }
}

$server = \Ratchet\Server\IoServer::factory(
    new \Ratchet\Http\HttpServer(
        new \Ratchet\WebSocket\WsServer(
            new Chat()
        )
    ),
    3000
);

echo "Server started at port 3000\n";

$server->run();

echo "Server stopped\n";
?>
