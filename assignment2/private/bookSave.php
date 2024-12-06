<!--
name : Group7
file name : bookSave.php
created date : 11-10-2024
decription: Book Cataloging System
-->
<?php
session_start();
?>

<?php
require_once('database.php');
$db = db_connect();

if (
  $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pISBN']) && isset($_SESSION['valid_email'])
  && isset($_POST['wantType'])) {  //Book save
  $isbn = $_POST['pISBN'];
  $wantType = $_POST['wantType'];
  isset($_POST['btitle']) ? $title = $_POST['btitle'] : $title = '';
  isset($_POST['startDate']) ? $startDate = $_POST['startDate'] : $startDate = '';
  isset($_POST['endDate']) ? $endDate = $_POST['endDate'] : $endDate = '';
  isset($_POST['review']) ? $review = $_POST['review'] : $review = '';
  isset($_POST['rating']) ? $rating = $_POST['rating'] : $rating = '';

  $title = htmlspecialchars($title);
  $email = $_SESSION['valid_email'];
  if (isset($_POST['delete']) && $_POST['delete'] === "X") {
    $sql = "DELETE FROM books WHERE isbn = '$isbn' AND email = '$email'";
  } else {
    $sql = "SELECT * FROM books WHERE isbn = '$isbn' AND email = '$email'";
    $result_set = mysqli_query($db, $sql);
    $result = mysqli_fetch_assoc($result_set);

    if (!$result) {
      //select the user informaion
      $sql = "INSERT INTO books(email, isbn, title, wantType, startDate, endDate, review, rating) 
          VALUES ('$email', '$isbn', '$title', '$wantType', '$startDate', '$endDate', '$review', '$rating')";
    } else {
      $sql = "UPDATE books 
               SET title = '$title',
                   wantType = '$wantType', 
                   startDate = '$startDate', 
                   endDate = '$endDate',
                   review = '$review',
                   rating = '$rating'
             WHERE email = '$email'
               AND isbn = '$isbn'
            ";
    }
  }
  $result = mysqli_query($db, $sql);
  // Validate the result
  if ($result) {
    db_disconnect($db);
    header("Location:  collection.php");
  } else {
    db_disconnect($db);
    header("Location:  search.php");
  }
} else {
  db_disconnect($db);
  header("Location:  search.php");
}
?>