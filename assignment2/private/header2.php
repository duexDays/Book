<?php
if (! isset($_SESSION['valid_email']))
session_start();
?>
<?php
// check session variable
if (isset($_SESSION['valid_user'])) {
  $username = $_SESSION['valid_user'];
} else {
  header("Location: login.php");
}

if (isset($_GET['id'])) {

  unset($_SESSION['valid_user']); //delete session variable
  session_unset();

  session_destroy(); //kill the session
  header("Location: login.php");
}

?>
<header>
  <nav>
    <div id="logo">
      <a href="main.php" class="logo_service" title="Today's Reading">
        <img src="/assignment2/public/images/logo.png" alt="Today's Reading">
      </a>
    </div>
    <div id="menuToggle">
      <!--
  A fake / hidden checkbox is used as click reciever,
  so you can use the :checked selector on it.
  -->
      <input type="checkbox">

      <!--
  Some spans to act as a hamburger.
  -->
      <span></span>
      <span></span>
      <span></span>
      <ul id="menu">
        <li>
          <div id="logo">
            <a href="main.php" class="logo_service" title="Today's Reading">
              <img src="/assignment2/public/images/logo.png" alt="Today's Reading">
            </a>
          </div>
        </li>
        <li><a href="search.php">Book Search</a></li>
        <li><a href="collection.php">My Collection</a></li>
        <!--<li><a href="statistics.html">My Statistics</a></li>-->
        <li>
          <div class="menuButt-container">
            <form action="<?php echo 'header2.php?id=' . $_SESSION['valid_user']; ?>" method="post">
              <button type="submit" class="menuButt">Sign Out</button>
            </form>
          </div>
        </li>
      </ul>
    </div>
    <ul id="menu-horizental-list-container">
      <li>
        <a href="collection.php"><span>My Collection</span></a>
      </li>
      <!--
      <li>
        <a href="explore.html"><span>Explore</span></a>
      </li>
-->
    </ul>
    <form action="search.php" method="post" id="searchForm">
      <div id="search">
        <?php isset($_POST['searchBook']) ? $value = $_POST['searchBook'] :$value = '';?>
        <input type="text" placeholder="Enter title, author, genre..." id="searchBook" name="searchBook" value="<?php echo $value ?>">
      </div>
    </form>
    <div id="menuRight">
      <div id="welcome-container">
        <p>Welcome, <?php echo ($username); ?></p>
      </div>
      <!--
      <div class="menuButt-container">
        <a class="menuButt" type="button" target="_self" href="/assignment2/public/index.php">Log Out</a>
      </div>
-->
    </div>
  </nav>
</header>