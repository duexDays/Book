<!--
name : Group7
file name : index.php
created date : 11-10-2024
decription: Book Cataloging System
-->
<?php
session_start();
$loginErrMsg = '';
?>

<?php
require_once('database.php');
$db = db_connect();

if (isset($_POST['email']) && isset($_POST['password'])) { //check if we post the email, password
  // If the user has just tried to log in
  $email = $_POST['email'];
  $password = $_POST['password'];

  //select the user informaion
  $sql = "SELECT * FROM users WHERE email = '$email' ";
  $result_set = mysqli_query($db, $sql);
  $result = mysqli_fetch_assoc($result_set);

  // Validate the existence of the user and password in the users table
  if ($email === $result['email'] && $password === $result['password']) {
    $_SESSION['valid_email'] = $email; // Create session variable
    $_SESSION['valid_user'] = $result['userName']; // Create session variable
    $_SESSION['valid_pass'] = $password; // Create another session variable
    db_disconnect($db);
    $loginErrMsg = '';
    header("Location:  main.php");
  } else {
    $loginErrMsg = 'X The email or password you entered is invalid';
  }
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
  <script src="../public/scripts/main.js" defer></script>
</head>

<body>
  <?php include "../private/header.php"; ?>

  <main>
    <article>
      <?php include "../private/banner.php"; ?>
      <section id="detail-container">
        <div class="form-popup" id="myForm">
          <form action="login.php" class="form-container" method="POST">
            <div class="message-container">
              <h1>Login</h1>
              <h3>Welcome to Today's Reading.</h3>
            </div>
            <div class="textfield">
              <label for="email"><b>Email</b></label>
              <input type="text" placeholder="Enter Email" name="email" required>
            </div>
            <div class="textfield">
              <label for="password"><b>Password</b></label>
              <input type="password" placeholder="Enter Password" name="password" required>
              <?php if ($loginErrMsg != '') { ?>
                <h3 class="warning"><?php echo $loginErrMsg ?></h3>
              <?php } ?>
            </div>
            <button type="submit" class="btn">Login</button>
            <button type="reset" class="btn cancel">Cancel</button>
          </form>
        </div>
      </section>
    </article>
  </main>
  <?php include "../private/footer.php"; ?>
</body>

</html>