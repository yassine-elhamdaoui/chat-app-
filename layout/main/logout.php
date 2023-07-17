<?php
    session_start();

    include_once("db_configs.php");

    $user_id = $_SESSION['user_id'];
    $sql_status = "UPDATE users SET status = 'offline' WHERE user_id = '$user_id'";
    $result_status = $conn->query($sql_status);
    // Clear the session data
    session_unset();
    session_destroy();

    // Redirect the user to the login page or any other appropriate page
    header("Location:sign_in_up.php");
    exit();
?>









