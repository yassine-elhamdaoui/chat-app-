<?php
include_once("db_configs.php");

$senderId = $_GET['senderId'];    // Replace with appropriate variable or input source
$receiverId = $_GET['receiverId'];  // Replace with appropriate variable or input source

// Check if conversation already exists between sender and receiver
$query = "SELECT conversation_id FROM user_conversations WHERE sender_id = '$senderId' AND reciever_id = '$receiverId'";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    // Conversation already exists
    echo "Conversation already exists";
} else {
    // Create a new conversation
    $insertQuery = "INSERT INTO conversations (created_at) VALUES (CURRENT_TIMESTAMP)";
    if ($conn->query($insertQuery) === TRUE) {
        // Get the conversation ID of the newly created conversation
        $conversationId = $conn->insert_id;

        // Insert a record into user_conversations table
        $insertUserConversation = "INSERT INTO user_conversations (sender_id, reciever_id, conversation_id) VALUES ('$senderId', '$receiverId', '$conversationId')";
        $insertUserConversation2 = "INSERT INTO user_conversations (sender_id, reciever_id, conversation_id) VALUES ('$receiverId', '$senderId', '$conversationId')";
        if ($conn->query($insertUserConversation) === TRUE && $conn->query($insertUserConversation2)) {
            echo "New conversation created";
        } else {
            echo "Error creating user_conversations record: " . $conn->error;
        }
    } else {
        echo "Error creating conversation: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
