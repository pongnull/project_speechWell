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
  <title>Game</title>
  <!-- Bootstrap CSS link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome link -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>

    .navbar-icon {
      margin-left: auto; /* Push the icon to the right */
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
    .card-title {
      margin-bottom: 20px;
    }
    .card-body {
      position: relative; /* Make the card body relative for absolute positioning */
    }
    .back-button {
      position: absolute;
      top: 10px;
      left: 10px;
      cursor: pointer;
      color: #000;
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

  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <br>
  <div class="container d-flex justify-content-center">
    <div class="card shadow-lg" style="width: 58rem;">
    <br>

      <div class="card-body">
      <a href="index.php" class="back-button">
  <i class="far fa-arrow-alt-circle-left" style="font-size: 36px;"></i>
</a>
        <h5 class="card-title text-center">Select Topic</h5>
        <div class="card-container d-flex justify-content-between">
          <div class="card d-inline-block" style="width: 18rem;">
            <img src="fruit.jpg" class="card-img-top mx-auto" alt="..." style="height: 200px;">
            <div class="card-body text-center">
              <h5 class="card-title">Fruit</h5>
              <p class="card-text">Explore the vibrant world of fruits! This topic will present you with colourful images of various fruits</p>
              <a href="orange.php" class="btn btn-primary">NEXT</a>
            </div>
          </div>
          <div class="card d-inline-block" style="width: 18rem;">
            <img src="animal.jpg" class="card-img-top mx-auto" alt="..." style="height: 200px;">
            <div class="card-body text-center">
              <h5 class="card-title">Animal</h5>
              <p class="card-text">Explore the animal kingdom with captivating images of diverse creatures on this topic</p>
              <a href="masa.php" class="btn btn-primary">NEXT</a>
            </div>
          </div>
          <div class="card d-inline-block" style="width: 18rem;">
            <img src="object.jpg" class="card-img-top mx-auto" alt="..." style="height: 200px;">
            <div class="card-body text-center">
              <h5 class="card-title">Object</h5>
              <p class="card-text">Explore everyday objects! This topic features common items around us and daily use items</p>
              <a href="#" class="btn btn-primary">NEXT</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!-- Font Awesome script -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>