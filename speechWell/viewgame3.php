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

$gameID = $_POST['gameID'];

// SQL query to fetch game details for the provided gameID
$sql = "SELECT r.userID, u.userName, r.dategame, r.cat, r.panda, r.tiger, r.elephant, r.capy
        FROM result r
        JOIN users u ON r.userID = u.userID
        WHERE r.gameID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $gameID);
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

// Close the connection
$conn->close();

// Display game details
if (!empty($data)) {
    $row = $data[0];
    echo '<h5>User: ' . $row['userName'] . '</h5>';
    echo '<p>Date: ' . $row['dategame'] . '</p>';
    echo '<p>Cat: ' . $row['cat'] . '</p>';
    echo '<p>Panda: ' . $row['panda'] . '</p>';
    echo '<p>Tiger: ' . $row['tiger'] . '</p>';
    echo '<p>Elephant: ' . $row['elephant'] . '</p>';
    echo '<p>Capy: ' . $row['capy'] . '</p>';
} else {
    echo 'No details found for this game.';
}
?>
