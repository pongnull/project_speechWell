<?php
session_start(); // Start the session

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['userID']; // Retrieve userID from session
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
    .navbar-icon {
      margin-left: auto; /* Push the icon to the right */
      margin-right: 10px; /* Add margin to separate from the logout button */
      color: #fff; /* White color */
    }
    .navbar {
      background-color: #000; /* Black background */
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1000;
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
    .logout-btn {
      margin-left: 10px; /* Add margin to the left of the logout button */
    }
    .carousel {
      position: fixed;
      top: 56px; /* Height of the navbar */
      left: 0;
      width: 100%;
      height: calc(100% - 56px); /* Full height minus the height of the navbar */
      z-index: 1;
    }
    .carousel-inner {
      height: 100%;
    }
    .carousel-item {
      height: 100%;
    }
    .carousel-item img {
      object-fit: cover; /* Maintain aspect ratio and cover entire container */
      width: 100%;
      height: 100%;
    }
    .carousel-caption {
      bottom: 20%;
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
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          <a class="nav-link" href="game.php">Game</a>
          <a class="nav-link" href="table.php">Result</a>
        </div>
      </div>
      <form action="logout.php" method="post" class="d-inline">
        <button class="btn btn-outline-success logout-btn" type="submit">Logout</button>
      </form>      
      <li></li>
      <a href="profile.php" class="navbar-icon"><i class="far fa-user-circle" style="font-size:30px;"></i></a>
    </div>
  </nav>

  <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="pastel1.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h2>Welcome to SpeechWell</h2>
          <h6>Transform your experience with us, enhancing your communication capabilities</h6>
        </div>
      </div>
      <div class="carousel-item">
        <img src="pastel6.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h2><span style="color:white">Come & Join Us</span></h2>
          <h6><span style="color:white">For an empowering journey, boosting your communication abilities</span></h6>
        </div>
      </div>
      <div class="carousel-item">
        <img src="pastel7.jpg" class="d-block w-100" alt="">
        <div class="carousel-caption d-none d-md-block">
          <h2><span style="color:black">Discover a life-changing journey</span></h2>
          <h6><span style="color:black">For remarkable transformation, elevating your communication prowess</span></h6>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

