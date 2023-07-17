<?php
include_once("db_configs.php");

$message = $_POST['message'];
$time = time();
$dateString = date("Y-m-d H:i:s", $time);

// Create a new mysqli object

$senderId = $_GET['senderId'];
$recieverId = $_GET['recieverId'];
$message = $_GET['message'];

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_get_conversation = "SELECT conversation_id FROM user_conversations WHERE (sender_id = '$senderId' AND reciever_id = '$recieverId') OR (reciever_id = '$senderId' AND sender_id = '$recieverId')";
$result_get_conversation = $conn->query($sql_get_conversation);

if ($result_get_conversation && $result_get_conversation->num_rows > 0) {
    $conv_id = $result_get_conversation->fetch_assoc()['conversation_id'];
    $sql_message = "INSERT INTO messages (sender_id, reciever_id, conversation_id, content, sent_at) VALUES ('$senderId', '$recieverId', '$conv_id', '$message', '$dateString')";
    $result_add_message = $conn->query($sql_message);

    if ($result_add_message) {
        echo "Message added successfully";
    } else {
        echo "Failed to add message";
    }
} else {
    echo "Conversation not found";
}

$conn->close();
?>
