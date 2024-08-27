<?php
session_start();

$dbhost = 'localhost';
$username = 'root';
$password = '';
$dbname = 'speechwell';

$conn = new mysqli($dbhost, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['userID'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture the form data
    $appt_time = $_POST['appt_time'];
    $start_date = $_POST['start_date'];
    $userID = $_SESSION['userID'];

    // Perform database insertion
    $sql = "INSERT INTO result (userID, appt_time, start_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param('iss', $userID, $appt_time, $start_date);
    if ($stmt->execute()) {
        // Redirect to panda.php after successful insertion
        header("Location: panda.php?appt_time=$appt_time&start_date=$start_date");
        exit();
    } else {
        $message = "Error inserting record: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Time and Date Form</title>
  <style>
    label {
      display: block;
      font: 1rem 'Fira Sans', sans-serif;
    }
    input, label {
      margin: 0.4rem 0;
    }
  </style>
</head>
<body>
<form method="post" action="">
    <div>
      <label for="appt-time">
        Choose an appointment time:
      </label>
      <input id="appt-time" type="time" name="appt_time" required />
      <span class="validity"></span>
    </div>
    <div>
      <label for="start_date">Start date:</label>
      <input type="date" id="start_date" name="start_date" required />
    </div>
    <div>
      <input type="submit" value="Submit form"/>
    </div>
</form>

<?php
if (!empty($message)) {
    echo "<p>$message</p>";
}
?>
</body>
</html>
