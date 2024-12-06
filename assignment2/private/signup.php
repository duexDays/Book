<!--
name : Group7
file name : signup.php
created date : 11-10-2024
decription: Book Cataloging System
-->
<?php
session_start();
?>
<?php
require_once('database.php');
$db = db_connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])){  // If the user has just tried to sign up
  $email = $_POST['email'];
  $username = $_POST['login'];
  $password = $_POST['pass'];

  //select the user informaion
  $sql = "INSERT INTO users(`email`, `userName`, `password`) VALUES ('$email', '$username', '$password')";
  $result = mysqli_query($db, $sql);

  // Validate the result
  if ($result) {
    db_disconnect($db);
    header("Location:  login.php");
  } 
  else {
    db_disconnect($db);
  }
} 
else {
  db_disconnect($db);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="description" content="Assignment2">
  <meta name="keywords" content="Assignment2,cst8285,php">
  <meta name="author" content="Group7">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Log In - Book Cataloging System</title>
  <link rel="stylesheet" href="/assignment2/public/stylesheet/style.css">
  <link rel="stylesheet" href="/assignment2/public/stylesheet/login.css">
  <script src="../public/scripts/signup.js" defer></script>
</head>

<body>
  <?php include "../private/header.php"; ?>

  <main>
    <article>
      <?php include "../private/banner.php"; ?>
      <section id="detail-container">
        <div class="form-popup" id="myForm">
          <form action="signup.php" method="POST" class="form-container" onsubmit="return validate();">
            <div class="message-container">
              <h1>Sign Up</h1>
              <h3>Welcome to Today's Reading.</h3>
            </div>
            <div class="textfield">
              <label for="email">Email Address*</label>
              <input type="text" id="email" name="email" placeholder="Enter Email">
            </div>

            <div class="textfield">
              <label for="login">User Name*</label>
              <input type="text" name="login" id="login" placeholder="Enter User name">
            </div>

            <div class="textfield">
              <label for="pass">Password*</label>
              <input type="password" name="pass" id="pass" placeholder="Enter Password">
            </div>

            <div class="textfield">
              <label for="pass2">Re-type Password*</label>
              <input type="password" id="pass2" placeholder="Enter Password">
            </div>

            <div class="checkbox">
              <input type="checkbox" name="newsletter" id="newsletter">
              <label for="newsletter">I agree to receive Today's Reading newsletters</label>
            </div>
            <div class="checkbox">
              <input type="checkbox" name="terms" id="terms">
              <label for="terms">I agree to the terms and conditions*</label>
            </div>
            <button class="btn" type="submit">Sign Up</button>
            <button class="btn cancel" type="reset" id="Reset_btn" onclick="resetFormError();">Reset</button>
          </form>
        </div>
      </section>
    </article>
  </main>
  <?php include "../private/footer.php"; ?>
</body>

</html>