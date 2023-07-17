<?php
include_once("db_configs.php");

if (isset($_POST['sign_up'])) {

  
  $name = $_POST['name'];
  $email = $_POST['email'];
  $user_password = $_POST['password'];
  $user_password_confirm = $_POST['password_confirm'];
  $date_of_birth = $_POST['date_of_birth'];
  $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

  // Handle file upload
  if (!empty($_FILES['profile_picture']['tmp_name'])) {
    $image = $_FILES['profile_picture']['tmp_name'];
    $imageType = $_FILES['profile_picture']['type'];
  
    // Read the image file contents
    $imgData = addslashes(file_get_contents($image));
  
    $sql_check = "SELECT * FROM users WHERE username = '$name' OR email = '$email'";
    $result_check = $conn->query($sql_check);
  
    if ($result_check->num_rows > 0) {
      // User with the same username or email already exists
      echo "Error: Username or email already in use!";
    } else {
      if ($user_password === $user_password_confirm) {
        // Insert user info into the users table
        $sql_insert = "INSERT INTO users (username, email, user_password, profile_picture, type,date_of_birth,mode) VALUES ('$name', '$email', '$hashed_password', '$imgData', '$imageType','$date_of_birth','light')";
        
        if ($conn->query($sql_insert) === TRUE) {
          // User registration successful
          header('location: sign_in_up.php');
        } else {
          // Error occurred while inserting user info
          echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
      }else{
         
      }
    }
  } else {
    $sql_check = "SELECT * FROM users WHERE username = '$name' OR email = '$email'";
    $result_check = $conn->query($sql_check);
  
    if ($result_check->num_rows > 0) {
      // User with the same username or email already exists
      echo "Error: Username or email already in use!";
    } else {
      if ($user_password === $user_password_confirm) {
          // Insert user info into the users table without an image
          $sql_insert = "INSERT INTO users (username, email, user_password,date_of_birth,mode) VALUES ('$name', '$email', '$hashed_password','$date_of_birth','light')";
      
          if ($conn->query($sql_insert) === TRUE) {
            // User registration successful
            header('location: sign_in_up.php');
          } else {
            // Error occurred while inserting user info
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
          }
      }else{
        
      }

    }
  }

  $conn->close();
}
?>
