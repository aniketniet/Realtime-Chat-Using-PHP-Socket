<?php
require 'vendor/autoload.php';
require 'config.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $users;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->users = [];
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

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

    public function onClose(ConnectionInterface $conn) {
        unset($this->users[$conn->resourceId]);
        $this->clients->detach($conn);
        $this->sendUserList();
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    private function sendUserList() {
        $userList = array_values($this->users);
        foreach ($this->clients as $client) {
            $client->send(json_encode(['type' => 'userlist', 'users' => $userList]));
        }
    }

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
