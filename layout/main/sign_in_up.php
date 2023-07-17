<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once '/xampp/htdocs/chat/PHPMailer/src/Exception.php';
require_once '/xampp/htdocs/chat/PHPMailer/src/SMTP.php';
require_once '/xampp/htdocs/chat/PHPMailer/src/PHPMailer.php';
session_start();
include_once("db_configs.php");
// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
  // Redirect the user to the main account page or any other authorized page
  header("Location:main_page.php");
  exit();
}
// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['sign_in'])) {
    $email = $_POST['email'];
    $user_password = $_POST['password'];

    // Escape input values to prevent SQL injection
    $email = $conn->real_escape_string($email);

    $sql_sign_in = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql_sign_in);

    if ($result->num_rows > 0) {
      // Fetch the user data from the result
      $row = $result->fetch_assoc();
      $stored_password = $row['user_password'];

      // Verify the provided password with the stored hashed password
      if (password_verify($user_password, $stored_password)) {
        // Password is correct
        $user_id = $row['user_id'];

        // Set the user ID in the session
        $_SESSION['user_id'] = $user_id;
        $sql_status = "UPDATE users SET status = 'online' WHERE user_id = '$user_id'";
        $result_status = $conn->query($sql_status);

        // Redirect to the main_page.html with the encoded user ID in the URL
        $conn->close();
        header("Location: main_page.php");
        exit();
      } else {
        // Password is incorrect
        $error_invalid = "Invalid username or password";
        $conn->close();
      }
    } else {
      // User does not exist
      $error_invalid = "Invalid username or password";
      $conn->close();
    }
  }
}

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
      $error_exist = "Error: Username or email already in use!";
    } else {
      if ($user_password === $user_password_confirm) {
        // Insert user info into the users table
        $sql_insert = "INSERT INTO users (username, email, user_password, profile_picture, type,date_of_birth,status,mode) VALUES ('$name', '$email', '$hashed_password', '$imgData', '$imageType','$date_of_birth','offline','light')";

        if ($conn->query($sql_insert) === TRUE) {
          $mail = new PHPMailer(true);

          // SMTP configuration
          $mail->isSMTP();
          $mail->Host = 'smtp.gmail.com';
          $mail->SMTPAuth = true;
          $mail->Username = 'YARAYHOTEL@gmail.com';
          $mail->Password = 'cbmovduffcpvwalr';
          $mail->SMTPSecure = 'tls';
          $mail->Port = 587;

          // Sender and recipient settings
          $mail->setFrom('YARAYHOTEL@gmail.com');
          $mail->addAddress($email);

          // Email content
          $mail->isHTML(true);
          $mail->Subject = 'Account Registration Confirmation';
          $mail->Body = "
          <h2>Welcome to Our Chat App!</h2>
          <p>Dear $name,</p>
          <p>Thank you for joining our chat app. We're glad to have you as part of our community!</p>
          <p>Your account has been successfully created. Here are your login details:</p>
          <p>Email: $email</p>
          <p>Password: ********</p>
          <p>With our chat app, you can connect with friends, join chat rooms, and enjoy conversations.</p>
          <p>If you have any questions or need assistance, please don't hesitate to reach out to our support team.</p>
          <p>Happy chatting!</p>
          <p>Your Chat App Team</p>
          ";


          // Send email
          if ($mail->send()) {
            header('location: sign_in_up.php');
          } else {
            $mail->ErrorInfo;
            echo 'Error sending email';
          }
          // User registration successful
        } else {
          // Error occurred while inserting user info
          echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
      } else {
        $error_match = "enter the same password !";
      }
    }
  } else {
    $sql_check = "SELECT * FROM users WHERE username = '$name' OR email = '$email'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
      // User with the same username or email already exists
      $error_exist = "Error: Username or email already in use!";
    } else {
      if ($user_password === $user_password_confirm) {
        // Insert user info into the users table without an image
        $sql_insert = "INSERT INTO users (username, email, user_password,date_of_birth,status,mode) VALUES ('$name', '$email', '$hashed_password','$date_of_birth','offline','light')";

        if ($conn->query($sql_insert) === TRUE) {
          $mail = new PHPMailer(true);

          // SMTP configuration
          $mail->isSMTP();
          $mail->Host = 'smtp.gmail.com';
          $mail->SMTPAuth = true;
          $mail->Username = 'YARAYHOTEL@gmail.com';
          $mail->Password = 'cbmovduffcpvwalr';
          $mail->SMTPSecure = 'tls';
          $mail->Port = 587;

          // Sender and recipient settings
          $mail->setFrom('YARAYHOTEL@gmail.com');
          $mail->addAddress($email);

          // Email content
          $mail->isHTML(true);
          $mail->Subject = 'Account Registration Confirmation';
          $mail->Body = "
          <h2>Welcome to Our Chat App!</h2>
          <p>Dear $name,</p>
          <p>Thank you for joining our chat app. We're glad to have you as part of our community!</p>
          <p>Your account has been successfully created. Here are your login details:</p>
          <p>Email: $email</p>
          <p>Password: ********</p>
          <p>With our chat app, you can connect with friends, join chat rooms, and enjoy conversations.</p>
          <p>If you have any questions or need assistance, please don't hesitate to reach out to our support team.</p>
          <p>Happy chatting!</p>
          <p>Your Chat App Team</p>
          ";
          // Send email
          if ($mail->send()) {
            header('location: sign_in_up.php');
          } else {
            $mail->ErrorInfo;
            echo 'Error sending email';
          }
          // User registration successful
          header('location: sign_in_up.php');
        } else {
          // Error occurred while inserting user info
          echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
      } else {
        $error_match = "enter the same password !";
      }
    }
  }

  $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ChitChat</title>
  <link rel="shortcut icon" href="/chat/images/logo2-removebg-preview.png" type="image/x-icon">
  <link rel="stylesheet" href="/chat/styles/signin_up.css">

  <style>
    * {
      margin: 0;
      padding: 0;
      overflow: hidden;
    }

    .form-responsive {
      width: 100svw;
      height: 100svh;
      display: none;
      /* justify-content: center; */
      align-items: center;
      flex-direction: column;
      gap: 10px;
      padding-left: 2em;
      padding-right: 2em;
      padding-bottom: 0.4em;
      background-color: #171717;
      /* border-radius: 25px; */
    }



    #heading {
      text-align: center;
      margin: 2em;
      color: rgb(255, 255, 255);
      font-size: 1.2em;
    }

    .field {
      display: flex;
      align-items: center;
      width: 90%;
      justify-content: center;
      gap: 0.5em;
      border-radius: 25px;
      padding: 0.6em;
      border: none;
      outline: none;
      color: white;
      background-color: #171717;
      box-shadow: inset 2px 5px 10px rgb(5, 5, 5);
    }

    .input-icon {
      height: 1.3em;
      width: 1.3em;
      fill: white;
    }

    .input-field {
      background: none;
      border: none;
      outline: none;
      width: 100%;
      color: #d3d3d3;
    }

    .form-responsive .btn {
      display: flex;
      justify-content: center;
      flex-direction: row;
      width: 90%;
      margin-top: 2.5em;
    }

    .button1 {
      padding: 0.5em;
      padding-left: 1.1em;
      padding-right: 1.1em;
      border-radius: 5px;
      margin-right: 0.5em;
      border: none;
      outline: none;
      transition: .4s ease-in-out;
      background-color: #252525;
      color: white;
    }

    .button1:hover {
      background-color: black;
      color: white;
    }

    .button2 {
      padding: 0.5em;
      padding-left: 2.3em;
      padding-right: 2.3em;
      border-radius: 5px;
      border: none;
      outline: none;
      transition: .4s ease-in-out;
      background-color: #252525;
      color: white;
    }

    .button2:hover {
      background-color: black;
      color: white;
    }

    .button3 {
      margin-bottom: 3em;
      padding: 0.5em;
      border-radius: 5px;
      border: none;
      outline: none;
      transition: .4s ease-in-out;
      background-color: #252525;
      color: white;
    }

    .button3:hover {
      background-color: red;
      color: white;
    }

    @media screen and (max-width:920px) {
      .form-responsive {
        display: flex;
      }

      .cont {
        display: none;
      }
    }
  </style>
</head>

<body>

  <form class="form-responsive" action="sign_in_up.php" method="post" id="sign-in">
    <p id="heading">Login</p>
    <?php if (isset($error)) { ?>
      <p class="display_error" style="
            background-color: rgba(255, 0, 0, 0.371);
            text-align: center;
            color:red;
            margin-bottom:1rem;
            border-radius:4px
            "><?php echo $error_invalid; ?></p>
    <?php } ?>
    <div class="field">

      <ion-icon name="mail-outline"></ion-icon>

      <input placeholder="Enter email" class="input-field" name="email" type="email" required>
    </div>
    <div class="field">
      <ion-icon name="lock-closed-outline" class="input-icon"></ion-icon>
      <input placeholder="Password" name="password" class="input-field" type="password" required>
    </div>
    <div class="btn">
      <button class="button1" name="sign_in" type="submit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Login&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
      <button class="button2" id="sign_up_button"><a href="sign_up_page.php"> Sign Up</a></button>
    </div>
    <button class="button3">Forgot Password</button>
  </form>



  <div class="cont">
    <form class="form sign-in" action="sign_in_up.php" method="post">
      <h2>Sign In</h2>

      <label>
        <?php if (isset($error_invalid)) { ?>
          <p class="display_error" style="
            background-color: rgba(255, 0, 0, 0.371);
            text-align: center;
            color:red;
            margin-bottom:1rem;
            border-radius:4px
            "><?php echo $error_invalid; ?></p>
        <?php } ?>
        <span>Email Address</span>
        <input type="email" name="email" required>
      </label>
      <label>
        <span>Password</span>
        <input type="password" name="password" required>
      </label>
      <input class="submit" type="submit" name="sign_in" value="SIGN IN" />
      <p class="forgot-pass">Forgot Password ?</p>

      <div class="social-media">
        <ul>
          <li><img src="https://raw.githubusercontent.com/abo-elnoUr/public-assets/master/facebook.png"></li>
          <li><img src="https://raw.githubusercontent.com/abo-elnoUr/public-assets/master/twitter.png"></li>
          <li><img src="https://raw.githubusercontent.com/abo-elnoUr/public-assets/master/linkedin.png"></li>
          <li><img src="https://raw.githubusercontent.com/abo-elnoUr/public-assets/master/instagram.png"></li>
        </ul>
      </div>
    </form>

    <div class="sub-cont">
      <div class="img">
        <div class="img-text m-up">
          <h2>New here?</h2>
          <p>Sign up and discover great amount of new opportunities!</p>
        </div>
        <div class="img-text m-in">
          <h2>One of us?</h2>
          <p>If you already has an account, just sign in. We've missed you!</p>
        </div>
        <div class="img-btn">
          <span class="m-up">Sign Up</span>
          <span class="m-in">Sign In</span>
        </div>
      </div>
      <form class="form sign-up" action="sign_in_up.php" method="post" enctype="multipart/form-data" id="sign_up">
        <h2>Sign Up</h2>
        <?php if (isset($error_exist) || isset($error_match)) { ?>
          <p class="display_error" style="
            text-align: center;
            color:red;
            margin-bottom:.5rem;
            margin-top:.5rem;
            "><?php if (isset($error_exist)) {
                echo $error_exist;
              } else if (isset($error_match)) {
                echo $error_match;
              } ?></p>
        <?php } ?>

        <label>
          <span>Name</span>
          <input type="text" name="name" id="username_input" required>
        </label>
        <label>
          <span>Email</span>
          <input type="email" name="email" required>
        </label>
        <label>
          <span>Password</span>
          <input type="password" name="password" required>
        </label>
        <label>
          <span>Confirm Password</span>
          <input type="password" name="password_confirm" required>
        </label>
        <label>
          <span>DATE OF BIRTH</span>
          <input type="date" name="date_of_birth" id="">
        </label>
        <div class="input-div">
          <input class="input" name="profile_picture" type="file" accept="image/jpeg,image/png,image/jpg">
          <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor" class="icon">
            <polyline points="16 16 12 12 8 16"></polyline>
            <line y2="21" x2="12" y1="12" x1="12"></line>
            <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"></path>
            <polyline points="16 16 12 12 8 16"></polyline>
          </svg>
        </div>
        <input type="submit" name="sign_up" class="submit" value="Sign Up Now" />

      </form>
    </div>
  </div>
  <script>
    document.querySelector('.img-btn').addEventListener('click', function() {
      document.querySelector('.cont').classList.toggle('s-signup')
    });
  </script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
</body>

</html>