<?php
session_start();

// Check if the logout request has been made
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Main Page</title>
  <!-- Bootstrap CSS link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome link -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    /* Custom CSS for centering the card */
    .navbar-icon {
      margin-left: auto; /* Push the icon to the right */
      margin-right: 10px; /* Add margin to separate from the logout button */
      color: #fff; /* White color */
    }
    /* Custom CSS for centering the card */
    .navbar {
      background-color: #000; /* Black background */
    }
    .navbar-brand,
    .navbar-nav .nav-link {
      color: #fff !important; /* White text */
    }
    .navbar-nav {
      width: calc(100% - 36px); /* Full width minus the width of the icon */
      margin-left: 20px; /* Half the width of the icon to center it */
    }
    .navbar-nav .nav-link {
      text-align: center; /* Center text */
    }
    /* Custom CSS for full-width image */
    .image-container {
      position: fixed;
      top: 56px; /* Adjusted to add a gap between navigation and carousel */
      left: 0;
      width: 100%;
      height: calc(100% - 56px); /* Full height minus the height of the navbar */
      overflow: hidden;
    }
    .image-container img {
      width: 100%;
      height: 100%;
      object-fit: cover; /* Maintain aspect ratio and cover entire container */
    }
    .logout-btn {
      margin-left: 10px; /* Add margin to the left of the logout button */
    }
    /* Custom CSS for adjusting carousel size */
    .carousel-item img {
      max-height: 500px; /* Adjust the height as needed */
      width: auto; /* Maintain aspect ratio */
      margin: auto; /* Center the image horizontally */
    }

    .carousel-control-prev,
    .carousel-control-next {
      height: 100%; /* Adjust the height of the controls */
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">SpeechWell</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link" href="tableAdmin.php">User</a>
          <a class="nav-link" href="graf.php">Graf</a>
          <a class="nav-link" href="resultAdmin.php">Result</a>
        </div>
      </div>
      <form action="" method="POST" style="display: inline;">
        <button class="btn btn-outline-success logout-btn" type="submit" name="logout">Logout</button>
      </form>
      <li>
      <a href="#" class="navbar-icon"><i class="far fa-user-circle" style="font-size:30px;"></i></a>
    </div>
  </nav>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
