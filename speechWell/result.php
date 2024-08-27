<?php
session_start(); // Start the session

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['userID']; // Retrieve userID from session

// Check if the gameID is passed in the URL parameters
if (!isset($_GET['gameID'])) {
    // If gameID is not provided, redirect to an error page or handle the error appropriately
    header("Location: error.php");
    exit();
}

$gameID = $_GET['gameID']; // Retrieve gameID from URL parameters

// Database connection
$dbhost = 'localhost';
$username = 'root';
$password = '';
$dbname = 'speechwell';

$conn = new mysqli($dbhost, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the values for cat, panda, tiger, elephant, and capy from the database
$sql = "SELECT cat, panda, tiger, elephant, capy FROM result WHERE gameID = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing the statement: " . $conn->error);
}

$stmt->bind_param("i", $gameID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $scores = [
        'cat' => $row['cat'],
        'panda' => $row['panda'],
        'tiger' => $row['tiger'],
        'elephant' => $row['elephant'],
        'capy' => $row['capy']
    ];
    $total_score = array_sum($scores);
    $total_percentage = ($total_score / 5) * 100; // Assuming each value is out of 1
} else {
    $scores = ['cat' => 0, 'panda' => 0, 'tiger' => 0, 'elephant' => 0, 'capy' => 0];
    $total_score = 0;
    $total_percentage = 0;
}

$stmt->close();
$conn->close();

// Mapping of animal names to their respective image URLs
$animal_images = [
    'cat' => 'cat.jpg',
    'panda' => 'panda.jpg',
    'tiger' => 'tiger.jpg',
    'elephant' => 'elephant.jpg',
    'capy' => 'capy.jpg'
];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Result</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome link -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f7f8fc;
            font-family: 'Arial', sans-serif;
        }
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
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 20px;
        }
        .card {
            width: 100%;
            max-width: 900px;
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 30px;
            position: relative;
        }
        .back-button {
            position: absolute;
            top: 10px;
            left: 10px;
            cursor: pointer;
            color: #343a40;
        }
        .card-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .small-heading {
            font-size: 18px;
            font-weight: 500;
            color: #555;
            margin-bottom: 20px;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
        }
        .score-card {
            flex: 1;
            min-width: 100px;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            color: #fff;
        }
        .correct {
            background-color: #28a745;
        }
        .wrong {
            background-color: #dc3545;
        }
        .animal-image {
            width: 70px;
            height: 70px;
            margin-bottom: 10px;
        }
        .btn-next {
            position: absolute;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
        }
        .btn-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SpeechWell</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    <a class="nav-link" href="game.php">Game</a>
                    <a class="nav-link" href="result.php">Result</a>
                </div>
            </div>
            <a href="profile.php" class="navbar-icon"><i class="far fa-user-circle" style="font-size:30px;"></i></a>
        </div>
    </nav>
  <div class="container">
    <div class="card shadow-lg">
      <div class="card-body">
        <h5 class="card-title text-center">Summary of Scores</h5>
        <div class="card-container">
          <?php foreach ($scores as $animal => $score) : ?>
            <div class="score-card <?php echo $score > 0 ? 'correct' : 'wrong'; ?>">
              <img src="<?php echo $animal_images[$animal]; ?>" alt="<?php echo $animal; ?>" class="animal-image">
              <p class="card-text"><?php echo ucfirst($animal); ?></p>
              <h5 class="card-title"><?php echo $score > 0 ? 'Correct' : 'Wrong'; ?></h5>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="card-container">
          <div class="score-card" style="background-color: #028391;">
            <p class="card-text">Overall Scores</p>
            <h5 class="card-title"><?php echo $total_percentage; ?>%</h5>
          </div>
          <div class="score-card" style="background-color: #17a2b8;">
            <p class="card-text">Your Points</p>
            <h5 class="card-title"><?php echo $total_score; ?></h5>
          </div>
        </div>
        <div class="btn-container">
                    <a href="game.php" class="btn btn-primary">CONTINUE</a>
                </div>        <a href="index.php" class="back-button">
        </a>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!-- Font Awesome script -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
