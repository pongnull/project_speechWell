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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Link Bootstrap stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome link -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <title>Main Page</title>
    <style>
    /* Navigation Bar Styles */
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
    .navbar-icon {
        margin-left: auto; /* Push the icon to the right */
        margin-right: 10px; /* Add margin to separate from the logout button */
        color: #fff; /* White color */
    }
    .logout-btn {
        margin-left: 10px; /* Add margin to the left of the logout button */
    }

    .container {
        text-align: center;
        margin-top: 50px;
    }

    .card {
        margin: 20px auto;
        width: 90%;
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
        color: black;
        margin-bottom: 20px;
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
        <h4>All User Accounts</h4>
      </div>
      <div class="card-body">
        <?php 
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "speechwell";
            
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            $query = "SELECT * FROM users";

            echo '<table class="table table-bordered"> 
                <thead>
                    <tr> 
                        <th>No</th> 
                        <th>User ID</th> 
                        <th>Username</th> 
                        <th>User Full Name</th> 
                        <th>User Age</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';

            $no = 1; // Initialize the numbering
            if ($result = $conn->query($query)) {
                while ($row = $result->fetch_assoc()) {
                    $field100name = $row["userID"];
                    $field1name = $row["userName"];
                    $field3name = $row["userFullName"]; 
                    $field34name = $row["userAge"]; 

                    echo '<tr id="row_'.$field100name.'"> 
                            <td>'.$no.'</td>
                            <td>'.$field100name.'</td>
                            <td>'.$field1name.'</td> 
                            <td>'.$field3name.'</td> 
                            <td>'.$field34name.'</td>
                            <td>
                                <button class="btn btn-danger" onclick="deleteUser('.$field100name.')"><i class="fas fa-trash-alt"></i> Delete</button>
                            </td>
                        </tr>';
                    $no++; // Increment the numbering
                }
                $result->free();
            }

            echo '</tbody></table>';
        ?>
      </div>
    </div>
  </div>

  <!-- jQuery and Bootstrap scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

  <script>
  function deleteUser(userID) {
      if (confirm('Are you sure you want to delete this user?')) {
          $.ajax({
              url: 'delete_user.php',
              type: 'POST',
              data: { userID: userID },
              success: function(response) {
                  if (response == 'success') {
                      $('#row_' + userID).remove();
                  } else {
                      alert('Failed to delete user.');
                  }
              }
          });
      }
  }
  </script>
</body>
</html>
