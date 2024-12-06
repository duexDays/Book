<div class="empty">
    <iput type="hidden" id="code" name="code">
    <?php
    if (isset($_GET["code"])) {
        $code = $_GET["code"];
        if ($code == "1") {  //collection empty
            ?>
            "Your collection is empty. Collect your books"
            <?php
        } elseif ($code == "2") { //initial search page
            ?>
            "Search for books and Collect it"
            <?php
        } elseif ($code == "2") { //no result search page
            ?>
            "No Result. Try again"
            <?php
        }
    }
    ?>
</div>