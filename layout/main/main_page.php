<?php
session_start();
include_once("db_configs.php");

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  // Redirect the user to the login page or display an error message
  header("Location:sign_in_up.php");
  exit();
}

// Fetch user-specific data using the user ID from the session
$id = $_SESSION['user_id'];
echo '<script>

    if (window.history && window.history.pushState) {
        window.history.pushState("logout", null, "");
        window.addEventListener("popstate", function(event) {
            var confirmed = confirm("Are you sure you want to log out?");
            if (confirmed) {
                window.location.href = "logout.php";
            } else {
                window.history.pushState("", null, "");
            }
        });
    }
</script>';
echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function handleLogout() {
            var confirmed = confirm("Are you sure you want to log out?");
            if (confirmed) {
                window.location.href = "logout.php";
            }
        }

        $("#logout-icon").click(function(e) {
            e.preventDefault();
            handleLogout();
        });
    });
</script>';
// $encrypted_id = @$_GET['user_id'];
// $id = @base64_decode(base64_decode($encrypted_id));

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/chat/styles/header.css">
  <link rel="stylesheet" href="/chat/styles/main.css">
  <link rel="stylesheet" href="/chat/styles/side_bar.css">
  <link rel="stylesheet" href="/chat/styles/media_queries.css">
  <title>ChitChat</title>
  <link rel="shortcut icon" href="/chat/images/logo2-removebg-preview.png" type="image/x-icon">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>Document</title>
</head>

<body>
  <input type="hidden" id="account_user_id" value="<?php echo $id; ?>">
  <div class="app-container">
    <div class="app-header" id="header_app">
      <div class="app-header-left">
        <div class="burger">
          <input type="checkbox" id="checkbox">
          <label for="checkbox" class="toggle" id="menuBars">
            <div class="bars" id="bar1"></div>
            <div class="bars" id="bar2"></div>
            <div class="bars" id="bar3"></div>
          </label>
        </div>
        <p>ChitChat</p>
        <div class="search-div">
          <div class="search-box">
            <input type="search" class="search-input" placeholder="search..." name="" id="search_input">
            <div class="input-container">
              <input placeholder="Search something..." class="input" name="text" type="text" id="search_input2">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon">
                <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                <g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g>
                <g id="SVGRepo_iconCarrier">
                  <rect fill="white"></rect>
                  <path d="M7.25007 2.38782C8.54878 2.0992 10.1243 2 12 2C13.8757 2 15.4512 2.0992 16.7499 2.38782C18.06 2.67897 19.1488 3.176 19.9864 4.01358C20.824 4.85116 21.321 5.94002 21.6122 7.25007C21.9008 8.54878 22 10.1243 22 12C22 13.8757 21.9008 15.4512 21.6122 16.7499C21.321 18.06 20.824 19.1488 19.9864 19.9864C19.1488 20.824 18.06 21.321 16.7499 21.6122C15.4512 21.9008 13.8757 22 12 22C10.1243 22 8.54878 21.9008 7.25007 21.6122C5.94002 21.321 4.85116 20.824 4.01358 19.9864C3.176 19.1488 2.67897 18.06 2.38782 16.7499C2.0992 15.4512 2 13.8757 2 12C2 10.1243 2.0992 8.54878 2.38782 7.25007C2.67897 5.94002 3.176 4.85116 4.01358 4.01358C4.85116 3.176 5.94002 2.67897 7.25007 2.38782ZM9 11.5C9 10.1193 10.1193 9 11.5 9C12.8807 9 14 10.1193 14 11.5C14 12.8807 12.8807 14 11.5 14C10.1193 14 9 12.8807 9 11.5ZM11.5 7C9.01472 7 7 9.01472 7 11.5C7 13.9853 9.01472 16 11.5 16C12.3805 16 13.202 15.7471 13.8957 15.31L15.2929 16.7071C15.6834 17.0976 16.3166 17.0976 16.7071 16.7071C17.0976 16.3166 17.0976 15.6834 16.7071 15.2929L15.31 13.8957C15.7471 13.202 16 12.3805 16 11.5C16 9.01472 13.9853 7 11.5 7Z" clip-rule="evenodd" fill-rule="evenodd"></path>
                </g>
              </svg>
            </div>
            <div id="search-result" style="z-index: 10000;">

            </div>
          </div>
          <div class="search-button">
            <i class="fa-solid fa-magnifying-glass"></i>
          </div>
        </div>

      </div>
      <div class="app-header-right">
        <label class="ui-switch">
          <p id="mode" style="display: none;"><?php
                                              $sql_get_mode = "SELECT mode FROM users WHERE user_id = '$id' ";
                                              $result_get_mode = $conn->query($sql_get_mode);
                                              if ($result_get_mode->num_rows > 0) {
                                                $row_mode = $result_get_mode->fetch_assoc();
                                                echo $row_mode['mode'];
                                              }
                                              ?></p>
          <p id="mode_in_database" style="display: none;"></p>
          <input type="checkbox" id="toggleSwitch" onchange="sendModeToServer()">

          <div class="slider">
            <div class="circle"></div>
          </div>
        </label>
        <div class="notif-bell">
          <i class="fa-regular fa-bell"></i>
        </div>
        <p>|</p>
        <?php
        $query = "SELECT profile_picture,type FROM users WHERE user_id = " . $id;
        $result_get_image = $conn->query($query);

        if ($result_get_image && $result_get_image->num_rows > 0) {
          $row = $result_get_image->fetch_assoc();
          $profilePictureData = base64_encode($row['profile_picture']);
          $imageType = $row['type'];
          $imageSrc = "data:{$imageType};base64,{$profilePictureData}";
          if ($imageType === null) {
            echo '<img src="/chat/images/no-profile-picture.jpg" alt="Default Profile Picture">';
          } else {
            echo '<img src="' . $imageSrc . '" alt="Profile Picture">';
          }
        } else {
          // Display a default image if no profile picture is available
          echo '<img src="/chat/images/no-profile-picture.jpg" alt="Default Profile Picture">';
        }

        ?>
      </div>

    </div>
    <div class="main">
      <div class="side-bar" id="sidebar">
        <div class="search">
          <input type="text" id="search" placeholder="Search">
          <ion-icon name="search-outline"></ion-icon>
        </div>
        <div class="lists">
          <ul style="display: flex;flex-direction : column ;gap:1rem ">
            <li>
              <div class="list">
                <div class="sidebar-icon" style="width:50px; text-align:center;">
                  <ion-icon name="grid-outline"></ion-icon>
                </div>
                <span>Dashboard</span>
              </div>
            </li>
            <li>
              <div class="list">
                <div class="sidebar-icon" style="width:50px; text-align:center;">
                  <ion-icon name="person-outline"></ion-icon>
                </div>
                <span>User</span>
              </div>
            </li>
            <li>
              <div class="list">
                <div class="sidebar-icon" style="width:50px; text-align:center;">
                  <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                </div>
                <span>Messages</span>
              </div>
            </li>
            <li>
              <div class="list">
                <div class="sidebar-icon" style="width:50px; text-align:center;">
                  <ion-icon name="analytics-outline"></ion-icon>
                </div>
                <span>Analytics</span>
              </div>
            </li>
            <li>
              <div class="list">
                <div class="sidebar-icon" style="width:50px; text-align:center;">
                  <ion-icon name="folder-outline"></ion-icon>
                </div>
                <span>File Manager</span>
              </div>
            </li>
            <li>
              <div class="list">
                <div class="sidebar-icon" style="width:50px; text-align:center;">
                  <ion-icon name="cart-outline"></ion-icon>
                </div>
                <span>Order</span>
              </div>
            </li>
            <li>
              <div class="list">
                <div class="sidebar-icon" style="width:50px; text-align:center;">
                  <ion-icon name="heart-outline"></ion-icon>
                </div>
                <span>Saved</span>
              </div>
            </li>
            <li>
              <div class="list">
                <div class="sidebar-icon" style="width:50px; text-align:center;">
                  <ion-icon name="settings-outline"></ion-icon>
                </div>
                <span>Settings</span>
              </div>
            </li>
          </ul>
        </div>
        <div class="foot">
          <div class="imge">
            <?php
            if ($result_get_image && $result_get_image->num_rows > 0) {
              $imageType = $row['type'];
              if ($imageType === null) {
                echo '<img src="/chat/images/no-profile-picture.jpg" alt="Default Profile Picture">';
              } else {
                echo '<img src="' . $imageSrc . '" alt="Profile Picture">';
              }
            } else {
              // Display a default image if no profile picture is available
              echo '<img src="/chat/images/no-profile-picture.jpg" alt="Default Profile Picture">';
            }
            ?>
          </div>
          <div class="infos">
            <div>
              <h3>
                <?php
                $sqp_name = "SELECT username FROM users WHERE user_id = '$id'";
                $result_name = $conn->query($sqp_name);
                if ($result_name && $result_name->num_rows > 0) {
                  $row = $result_name->fetch_assoc();
                  $name = $row['username'];
                  echo $name;
                }
                ?>
              </h3>
            </div>
          </div>
          <div class="logout-icon" id="logout-icon">
            <ion-icon name="log-out-outline"></ion-icon>
          </div>
        </div>
      </div>
      <div class="half-main" id="half-main">

        <div class="messages-section">
          <button class="messages-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle">
              <circle cx="12" cy="12" r="10" />
              <line x1="15" y1="9" x2="9" y2="15" />
              <line x1="9" y1="9" x2="15" y2="15" />
            </svg>
          </button>
          <div class="projects-section-header">
            <p>Contact Messages</p>
          </div>

          <div class="messages" id="messages">

          </div>
        </div>
        <div class="messages-container" id="messages-container">
          <div class="conversation-header" id="conversation-header">
            <div class="contact-stuff">
              <div class="go_back" onclick="go_back_button()">
                <ion-icon name="arrow-back-sharp"></ion-icon>
              </div>
              <img id="profile_pic_contact" src="/chat/images/no-profile-picture.jpg" alt="">
              <p>|</p>
              <div class="status">
                <h3 id="clicked-contact-name">click on a contact
                </h3>
                <h6 id="contact_status"></h6>
              </div>
            </div>

            <div class="calling-stuff">
              <div class="video_call" onclick="showNotAvailableMessage('video')">
                <ion-icon name="videocam-sharp"></ion-icon>
              </div>
              <div class="audio_call" onclick="showNotAvailableMessage('audio')">
                <ion-icon name="call-sharp"></ion-icon>
              </div>
              <div class="menu_contact" id="menu_contact" onclick="showMenu()">
                <ion-icon name="ellipsis-vertical-sharp"></ion-icon>
              </div>
              <div class="overlay"></div>
              <div class="popup">
                <p id="popupText"></p>
                <button onclick="hidePopup()">OK</button>
              </div>
              <div class="popup-menu" id="popup-menu">
                <h3 id="View_contact">View contact</h3>
                <h3>Clear chat</h3>
                <h3>Block contact</h3>
                <h3>Search</h3>
              </div>
            </div>
          </div>
          <div class="conversation-display" id="conversation-display">
            <!-- Conversation messages will be dynamically added here -->
            <h3 style="text-align: center;">Start New Conversation Now 😁</h3>
            <div id="scrollButton" class="hide"><ion-icon name="arrow-up-outline"></ion-icon></div>
          </div>
          <div class="input-area" id="input-area">
            <input type="text" class="message-input" name="message" style="height:33px;" placeholder="Type your message...">
            <button id="send-icon" onclick="scrollToBottom()" type="submit">
              <i class="fa-solid fa-paper-plane"></i>
            </button>
          </div>
        </div>
        <div class="selected_contact_infos_preview" id="selected_contact_infos_preview">
          <div class="preview_head" onclick="go_back_button_preview()">
            <ion-icon name="arrow-back-sharp"></ion-icon>
          </div>
          <div class="selected_contact_picture">
            <img src="/chat/images/no-profile-picture.jpg" id="selected_contact_profile_pic" alt="">
          </div>
          <hr>
          <div class="selected_contact_infos">
            <h1>yassine</h1>
            <h3>online</h3>
            <h4>software developer</h4>
            <p>just believe in your self man , you're gonna make it on day .</p>
          </div>
          <hr>
          <div class="more_personal_infos">
            <div class="personal_info">
              <ion-icon name="location-sharp"></ion-icon>
              <p>Oujda , MOROCCO</p>
            </div>
            <div class="personal_info">
              <ion-icon name="mail-sharp"></ion-icon>
              <p id="email_selected">elhamdaouiy288@gmail.com</p>
            </div>
            <div class="personal_info">
              <ion-icon name="calendar-number-sharp"></ion-icon>
              <p>OCTOBER 13, 2002</p>
            </div>
            <div class="personal_info">
              <ion-icon name="call-sharp"></ion-icon>
              <p>0672451692</p>
            </div>
          </div>

        </div>
      </div>

    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://kit.fontawesome.com/e1688b77c2.js" crossorigin="anonymous"></script>
    <script src="/chat/dynamics/main.js"></script>
    <script src="/chat/dynamics/ajax_script.js"></script>
</body>

</html>