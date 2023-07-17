<?php
session_start();
include_once("db_configs.php");
// Retrieve the mode value sent by AJAX
$mode = $_POST['mode'];
$id = $_SESSION['user_id'];

// Update the database with the new mode value
$sql_set_mode = "UPDATE users SET mode = '$mode' WHERE user_id = '$id'";
$result_set_mode = $conn->query($sql_set_mode);

// Handle any further processing or response as needed

?>
