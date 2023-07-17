<?php
include_once("db_configs.php");

$senderId = $_GET['senderId'];     // Corrected key name
$receiverId = $_GET['recieverId']; // Corrected key name

$query = "SELECT * FROM messages WHERE ((sender_id = '$senderId' AND reciever_id = '$receiverId') OR (sender_id = '$receiverId' AND reciever_id = '$senderId')) ORDER BY message_id DESC LIMIT 1";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $data = $result->fetch_assoc();
    // Return data as JSON
    echo json_encode(array($data));
} else {
    // Handle the error condition
    echo json_encode(array());
}

$conn->close();
?>
