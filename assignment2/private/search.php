<!--
name : Group7
file name : index.php
created date : 11-10-2024
decription: Book Cataloging System
-->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['searchBook'])) {
    $keyword = $_POST['searchBook'];
    $keyword = preg_replace("/\s+/", "%20", $keyword);
    $url = "https://www.googleapis.com/books/v1/volumes?q=$keyword";
    if (isset($_POST['ktitle'])) {
        $ktitle = $_POST['ktitle'];
        $ktitle = preg_replace("/\s+/", "%20", $ktitle);
        if ($ktitle != "")
            $url .= '+intitle:' . $ktitle;
    }
    if (isset($_POST['kauthor'])) {
        $kauthor = $_POST['kauthor'];
        $kauthor = preg_replace("/\s+/", "%20", $kauthor);
        if ($kauthor != "")
            $url .= '+inauthor:' . $kauthor;
    }

    if (isset($_POST['subject'])) {
        $subject = $_POST['subject'];
        $subject = preg_replace("/\s+/", "%20", $subject);
        if ($subject != "All")
            $url .= '+subject:' . $subject;
    }

    $apiKey = 'AIzaSyDqH65mzBQxl4Hlvakx6zebbylLnrpL7Sg';
    $url .= '&key=' . $apiKey;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);
    if ($response) {
        $data = json_decode($response, true);
    }
    /*else {
        echo "API request fail\n";
    }
    */
    $subject_array = [];

    if (!empty($data) && $data["totalItems"] != "0") {
        if (isset($data) && count($data) > 0) {
            foreach ($data['items'] as $item) {
                if (array_key_exists('categories', $item['volumeInfo'])) {
                    foreach ($item['volumeInfo']['categories'] as $value) {
                        if (!in_array($value, $subject_array))
                            array_push($subject_array, $value);
                    }
                }
            }
        }
    }
}

?>
<?php
function dynamic_select($the_array, $element_name, $initial_value): string
{
    $result = '';
    $curr_val = '';
    if (isset($_REQUEST[$element_name])) {
        $curr_val = $_REQUEST[$element_name];
    } else {
        $curr_val = $initial_value;
    }
    foreach ($the_array as $value) {
        $result .= '<option value="' . (string) $value . '"';
        if ($value === $curr_val)
            $result .= ' selected="selected"';
        $result .= '>' . (string) $value . '</option>';
    }
    return $result;
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
    <link rel="stylesheet" href="/assignment2/public/stylesheet/empty.css">
    <script src="../public/scripts/search.js" defer></script>
</head>

<body>
    <?php include "header2.php"; ?>
    <main>
        <article>
            <div id="article-search-container">
                <div id="center-layout">
                    <form action="search.php" method="post" id="filterForm">
                        <?php isset($_POST['searchBook']) ? $value = $_POST['searchBook'] : $value = ''; ?>
                        <input type="hidden" id="searchBook" name="searchBook" value="<?php echo $value ?>">
                        <div class="search-type">
                            <div class="filter-title">
                                <label for="ktitle">Title</label>
                                <?php isset($_POST['ktitle']) ? $value = $_POST['ktitle'] : $value = ''; ?>
                                <input type="text" id="ktitle" name="ktitle" value="<?php echo $value ?>"
                                    placeholder="Enter Title">
                            </div>
                            <div class="filter-author">
                                <label for="kauthor">Author</label>
                                <?php isset($_POST['kauthor']) ? $value = $_POST['kauthor'] : $value = ''; ?>
                                <input type="text" id="kauthor" name="kauthor" value="<?php echo $value ?>"
                                    placeholder="Enter Author">
                            </div>
                            <div class="filter-category">
                                <label for="subject">Genre</label>
                                <select name="subject" id="subject" onchange="this.form.submit()">
                                    <option>All</option>
                                    <?php isset($_POST['subject']) ? $value = $_POST['subject'] : $value = ''; ?>
                                    <?php
                                    echo dynamic_select($subject_array, 'subject', $value);
                                    ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php
            if (empty($data) || $data["totalItems"] == "0") { ?>
                <div class="empty">
                    <img src="/assignment2/public/images/search_empty.jpg" alt="Today's Reading" width="100">
                    <p>Search book and Collect it.</p>
                </div>
                <?php
            } else {
                $index = 0;
                $rindex = 0;
                if (isset($data) && $data["totalItems"] != "0") {
                    foreach ($data['items'] as $item) {

                        if (array_key_exists('industryIdentifiers', $item['volumeInfo'])) {
                            $key = array_search('ISBN_13', array_column($item['volumeInfo']['industryIdentifiers'], 'type'));
                            if ($key == 0 or $key == 1) {
                                array_key_exists('title', $item['volumeInfo']) ? $title = htmlspecialchars($item['volumeInfo']['title'], ENT_QUOTES) : $title = '';
                                array_key_exists('authors', $item['volumeInfo']) ? $authors = $item['volumeInfo']['authors'][0] : $authors = '';
                                array_key_exists('description', $item['volumeInfo']) ? $description = $item['volumeInfo']['description'] : $description = '           ';
                                array_key_exists('imageLinks', $item['volumeInfo']) ? $image = $item['volumeInfo']['imageLinks']['thumbnail'] : $image = '';
                                array_key_exists('industryIdentifiers', $item['volumeInfo']) ? $ISBN = $item['volumeInfo']['industryIdentifiers'][$key]['identifier'] : $ISBN = '';
                                array_key_exists('publisher', $item['volumeInfo']) ? $publisher = $item['volumeInfo']['publisher'] : $publisher = '';
                                array_key_exists('publishedDate', $item['volumeInfo']) ? $publisherDate = $item['volumeInfo']['publishedDate'] : $publisherDate = '';
                                $index++;
                                ?>
                                <?php
                                if ($ISBN != '') {
                                    if ($index == 1) {
                                        ?>
                                        <div id="center-layout-container">
                                            <div id="center-layout">
                                                <span class="content-unit-title">Result of Search for <?php echo $_POST['searchBook']; ?></span>
                                                <?php
                                    }
                                    ?>
                                            <section class="content-unit-container">
                                                <div class="card-type-1" id="<?php echo $ISBN; ?>"
                                                    onclick='openBookForm("<?php echo $title; ?>", "<?php echo $ISBN; ?>")'>
                                                    <div class="image1">
                                                        <img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" width="150">
                                                    </div>
                                                    <div class="book-information">
                                                        <ul>
                                                            <li class="title"><?php echo $title; ?></li>
                                                            <li class="author"><?php echo $publisher; ?> • <?php echo $publisherDate; ?> •
                                                                by <?php echo $authors; ?></li>
                                                            <li class="description"><?php echo $description; ?></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </section>
                                            <div class="line"></div>
                                            <?php
                                            if ($index == 0) {
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                            }
                                }
                            }
                        }
                        $rindex++;
                    }
                }
            }
            ?>
        </article>
    </main>
    <?php include "footer.php"; ?>
    <?php include "bookPopup.php"; ?>
</body>