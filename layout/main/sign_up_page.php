<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    *{
        margin: 0;
        padding: 0;

    }
    body{
        display: flex;
        justify-content: center;
        align-items: center;
        margin: auto;
    }
    .form-responsive {
      width: 100svw;
      height: 100svh;
      display: flex;
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

    .input-div {
  position: relative;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  border: 2px solid rgb(1, 235, 252);
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
  box-shadow: 0px 0px 100px rgb(1, 235, 252) , inset 0px 0px 10px rgb(1, 235, 252),0px 0px 5px rgb(255, 255, 255);
}

.icon {
  color: rgb(1, 235, 252);
  font-size: 2rem;
  cursor: pointer;
}

.input {
  position: absolute;
  opacity: 0;
  width: 100%;
  height: 100%;
  cursor: pointer !important;
}


    </style>
</head>
<body>
<form class="form-responsive"  action="sign_up.php" method="post" enctype="multipart/form-data" id="sign_up">
    <p id="heading">Sign up</p>
    <div class="field">
      <ion-icon name="person-outline" class="input-icon"></ion-icon>
      <input autocomplete="off" placeholder="name" name="name" class="input-field" type="text" required>
    </div>
    <div class="field">
    <ion-icon name="mail-outline"></ion-icon>
      <input placeholder="Enter email" class="input-field" name="email" type="email" required>
    </div>
    <div class="field">
    <ion-icon name="lock-closed-outline" class="input-icon"></ion-icon>
      <input placeholder="Password" class="input-field" name="password" type="password" required>
    </div>
    <div class="field">
    <ion-icon name="lock-closed-outline" class="input-icon"></ion-icon>
      <input placeholder="Enter password again" class="input-field" name="password_confirm" type="password" required>
    </div>
    <div class="field">
    <ion-icon name="calendar-outline"></ion-icon>
      <input class="input-field" name="date_of_birth" type="date" required>
    </div>
    <div class="input-div">
  <input class="input" name="profile_picture" type="file">
<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor" class="icon"><polyline points="16 16 12 12 8 16"></polyline><line y2="21" x2="12" y1="12" x1="12"></line><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"></path><polyline points="16 16 12 12 8 16"></polyline></svg>
</div>
    <div class="btn">
      <button class="button1" name="sign_up" type="submit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sign up&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
      <button class="button2"><a href="sign_in_up.php">Login</a></button>
    </div>
    <button class="button3">Forgot Password</button>
  </form>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>

</body>
</html>