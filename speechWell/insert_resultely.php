<?php
session_start();

// Check if the result is set and the user is logged in
if (isset($_POST['result']) && isset($_SESSION['userID']) && isset($_GET['gameID'])) {
    $result = $_POST['result'];
    $userID = $_SESSION['userID'];
    $gameID = $_GET['gameID'];

    // Perform database update
    $dbhost = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'speechwell';

    $conn = new mysqli($dbhost, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the panda result in the database
    $sql = "UPDATE result SET elephant = ? WHERE userID = ? AND gameID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iis', $result, $userID, $gameID);
    if ($stmt->execute()) {
        echo "Result inserted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
} else {
    echo "Error: Result not set, gameID not passed, or user not logged in.";
}
?>
