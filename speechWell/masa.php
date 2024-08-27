<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['userID']; // Retrieve userID from session

// Database connection
$dbhost = 'localhost';
$username = 'root';
$password = '';
$dbname = 'speechwell';

$conn = new mysqli($dbhost, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['selected_datetime'])) {
    // Prepare and bind the SQL statement to insert the game data
    $stmt = $conn->prepare("INSERT INTO result (userID, dategame, timegame) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $userID, $date, $time);

    // Set parameters
    $datetime = $_GET['selected_datetime'];

    // Extract date and time from datetime-local input
    $datetime_parts = explode('T', $datetime);
    $date = $datetime_parts[0];
    $time = $datetime_parts[1];

    // Execute the statement
    if ($stmt->execute()) {
        // Get the auto-generated game ID
        $gameID = $conn->insert_id;
        
        // Close statement
        $stmt->close();

        // Redirect to panda.php with selected datetime and user ID
        header("Location: cat.php?gameID=$gameID");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clock and Date</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('background.jpg'); /* Change the path to your background image */
            background-size: cover;
            background-position: center;
        }

        .container {
            text-align: center;
        }

        .card {
            border: 1px solid #ccc;
            padding: 70px;
            border-radius: 50px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
            background-color: rgba(255, 255, 255, 0.8);
        }

        .clock {
            font-size: 50px;
            margin-bottom: 20px;
        }

        .date-picker {
            margin-bottom: 50px;
        }

        input[type="datetime-local"] {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 10px;
        }

        input[type="submit"], button {
            padding: 5px 10px;
            border-radius: 5px;
            border: none;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        .next-button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="clock" id="clock">
                <?php echo date('H:i:s'); ?>
            </div>
            <div class="date-picker">
                <form action="" method="GET">
                    <input type="datetime-local" name="selected_datetime" id="selected_datetime" value="<?php echo isset($_GET['selected_datetime']) ? $_GET['selected_datetime'] : date('Y-m-d\TH:i'); ?>">
                    <button type="submit" class="btn btn-primary">Next</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
