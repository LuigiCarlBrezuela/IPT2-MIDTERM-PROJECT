function deleteMovie(movieID) {
    if (confirm("Are you sure you want to delete this movie?")) {
      // Create an AJAX request
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "database/delete.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  
      // Define what happens on successful data submission
      xhr.onload = function () {
        if (xhr.status === 200) {
          // Check if the response contains a success message
          if (xhr.responseText.includes("Movie deleted successfully.")) {
            // Remove the movie row from the table
            var row = document.getElementById("movieRow" + movieID);
            row.parentNode.removeChild(row);
            alert("Movie deleted successfully.");
            
            // Reload the page
            location.reload();
          } else {
            alert("An error occurred while deleting the movie: " + xhr.responseText);
          }
        } else {
          alert("An error occurred while deleting the movie.");
        }
      };
  
      // Define what happens in case of error
      xhr.onerror = function () {
        alert("An error occurred while deleting the movie.");
      };
  
      // Set up our request
      xhr.send("movieID=" + movieID);
    }
  }
  
  function updateMovie(event, movieID) {
    event.preventDefault();
    var form = document.getElementById("editMovieForm" + movieID);
    var formData = new FormData(form);
  
    // Create an AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "database/update.php", true);
  
    // Define what happens on successful data submission
    xhr.onload = function () {
      if (xhr.status === 200) {
        // Check if the response contains a success message
        if (xhr.responseText.includes("Record updated successfully")) {
          // Update the table row with the new data
          document.getElementById("title" + movieID).innerText = formData.get("title");
          document.getElementById("releaseYear" + movieID).innerText = formData.get("releaseYear");
          document.getElementById("genre" + movieID).innerText = formData.get("genre");
          document.getElementById("rating" + movieID).innerText = formData.get("rating");
          alert("Movie updated successfully.");
          // Close the modal
          var modal = document.getElementById("editDataModal" + movieID);
          var modalInstance = bootstrap.Modal.getInstance(modal);
          modalInstance.hide();
          
          // Reload the page
          location.reload();
        } else {
          alert("An error occurred while updating the movie: " + xhr.responseText);
        }
      } else {
        alert("An error occurred while updating the movie.");
      }
    };
  
    // Define what happens in case of error
    xhr.onerror = function () {
      alert("An error occurred while updating the movie.");
    };
  
    // Set up our request
    xhr.send(formData);
  }