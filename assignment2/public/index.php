<!--
name : Group7
file name : index.php
created date : 11-10-2024
decription: Book Cataloging System
-->
<?php
session_start();
?>
<?php
// check session variable
if (isset($_SESSION['valid_user'])) {
    header("Location: ../private/main.php");
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
    <title>Assignment2 - Book Cataloging System</title>
    <!--external css stylesheet link--> 
    <link rel="stylesheet" href="/assignment2/public/stylesheet/style.css">
    <!--js link -->
    <script src="../public/scripts/main.js" defer></script>
</head>

<body>
    <?php include "../private/header.php"; ?>
    <main>
        <article>
            <?php include "../private/banner.php"; ?>
            <section class="hero">
                <!-- left side -->
                 <div class="left-column">
                    <div class="hero-text">
                        <h1>Navigate Your Library World</h1>
                        <p> Today's Reading offers a diverse collection of books to suit all tastes and preferences.
                        Discover, collect, rate, and review your favourite books. </p>
                        <p> Join our book loving community and embark on a literary adventure today!</p>
                    </div>
                    <!--stats-->
                    <div class="stats-container"> 
                        <div class="stat">
                            <h2>1Mil+</h2>
                            <p>Books</p>
                        </div>
                        <div class="stat">
                            <h2>25,000+</h2>
                            <p>Authors</p>
                        </div>
                        <div class="stat">
                            <h2>10,000+</h2>
                            <p>Users</p>
                        </div>
                    </div>
                    <!--get started button -->
                    <div class="button-container">
                        <!-- link to the signup page -->
                        <a href="../private/signup.php">
                            <button id="start" type="button">Get Started</button> 
                        </a>
                    </div>
                </div>
            <!-- right side -->
                <div class="right-column">
                    <div class="hero-image">
                        <img src="/assignment2/public/images/indexbooks.png" alt="A colourful stack of books">
                    </div>
                </div>
        </section>
        </article>
    </main>
    <?php include "../private/footer.php"; ?>
</body>
</html>