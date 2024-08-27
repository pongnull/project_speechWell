<?php
session_start();

$dbhost = 'localhost';
$username = 'root';
$password = '';
$dbname = 'speechwell';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli($dbhost, $username, $password, $dbname);
    if ($conn) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT userID FROM users WHERE userName = ? AND userPassword = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $_SESSION['userID'] = $row['userID']; // Store userID in session
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Incorrect username or password');</script>";
        }
    } else {
        echo "Error: Unable to connect to the database.";
    }
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome link -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 px-0"> <!-- Half of the page -->
                <div class="image-container">
                    <img src="kinder.jpg" alt="Image">
                </div>
            </div>
            <div class="col-5">
                <div class="login-container">
                    <h2 class="text-left">Welcome to SpeechWell</h2>
                    <p class="text-left">Visit us for a transformative experience,<br>enhancing your communication skills</p>
                    <form method="POST" action="login.php">
                        <div class="mb-3">
                            <input type="text" name="username" class="form-control" placeholder="Username">
                        </div>
                        <div class="mb-3">
    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
    <span toggle="#password" class="eye-icon fas fa-eye-slash"></span>
</div>
                        <button type="submit" class="btn btn-login d-block w-100 mb-3">Login</button>
                    </form>
                    <p class="text-center mb-0">_________________________  or  _________________________</p>
                    <br>
                    <a href="sign.php" class="btn btn-secondary d-block w-100">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const eyeIcon = document.querySelector('.eye-icon');
        const passwordInput = document.querySelector(eyeIcon.getAttribute('toggle'));

        eyeIcon.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Change eye icon based on password visibility
            this.classList.toggle('fa-eye-slash');
            this.classList.toggle('fa-eye');
        });
    });
</script>
</body>
</html>