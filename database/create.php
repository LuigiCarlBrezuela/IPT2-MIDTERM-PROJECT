<?php
include(__DIR__ . '/database.php'); // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $releaseYear = $_POST['releaseYear'];
    $genre = $_POST['genre'];
    $rating = $_POST['rating'];

    $sql = "INSERT INTO movies (Title, ReleaseYear, Genre, Rating) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisi", $title, $releaseYear, $genre, $rating);

    if ($stmt->execute()) {
        header("Location: ../index.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>