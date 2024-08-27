<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

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

$userID = $_SESSION['userID'];

// SQL query to fetch user data with userName for the logged-in user
$sql = "SELECT r.userID, r.gameID, u.userName, r.dategame, (r.cat + r.panda + r.tiger + r.elephant + r.capy) as score 
        FROM result r 
        JOIN users u ON r.userID = u.userID
        WHERE r.userID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

$data = [];

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "0 results";
}
$stmt->close();

// Encode data as JSON
$jsonData = json_encode($data);

// SQL query to fetch detailed user data for the logged-in user
$query = "SELECT u.userFullName, r.gameID, r.dategame, (r.cat + r.panda + r.tiger + r.elephant + r.capy) as score 
          FROM users u 
          JOIN result r ON u.userID = r.userID
          WHERE u.userID = $userID";  // Filter by logged-in user ID

$userDetails = $conn->query($query);

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome link -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Chart.js link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <style>
        .navbar-icon {
            margin-left: auto;
            margin-right: 10px;
            color: #fff;
        }
        .navbar {
            background-color: #000;
        }
        .navbar-brand,
        .navbar-nav .nav-link {
            color: #fff !important;
        }
        .navbar-nav {
            width: calc(100% - 36px);
            margin-left: 20px;
        }
        .navbar-nav .nav-link {
            text-align: center;
        }
        .logout-btn {
            margin-left: 10px;
        }
        .container {
            text-align: center;
            margin-top: 50px;
        }
        .card {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            background-color: white;
        }
        table th, table td {
            text-align: center;
            padding: 12px;
        }
        table thead th {
            background-color: #000;
            color: white;
        }
        table tbody tr:hover {
            background-color: #ccc;
        }
        h1 {
            color: white;
            margin-bottom: 20px;
        }
        .modal-content {
            text-align: left;
        }
        body, html {
            height: 95%;
            margin: 0;
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

  <div class="container mt-5">
      <div class="row">
          <div class="col-md-6">
              <div class="card">
                  <div class="card-header">
                      <h3 class="card-title">User Progress Overview</h3>
                  </div>
                  <div class="card-body">
                      <div id="chartContainer">
                          <canvas id="userPerformance"></canvas>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-md-6">
              <div class="card">
                  <div class="card-header">
                      <h3 class="card-title">User Details</h3>
                  </div>
                  <div class="card-body">
                      <?php 
                          echo '<table class="table table-bordered"> 
                              <thead>
                                  <tr> 
                                      <th>No</th>
                                      <th>Full Name</th> 
                                      <th>Date Game</th> 
                                      <th>Score</th>
                                      <th>Actions</th>
                                  </tr>
                              </thead>
                              <tbody>';

                          $no = 1;
                          if ($userDetails->num_rows > 0) {
                              while ($row = $userDetails->fetch_assoc()) {
                                  $userFullName = $row["userFullName"]; 
                                  $dategame = $row["dategame"];
                                  $score = $row["score"];
                                  $gameID = $row["gameID"];

                                  echo '<tr> 
                                          <td>'.$no.'</td>
                                          <td>'.$userFullName.'</td> 
                                          <td>'.$dategame.'</td> 
                                          <td>'.$score.'</td>
                                          <td>
                                              <button class="btn btn-primary" onclick="viewGameDetail('.$gameID.')"><i class="fas fa-eye"></i> View</button>
                                          </td>
                                      </tr>';
                                  $no++;
                              }
                          } else {
                              echo '<tr><td colspan="5">No details found.</td></tr>';
                          }
                          echo '</tbody></table>';
                      ?>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <!-- Modal for displaying user details -->
  <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="userModalLabel">User Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modalBody">
          <!-- Details will be loaded here -->
        </div>
      </div>
    </div>
  </div>

  <!-- jQuery and Bootstrap scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

  <script>
    function viewGameDetail(gameID) {
        $.ajax({
            url: 'viewgame3.php',
            type: 'POST',
            data: { gameID: gameID },
            success: function(response) {
                $('#modalBody').html(response);
                $('#userModal').modal('show');
            }
        });
    }

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
</body>
</html>
