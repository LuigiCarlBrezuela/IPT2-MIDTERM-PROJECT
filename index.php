<?php
  include('partials\header.php');
  include('partials\sidebar.php');
  include('database/database.php'); // Include the database connection file
  
  // Fetch movie datas from the databases
  $sql = "SELECT * FROM movies";
  $movies = $conn->query($sql);

  // Check for query execution errors
  if ($movies === false) {
      die("Error executing query: " . $conn->error);
  }
?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1> Movie Information Management System</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item">Tables</li>
        <li class="breadcrumb-item active">General</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h5 class="card-title">Default Table</h5>
              </div>
              <div>
                <button class="btn btn-primary btn-sm mt-4 mx-3" data-bs-toggle="modal" data-bs-target="#addDataModal">Add Data</button>
              </div>
            </div>

            <!-- Default Table -->
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Title</th>
                  <th scope="col">Release Year</th>
                  <th scope="col">Genre</th>
                  <th scope="col">Rating</th>
                  <th scope="col" class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($movies->num_rows > 0): ?>
                  <?php while($row = $movies->fetch_assoc()): ?>
                    <tr id="movieRow<?php echo $row['MovieID']; ?>">
                      <th scope="row"><?php echo $row['MovieID']; ?></th>
                      <td id="title<?php echo $row['MovieID']; ?>"><?php echo $row['Title']; ?></td>
                      <td id="releaseYear<?php echo $row['MovieID']; ?>"><?php echo $row['ReleaseYear']; ?></td>
                      <td id="genre<?php echo $row['MovieID']; ?>"><?php echo $row['Genre']; ?></td>
                      <td id="rating<?php echo $row['MovieID']; ?>"><?php echo $row['Rating']; ?></td>
                      <td class="d-flex justify-content-center">
                        <button class="btn btn-success btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#editDataModal<?php echo $row['MovieID']; ?>">Edit</button>
                        <button class="btn btn-primary btn-sm mx-1" title="View Movie Information" data-bs-toggle="modal" data-bs-target="#viewDataModal<?php echo $row['MovieID']; ?>">View</button>
                        <button class="btn btn-danger btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#deleteInfo<?php echo $row['MovieID']; ?>">Delete</button>
                        
                        <!-- Edit Modal -->
                        <div class="modal fade" id="editDataModal<?php echo $row['MovieID']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editDataModalLabel<?php echo $row['MovieID']; ?>" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-5" id="editDataModalLabel<?php echo $row['MovieID']; ?>">Edit Movie</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form id="editMovieForm<?php echo $row['MovieID']; ?>" onsubmit="updateMovie(event, <?php echo $row['MovieID']; ?>)">
                                <div class="modal-body">
                                  <input type="hidden" id="editMovieID<?php echo $row['MovieID']; ?>" name="movieID" value="<?php echo $row['MovieID']; ?>">
                                  <div class="mb-3">
                                    <label for="editTitle<?php echo $row['MovieID']; ?>" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="editTitle<?php echo $row['MovieID']; ?>" name="title" value="<?php echo $row['Title']; ?>" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="editReleaseYear<?php echo $row['MovieID']; ?>" class="form-label">Release Year</label>
                                    <input type="number" class="form-control" id="editReleaseYear<?php echo $row['MovieID']; ?>" name="releaseYear" value="<?php echo $row['ReleaseYear']; ?>" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="editGenre<?php echo $row['MovieID']; ?>" class="form-label">Genre</label>
                                    <input type="text" class="form-control" id="editGenre<?php echo $row['MovieID']; ?>" name="genre" value="<?php echo $row['Genre']; ?>" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="editRating<?php echo $row['MovieID']; ?>" class="form-label">Rating</label>
                                    <input type="number" step="0.1" class="form-control" id="editRating<?php echo $row['MovieID']; ?>" name="rating" value="<?php echo $row['Rating']; ?>" required>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                        <!-- View Modal -->
                        <div class="modal fade" id="viewDataModal<?php echo $row['MovieID']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewDataModalLabel<?php echo $row['MovieID']; ?>" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-5" id="viewDataModalLabel<?php echo $row['MovieID']; ?>">View Movie</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="mb-3">
                                  <label for="viewTitle<?php echo $row['MovieID']; ?>" class="form-label">Title</label>
                                  <input type="text" class="form-control" id="viewTitle<?php echo $row['MovieID']; ?>" value="<?php echo $row['Title']; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                  <label for="viewReleaseYear<?php echo $row['MovieID']; ?>" class="form-label">Release Year</label>
                                  <input type="number" class="form-control" id="viewReleaseYear<?php echo $row['MovieID']; ?>" value="<?php echo $row['ReleaseYear']; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                  <label for="viewGenre<?php echo $row['MovieID']; ?>" class="form-label">Genre</label>
                                  <input type="text" class="form-control" id="viewGenre<?php echo $row['MovieID']; ?>" value="<?php echo $row['Genre']; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                  <label for="viewRating<?php echo $row['MovieID']; ?>" class="form-label">Rating</label>
                                  <input type="number" step="0.1" class="form-control" id="viewRating<?php echo $row['MovieID']; ?>" value="<?php echo $row['Rating']; ?>" disabled>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        
                        <!-- delete modal -->
                        <div class="modal fade" id="deleteInfo<?php echo $row['MovieID']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteInfoLabel<?php echo $row['MovieID']; ?>" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-5" id="deleteInfoLabel<?php echo $row['MovieID']; ?>">Delete Movie</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                Are you sure you want to delete the movie "<?php echo $row['Title']; ?>"?
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger" onclick="deleteMovie(<?php echo $row['MovieID']; ?>)">Delete</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="text-center">No movies found</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
            <!-- End Default Table Example -->
          </div>
          <div class="mx-4">
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
              </ul>
            </nav>
          </div>
        </div>

      </div>

    </div>

    <!-- Add Data Modal -->
    <div class="modal fade" id="addDataModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addDataModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="addDataModalLabel">Add Movie</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="database/create.php" method="POST">
            <div class="modal-body">
              <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
              </div>
              <div class="mb-3">
                <label for="releaseYear" class="form-label">Release Year</label>
                <input type="number" class="form-control" id="releaseYear" name="releaseYear" required>
              </div>
              <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" required>
              </div>
              <div class="mb-3">
                <label for="rating" class="form-label">Rating</label>
                <input type="number" step="0.1" class="form-control" id="rating" name="rating" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </section>

</main><!-- End #main -->
<?php
include('partials\footer.php');
?>



