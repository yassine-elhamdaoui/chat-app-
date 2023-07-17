<?php
session_start();
include_once("db_configs.php");

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
  // Redirect the user to the main account page or any other authorized page
  header("Location: main_page.php");
  exit();
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['sign_in'])) {
  

    $email = $_POST['email'];
    $user_password = $_POST['password'];

    // Escape input values to prevent SQL injection
    $email = $conn->real_escape_string($email);
    $user_password = $conn->real_escape_string($user_password);

    $sql_sign_in = "SELECT * FROM users WHERE email = '$email' AND user_password = '$user_password'";
    $result = $conn->query($sql_sign_in);

    if ($result->num_rows > 0) {
      // Fetch the user ID from the result
      $row = $result->fetch_assoc();
      $user_id = $row['user_id'];

      // Set the user ID in the session
      $_SESSION['user_id'] = $user_id;

      // Update user status to "online"
      $sql_status = "UPDATE users SET status = 'online' WHERE user_id = '$user_id'";
      $result_status = $conn->query($sql_status);

      // Clean up resources and close the connection
      $result->close();
      $conn->close();

      // Redirect to the main_page.php
      header("Location: main_page.php");
      exit();
    } else {
      // Display an error message
      $error = "Invalid username or password";
      echo $error;
    }

    // Close the connection
    $conn->close();
  }
}
?>
