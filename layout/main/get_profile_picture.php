<?php
include_once("db_configs.php");


    $id = $_GET['user_id'];
    $query = "SELECT profile_picture,type FROM users WHERE user_id = " . $id;
    $result_get_image = $conn->query($query);
    $imageSrc = '/chat/images/no-profile-picture.jpg';
    if ($result_get_image && $result_get_image->num_rows > 0) {
      $row = $result_get_image->fetch_assoc();
      $profilePictureData = base64_encode($row['profile_picture']);
      $imageType = $row['type'];
      $imageSrc = "data:{$imageType};base64,{$profilePictureData}";
    //   echo '<img src="' . $imageSrc . '" alt="Profile Picture">';
      $conn->close();
      echo $imageSrc ;
    } else {
      // Display a default image if no profile picture is available
      $conn->close();
      echo $imageSrc;
    }

?>