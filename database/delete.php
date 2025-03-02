<?php
include('database.php');

if (isset($_POST['movieID'])) {
  $movieID = $_POST['movieID'];

  // Prepare and execute the delete query
  $stmt = $conn->prepare("DELETE FROM movies WHERE MovieID = ?");
  $stmt->bind_param("i", $movieID);

  if ($stmt->execute()) {
    echo "Movie deleted successfully.";
  } else {
    echo "Error deleting movie: " . $conn->error;
  }

  $stmt->close();
  $conn->close();
} else {
  echo "Invalid request.";
}
?>