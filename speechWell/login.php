<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "speechwell";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve the submitted username, password, and user role from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userRole = $_POST['userRole'];

    // Prepare the SQL statement based on the user role to fetch the user from the database
    $stmt = null;
    $auth_failed = false; // Flag to track authentication failure

    if ($userRole === 'admin') {
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND adminPassword = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        // Check if a row is returned from the query
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            // User is authenticated
            $row = $result->fetch_assoc();
            $_SESSION['adminID'] = $row['adminID']; // Store adminID in session
            header("Location: tableAdmin.php");
            exit;
        } else {
            // User is not authenticated
            $auth_failed = true;
        }
    } elseif ($userRole === 'users') {
        $stmt = $conn->prepare("SELECT * FROM users WHERE userName = ? AND userPassword = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        // Check if a row is returned from the query
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            // User is authenticated
            $row = $result->fetch_assoc();
            $_SESSION['userID'] = $row['userID']; // Store userID in session
            header("Location: index.php");
            exit;
        } else {
            // User is not authenticated
            $auth_failed = true;
        }
    } else {
        // Invalid user role
        echo "Invalid user role.";
    }

    // Close the prepared statement and database connection
    $stmt->close();
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
        .login-container {
            position: absolute; /* Position absolute */
            top: 50%; /* Center vertically */
            transform: translateY(-50%); /* Adjust vertically */
            right: 0; /* Align to the right */
            padding: 0 200px; /* Add horizontal padding */
            font-size: 18px; /* Increase font size */
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
        .eye-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .eye-icon:hover {
            color: #007bff; /* Change color on hover if needed */
        }
        .form-outline {
            position: relative;
        }
    </style>
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
                    <form method="POST" action="">
                        <input type="hidden" name="auth_failed" id="auth_failed" value="<?php echo isset($auth_failed) && $auth_failed ? '1' : ''; ?>">
                        <div class="mb-3">
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>
                        <div class="mb-3 position-relative">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                            <span toggle="#password" class="eye-icon fas fa-eye-slash"></span>
                        </div>
                        <div class="form-outline mb-4">
                            <select class="form-select form-select-lg" id="userRole" name="userRole" style="border: 1px solid grey;" required>
                                <option value="" disabled selected>Select type</option>
                                <option value="users">User</option>
                                <option value="admin">Admin</option>
                            </select>
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

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Incorrect Answer</h5>
                </div>
                <div class="modal-body">Invalid username or password</div>
                <div class="modal-footer">
                    <button id="repeatBtn" type="button" class="btn btn-primary" data-bs-dismiss="modal">Try Again</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const eyeIcon = document.querySelector('.eye-icon');
            const passwordInput = document.querySelector('#password');
            const authFailed = document.querySelector('#auth_failed').value;

            eyeIcon.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Change eye icon based on password visibility
                this.classList.toggle('fa-eye-slash');
                this.classList.toggle('fa-eye');
            });

            // Show modal if authentication failed
            if (authFailed === '1') {
                const myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
                myModal.show();
            }

            // Reload the page on modal button click
            document.getElementById('repeatBtn').addEventListener('click', function () {
                window.location.href = 'login.php';
            });
        });
    </script>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

