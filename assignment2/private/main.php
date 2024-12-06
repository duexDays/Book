<!--
name : Group7
file name : main.php
created date : 11-10-2024
decription: Book Cataloging System
-->
<?php
session_start();
require_once('database.php');
$db = db_connect();

$user_email = $_SESSION['valid_email'];

$saved_books = [];
$recommendations_data = [];
$discover_data = [];

$sql = "SELECT * FROM books WHERE email = '$user_email'"; 
$result_set = mysqli_query($db, $sql);

// If user has saved books, fetch them
if ($result_set && mysqli_num_rows($result_set) > 0) {
    $saved_books = mysqli_fetch_all($result_set, MYSQLI_ASSOC);
}

// Generate search queries for Google Books API based on titles or genres of the saved books
$genres = [];
$authors = [];

foreach ($saved_books as $book) {
    if (!empty($book['title'])) {
        $genres[] = urlencode($book['title']);
    }
}

$genres = array_unique($genres);

$query = '';
if ($genres) {
    $query .= 'intitle:' . implode('+OR+', $genres);
}

$query = urlencode($query);

// Fetch recommendations if the user has saved books
if (!empty($saved_books)) {
    $google_books_url = "https://www.googleapis.com/books/v1/volumes?q=$query&maxResults=6&langRestrict=en";
    $response = file_get_contents($google_books_url);
    $recommendations_data = json_decode($response, true);
}

// Fetch random books for the Discover section
$discover_books_url = "https://www.googleapis.com/books/v1/volumes?q=*&maxResults=6&langRestrict=en";
$discover_response = file_get_contents($discover_books_url);
$discover_data = json_decode($discover_response, true);

$recommended_books = [];
if (isset($recommendations_data['items'])) {
    foreach ($recommendations_data['items'] as $item) {
        $authors = isset($item['volumeInfo']['authors']) && is_array($item['volumeInfo']['authors']) 
            ? implode(', ', $item['volumeInfo']['authors']) 
            : (isset($item['volumeInfo']['authors']) ? $item['volumeInfo']['authors'] : 'Unknown Author');

        $recommended_books[] = [
            'title' => $item['volumeInfo']['title'],
            'author' => $authors,
            'description' => isset($item['volumeInfo']['description']) ? $item['volumeInfo']['description'] : 'No description available.',
            'image' => isset($item['volumeInfo']['imageLinks']['thumbnail']) ? $item['volumeInfo']['imageLinks']['thumbnail'] : '',
        ];
    }
}

$discover_books = [];
if (isset($discover_data['items'])) {
    foreach ($discover_data['items'] as $item) {
        $authors = isset($item['volumeInfo']['authors']) && is_array($item['volumeInfo']['authors']) 
            ? implode(', ', $item['volumeInfo']['authors']) 
            : (isset($item['volumeInfo']['authors']) ? $item['volumeInfo']['authors'] : 'Unknown Author');

        $discover_books[] = [
            'title' => $item['volumeInfo']['title'],
            'author' => $authors,
            'description' => isset($item['volumeInfo']['description']) ? $item['volumeInfo']['description'] : 'No description available.',
            'image' => isset($item['volumeInfo']['imageLinks']['thumbnail']) ? $item['volumeInfo']['imageLinks']['thumbnail'] : '',
        ];
    }
}

db_disconnect($db);
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
    <link rel="stylesheet" href="/assignment2/public/stylesheet/main.css">
    <script src="../public/scripts/header.js" defer></script>
</head>

<body>
    <?php include "header2.php"; ?>
    <main>
        <?php if (!empty($saved_books)): ?>
            <section class="main-rec">
            <h2>Recommended Books for You</h2>
            <?php if (!empty($recommended_books)): ?>
                <div class="recommended-books">
                <?php foreach ($recommended_books as $book): ?>
                    <div class="book">
                        <div class="book-container">
                            <div class="images">
                                <img src="<?php echo $book['image']; ?>" alt="Book Image" width="100">
                            </div>
                            <div class="book-info">
                                <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                                <p><strong>Author:</strong> 
                                    <?php
                                    $author = isset($book['author']) ? (is_array($book['author']) ? implode(', ', $book['author']) : $book['author']) : 'Unknown Author';
                                    echo htmlspecialchars($author); 
                                    ?>
                                </p>
                                <p class="description"><?php echo htmlspecialchars($book['description']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No recommendations available based on your saved books.</p>
            <?php endif; ?>
            </section>
        <?php endif; ?>

        <section class="main-discover">
        <h2>Discover Books</h2>
        <div class="discover-books">
            <?php foreach ($discover_books as $book): ?>
                <div class="book">
                    <div class="book-container">
                        <div class="images">
                            <img src="<?php echo $book['image']; ?>" alt="Book Image" width="100">
                        </div>
                        <div class="book-info">
                            <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                            <p><strong>Author:</strong> 
                                <?php
                                $author = isset($book['author']) ? (is_array($book['author']) ? implode(', ', $book['author']) : $book['author']) : 'Unknown Author';
                                echo htmlspecialchars($author); 
                                ?>
                            </p>
                            <p class="description"><?php echo htmlspecialchars($book['description']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        </section>
    </main>
    <?php include "footer.php"; ?>
</body>
</html>