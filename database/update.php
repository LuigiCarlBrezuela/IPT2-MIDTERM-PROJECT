<?php
include('database.php');

if (isset($_POST['movieID'])) {
  $movieID = $_POST['movieID'];
  $title = $_POST['title'];
  $releaseYear = $_POST['releaseYear'];
  $genre = $_POST['genre'];
  $rating = $_POST['rating'];

  // Prepare and execute the update query
  $stmt = $conn->prepare("UPDATE movies SET Title = ?, ReleaseYear = ?, Genre = ?, Rating = ? WHERE MovieID = ?");
  $stmt->bind_param("sisdi", $title, $releaseYear, $genre, $rating, $movieID);

  if ($stmt->execute()) {
    echo "Record updated successfully";
  } else {
    echo "Error updating record: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
} else {
  echo "Invalid request.";
}
?>