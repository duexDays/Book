<!--
name : Group7
file name : index.php
created date : 11-10-2024
decription: Book Cataloging System
-->
<?php
if (!isset($_SESSION['valid_email']))
    session_start();
?>
<?php
require_once('database.php');
$db = db_connect();
$email = $_SESSION['valid_email'];
$sql = "SELECT * FROM books WHERE email = '$email'";
$result_set = mysqli_query($db, $sql);

$total = $result_set->num_rows;
db_disconnect($db);
$book = array();
$want1 = 0;
$want2 = 0;
$want3 = 0;
foreach ($result_set as $row) {
    $item = array();
    if (isset($row["isbn"])) {
        $url = "https://www.googleapis.com/books/v1/volumes?q=isbn:" . $row["isbn"];
        $apiKey = 'AIzaSyDqH65mzBQxl4Hlvakx6zebbylLnrpL7Sg';
        $url .= '&apiKey=' . $apiKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);
        if ($response) {
            $data = json_decode($response, true);
        }

    }
    $item += ['isbn' => $row['isbn']];
    $item += ['title' => $row['title']];
    $item += ['wantType' => $row['wantType']];
    if ($row['wantType'] === '1')
        $want1++;
    if ($row['wantType'] === '2')
        $want2++;
    if ($row['wantType'] === '3')
        $want3++;
    $item += ['startDate' => substr($row['startDate'], 0, 10)];
    $item += ['endDate' => substr($row['endDate'], 0, 10)];
    $item += ['review' => $row['review']];
    $item += ['rating' => $row['rating']];
    if (isset($data['totalItems']) && $data['totalItems'] > 0) {
        if (isset($data['items'][0]['volumeInfo']['authors'])) {
            $item += ['authors' => implode(', ', $data['items'][0]['volumeInfo']['authors'])];
        } else {
            $item += ['authors' => ''];
        }
        if (isset($data['items'][0]['volumeInfo']['description'])) {
            $item += ['description' => $data['items'][0]['volumeInfo']['description']];
        } else {
            $item += ['description' => ''];
        }
        if (isset($data['items'][0]['volumeInfo']['publisher'])) {
            $item += ['publisher' => $data['items'][0]['volumeInfo']['publisher']];
        } else {
            $item += ['publisher' => ''];
        }
        if (isset($data['items'][0]['volumeInfo']['imageLinks']['thumbnail'])) {
            $item += ['image' => $data['items'][0]['volumeInfo']['imageLinks']['thumbnail']];
        } else {
            $item += ['image' => ''];
        }
    } else {
        $item += ['authors' => ''];
        $item += ['description' => ''];
        $item += ['publisher' => ''];
        $item += ['image' => ''];
    }
    array_push($book, $item);
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
    <link rel="stylesheet" href="/assignment2/public/stylesheet/style.css">
    <link rel="stylesheet" href="/assignment2/public/stylesheet/header.css">
    <link rel="stylesheet" href="/assignment2/public/stylesheet/search.css">
    <link rel="stylesheet" href="/assignment2/public/stylesheet/collection.css">
    <link rel="stylesheet" href="/assignment2/public/stylesheet/empty.css">
    <script src="../public/scripts/collection.js" defer></script>
</head>

<body>
    <?php include "header2.php"; ?>
    <main>
        <article>
            <div id="article-title-container">
                <span>The Collection of <?php echo $_SESSION['valid_user']; ?>: Total <?php echo $total; ?> </span>
            </div>
            <?php if (empty($book)) { ?>
                <div class="empty">
                <img src="/assignment2/public/images/collection.png" alt="Today's Reading">
                Your collection is empty.
                </div>
            <?php } else { ?>
                <?php if ($want2 > 0) { ?>
                    <div id="article-subtitle-container">
                        <span>Book of Reading</span>
                    </div>
                <?php } ?>
                <?php
                foreach ($book as $row) {
                    if ($row['wantType'] == '2') {
                        isset($row['title']) ? $title = htmlspecialchars($row['title']) : $title = "";
                        isset($row['isbn']) ? $ISBN = $row['isbn'] : $ISBN = "";
                        isset($row['image']) ? $image = $row['image'] : $image = "";
                        isset($row['publisher']) ? $publisher = $row['publisher'] : $publisher = "";
                        isset($row['description']) ? $description = $row['description'] : $description = "";
                        isset($row['authors']) ? $authors = $row['authors'] : $authors = "";
                        isset($row['startDate']) ? $startDate = $row['startDate'] : $startDate = "";
                        isset($row['endDate']) ? $endDate = $row['endDate'] : $endDate = "";
                        isset($row['review']) ? $review = htmlspecialchars($row['review']) : $review = "";
                        isset($row['rating']) ? $rating = $row['rating'] : $rating = "";
                        preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $title);

                        ?>
                        <div id="center-layout-container">

                            <section class="content-unit-container">
                                <div class="card-type-1" id="<?php echo $ISBN; ?>"
                                    onclick='openBookForm("<?php echo $title; ?>", "<?php echo $ISBN; ?>", "2", 
                                "<?php echo $startDate; ?>", "<?php echo $endDate; ?>", "<?php echo $review; ?>", "<?php echo $rating; ?>")'>
                                    <div class="image1">
                                        <img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" width="150">
                                    </div>
                                    <div class="book-information">
                                        <ul>
                                            <li class="title"><?php echo $title; ?></li>
                                            <li class="author"><?php echo $publisher; ?> •
                                                by <?php echo $authors; ?></li>
                                            <li class="description"><?php echo $description; ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </section>
                            <div class="line"></div>
                        </div>
                        <?php
                    }
                }
                ?>

                <?php if ($want3 > 0) { ?>
                    <div id="article-subtitle-container">
                        <span>Book of Want</span>
                    </div>
                <?php } ?>

                <?php
                foreach ($book as $row) {
                    if ($row['wantType'] == '3') {
                        isset($row['title']) ? $title = $row['title'] : $title = "";
                        isset($row['isbn']) ? $ISBN = $row['isbn'] : $ISBN = "";
                        isset($row['image']) ? $image = $row['image'] : $image = "";
                        isset($row['publisher']) ? $publisher = $row['publisher'] : $publisher = "";
                        isset($row['description']) ? $description = $row['description'] : $description = "";
                        isset($row['authors']) ? $authors = $row['authors'] : $authors = "";
                        isset($row['startDate']) ? $startDate = $row['startDate'] : $startDate = "";
                        isset($row['endDate']) ? $endDate = $row['endDate'] : $endDate = "";
                        isset($row['review']) ? $review = $row['review'] : $review = "";
                        isset($row['rating']) ? $rating = $row['rating'] : $rating = "";
                        isset($row['wantType']) ? $wantType = $row['wantType'] : $wantType = "";
                        ?>
                        <div id="center-layout-container">
                            <section class="content-unit-container">
                                <div class="card-type-1" id="<?php echo $ISBN; ?>"
                                    onclick='openBookForm("<?php echo $title; ?>", "<?php echo $ISBN; ?>", "<?php echo $wantType; ?>", 
                                "<?php echo $startDate; ?>", "<?php echo $endDate; ?>", "<?php echo $review; ?>", "<?php echo $rating; ?>")'>
                                    <div class="image1">
                                        <img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" width="150">
                                    </div>
                                    <div class="book-information">
                                        <ul>
                                            <li class="title"><?php echo $title; ?></li>
                                            <li class="author"><?php echo $publisher; ?> •
                                                by <?php echo $authors; ?></li>
                                            <li class="description"><?php echo $description; ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </section>
                            <div class="line"></div>
                        </div>
                        <?php
                    }
                }
                ?>

                <?php if ($want1 > 0) { ?>
                    <div id="article-subtitle-container">
                        <span>Book of Completed</span>
                    </div>
                <?php } ?>
                <?php
                foreach ($book as $row) {
                    if ($row['wantType'] == '1') {
                        isset($row['title']) ? $title = $row['title'] : $title = "";
                        isset($row['isbn']) ? $ISBN = $row['isbn'] : $ISBN = "";
                        isset($row['image']) ? $image = $row['image'] : $image = "";
                        isset($row['publisher']) ? $publisher = $row['publisher'] : $publisher = "";
                        isset($row['description']) ? $description = $row['description'] : $description = "";
                        isset($row['authors']) ? $authors = $row['authors'] : $authors = "";
                        isset($row['startDate']) ? $startDate = $row['startDate'] : $startDate = "";
                        isset($row['endDate']) ? $endDate = $row['endDate'] : $endDate = "";
                        isset($row['review']) ? $review = $row['review'] : $review = "";
                        isset($row['rating']) ? $rating = $row['rating'] : $rating = "";
                        ?>
                        <div id="center-layout-container">
                            <section class="content-unit-container">
                                <div class="card-type-1" id="<?php echo $ISBN; ?>"
                                    onclick='openBookForm("<?php echo $title; ?>", "<?php echo $ISBN; ?>", "1", 
                                "<?php echo $startDate; ?>", "<?php echo $endDate; ?>", "<?php echo $review; ?>", "<?php echo $rating; ?>")'>
                                    <div class="image1">
                                        <img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" width="150">
                                    </div>
                                    <div class="book-information">
                                        <ul>
                                            <li class="title"><?php echo $title; ?></li>
                                            <li class="author"><?php echo $publisher; ?> •
                                                by <?php echo $authors; ?></li>
                                            <li class="description"><?php echo $description; ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </section>
                            <div class="line"></div>
                        </div>
                        <?php
                    }
                }
            }
            ?>
        </article>
    </main>
    <?php include "footer.php"; ?>
    <?php include "bookEdit.php"; ?>
</body>