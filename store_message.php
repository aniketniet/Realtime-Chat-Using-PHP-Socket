<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "Not logged in";
    exit();
}

require 'config.php';

$username = $_SESSION['username'];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['to']) && isset($_POST['message'])) {
    $to = $_POST['to'];
    $message = $_POST['message'];
    $stmt = $conn->prepare("INSERT INTO messages (sender, receiver, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $to, $message);
    $stmt->execute();
    $stmt->close();
    echo "Message stored";
} else {
    echo "Invalid request";
}
?>
