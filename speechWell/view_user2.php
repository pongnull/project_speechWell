<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "speechwell";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$userID = $_POST['userID'];

$query = "SELECT u.userID, u.userName, r.dategame, r.timegame, r.cat, r.panda, r.tiger, r.elephant, r.capy,
          (r.cat + r.panda + r.tiger + r.elephant + r.capy) as score 
          FROM users u 
          JOIN result r ON u.userID = r.userID 
          WHERE u.userID = $userID";

$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $userID = $row["userID"];
    $userName = $row["userName"];
    $dategame = $row["dategame"];
    $timegame = $row["timegame"];
    $cat = $row["cat"] ? "correct" : "wrong";
    $panda = $row["panda"] ? "correct" : "wrong";
    $tiger = $row["tiger"] ? "correct" : "wrong";
    $elephant = $row["elephant"] ? "correct" : "wrong";
    $capy = $row["capy"] ? "correct" : "wrong";
    $score = $row["score"];

    echo "
    <table class='table'>
        <tr><th>User ID</th><td>$userID</td></tr>
        <tr><th>Username</th><td>$userName</td></tr>
        <tr><th>Date Game</th><td>$dategame</td></tr>
        <tr><th>Time Game</th><td>$timegame</td></tr>
        <tr><th>Cat</th><td>$cat</td></tr>
        <tr><th>Panda</th><td>$panda</td></tr>
        <tr><th>Tiger</th><td>$tiger</td></tr>
        <tr><th>Elephant</th><td>$elephant</td></tr>
        <tr><th>Capy</th><td>$capy</td></tr>
        <tr><th>Score</th><td>$score</td></tr>
    </table>
    ";
} else {
    echo "No details found.";
}

mysqli_close($conn);
?>
