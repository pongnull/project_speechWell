<?php
$result = false;
$dbhost = 'localhost';
$username = 'root';
$password = '';
$dbname = 'speechwell';

if(isset($_POST["submit"])) {
    $conn = new mysqli($dbhost, $username, $password, $dbname);
    if ($conn) {
        $sql = 'INSERT INTO users (userName, userFullName, userPassword, userAge) VALUES (?, ?, ?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $_POST['userName'], $_POST['userFullName'], $_POST['userPassword'], $_POST['userAge']);
        $result = $stmt->execute();
        if ($result) {
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
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
    <title>Sign</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome link -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom CSS */
        .image-container {
            height: 100vh; /* Full height of the viewport */
            overflow: hidden; /* Hide overflow */
            position: relative; /* Positioning context */
        }
        .image-container img {
            position: absolute; /* Position absolute */
            top: 0; /* Align to the top */
            left: 0; /* Align to the left */
            height: 100%; /* Full height */
            width: auto; /* Maintain aspect ratio */
        }
        .card-container {
            position: absolute; /* Position absolute */
            top: 50%; /* Center vertically */
            transform: translateY(-50%); /* Adjust vertically */
            right: 180px; /* Align to the right */
            width: calc(30% - 50px); /* Set width of the card */
        }
        .card {
            padding: 20px; /* Add padding to the card */
        }
        .login-container .text-left {
            text-align: left; /* Align text to the left */
            margin-bottom: 20px; /* Add margin to the bottom */
        }
        .login-container input[type="text"],
        .login-container input[type="password"],
        .login-container button {
            font-size: 18px; /* Increase font size */
            padding: 10px 20px; /* Increase padding */
        }
        /* Custom Button Styles */
        .btn-login,
        .btn-signup {
            padding: 10px 20px; /* Match padding with text boxes */
        }
        .btn-login {
            background-color: black; /* Black background */
            color: white; /* White text */
            border: none; /* No border */
        }
        .btn-login:hover {
            background-color: #333; /* Darker background on hover */
        }
        .btn-signup {
            background-color: grey; /* Grey background */
            color: black; /* Black text */
            border: none; /* No border */
        }
        .btn-signup:hover {
            background-color: #ccc; /* Lighter background on hover */
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 px-0"> <!-- Half of the page -->
                <div class="image-container">
                    <img src="56.jpg" alt="Image">
                </div>
            </div>
            <div class="col-5">
                <div class="card-container">
                    <div class="card">
                        <div class="login-container">
                            <h2 class="text-center">Registration Form</h2>
                            <br>
                            <form action="" method="post">
                                <div class="mb-3">
                                    <input type="text" name="userName" class="form-control" placeholder="Username" required>
                                </div>
                                <div class="mb-3">
                                    <input type="password" name="userPassword" class="form-control" placeholder="Password" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="userFullName" class="form-control" placeholder="Full Name" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="userAge" class="form-control" placeholder="Age" required>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="acceptTerms" required>
                                    <label class="form-check-label" for="acceptTerms">I accept all terms & conditions</label>
                                </div>
                                <button name="submit" type="submit" class="btn btn-login d-block w-100 mb-3">Register</button>
                            </form>
                            <div style="display: flex; justify-content: center;">
                                <p style="margin: 0; padding-right: 10px;">Already Have Account?</p>
                                <p style="margin: 0;"><a href="login.php" style="color: blue; text-decoration: none;">Login Now</a></p>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
