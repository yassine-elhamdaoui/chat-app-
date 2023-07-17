<?php
    session_start();
    include_once("db_configs.php");

    $id = $_SESSION['user_id'];
    $sql_get_users = "SELECT * FROM users";
    $result = $conn->query($sql_get_users);
    
    $existing_users = array();

    $imageSrc = '/chat/images/no-profile-picture.jpg';


    while ($row = $result->fetch_assoc()) {
        $profilePictureData = base64_encode($row['profile_picture']);
        $imageType = $row['type'];
        $imageSrc = "data:{$imageType};base64,{$profilePictureData}";
        $existing_users[] = array(
            'user_id' => $row['user_id'],
            'username' => $row['username'],
            'pic' => $imageSrc
        );
    }
    
    if (isset($_POST['suggestion'])) {
        $search_text = $_POST['suggestion'];
        
        if (!empty($search_text)) {
            foreach ($existing_users as $user) {
                if ($user['user_id'] != $id) {
                    if (strpos($user['username'], $search_text) !== false) {
                        echo '<div id="search-div-contact"><img src="'.$user['pic'].'"><p style="display:none">'.$user['user_id'].'</p><h3>'.$user['username'].'</h3></div><hr/>';
                    }
                }

            }
        }
    }
