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
<?php
$dbhost = 'localhost';
$username = 'root';
$password = '';
$dbname = 'speechwell';

// Create connection
$conn = new mysqli($dbhost, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch user data with userName
$sql = "SELECT r.userID, u.userName, r.dategame, (r.cat + r.panda + r.tiger + r.elephant + r.capy) as score 
        FROM result r 
        JOIN users u ON r.userID = u.userID";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
} else {
  echo "0 results";
}
$conn->close();

// Encode data as JSON
$jsonData = json_encode($data);
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
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
    /* Custom CSS for centering the chart */
    body, html {
      height: 95%;
      margin: 0;
    }
    .container {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100%;
    }
    #chartContainer {
      width: 950%;
      max-width: 950px;
    }
    .card {
      margin: 20px;
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
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title text-center">All Performance Metrics</h4>
      </div>
      <div class="card-body">
        <div id="chartContainer">
          <canvas id="userPerformance" style="width: 100%;"></canvas>
        </div>
      </div>
    </div>
  </div>
  <script>
    // Parse JSON data from PHP
    const data = <?php echo $jsonData; ?>;
    
    const userScores = {};
    const dates = [];

    // Process the data
    data.forEach(item => {
      const { userID, userName, dategame, score } = item;
      if (!userScores[userName]) {
        userScores[userName] = [];
      }
      userScores[userName].push({ dategame, score });
      if (!dates.includes(dategame)) {
        dates.push(dategame);
      }
    });

    // Sort dates
    dates.sort((a, b) => new Date(a) - new Date(b));

    const datasets = Object.keys(userScores).map(userName => {
      return {
        label: `${userName}`,
        data: userScores[userName].sort((a, b) => new Date(a.dategame) - new Date(b.dategame)).map(item => item.score),
        borderColor: getRandomColor(),
        fill: false
      };
    });

    // Create the chart
    new Chart("userPerformance", {
      type: "line",
      data: {
        labels: dates,
        datasets: datasets
      },
      options: {
        legend: { display: true },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true,
              max: 5
            }
          }]
        }
      }
    });

    // Function to generate random colors
    function getRandomColor() {
      const letters = '0123456789ABCDEF';
      let color = '#';
      for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
      }
      return color;
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
