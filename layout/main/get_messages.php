<?php
// Connect to the database (replace with your own database credentials)
include_once("db_configs.php");


$senderId = $_GET['senderId'];
$recieverId = $_GET['recieverId'];

// Retrieve conversation_id from the conversation_id table
$query = "SELECT conversation_id FROM user_conversations WHERE sender_id = '$senderId' AND reciever_id = '$recieverId'";
$result = $conn->query($query);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $conversationId = $row['conversation_id'];
        
        // Retrieve messages for the conversation_id from the messages table
        $messageQuery = "SELECT * FROM messages WHERE conversation_id = '$conversationId'";
        $messageResult = $conn->query($messageQuery);
        
        if ($messageResult->num_rows > 0) {
            while ($messageRow = $messageResult->fetch_assoc()) {
                $data[] = $messageRow;
            }
        }
    }
}
$conn->close();

// Return data as JSON
echo json_encode($data);

// Close the database connection
?>
