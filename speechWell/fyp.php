<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
</head>

<body>
<style>
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}

li {
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover:not(.active) {
  background-color: #111;
}

.active {
  background-color:#e21e80;
}
.login{  
    width: 10%;
    color: #fff !important;
    text-decoration: none;
    background-color: #e21e80;
    padding: 7px;
    border-radius: 25px;
    border:;
    box-shadow:0 0 10px 0 rgba(0,0,0,.24); 
    height: 2p;
    margin-top: 20px;
    margin-left: 20%;
    
}
label{
    width: 170px;
    text-align: right;
    display: inline-block;
}
input{
    width: 250px;
    margin: auto;
}
form{
    padding-left: 39%;
    margin: auto;
}
body{
    background-image:url("https://images.unsplash.com/photo-1511512578047-dfb367046420?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1051&q=80");
    background-size: cover;
    background-attachment: fixed;
}
text{
  color: white;
  font-weight: 700;
  font-size: 50px;
}
</style>
</head>
<body>

<ul>
  <li><a href="mainPage.php">Home</a></li>
  <li><a href="banyakTour.php">Join</a></li>
  <li><a class="active" href="#home">Create</a></li>
  <li><a href="recruit.php">Promote</a></li>
  <li><a href="displayUser.php">View</a></li>
  <li><a href="find.php">Recruit</a></li>
  <li><a class="active" href="start.php">Logout</a></li>
</ul>
</body>

<br>

<div>

<?php
include('createdb.php');
?>
  <form method="post">
    <div class="boxed">
        <h1>Create Your Own Tournament</h1>
        <br>
        
        <label class="text">Tournament Name : </label>
        <input class="user" type="text" name="tourName" placeholder="Enter your tournament name" id="tourName">
        <br>
        <br>
        <label class="text">Game: </label>
        <input class="user" type="text" name="gameName" placeholder="Enter Game"id="gameName">
        <br>
        <br>
        <label class="text">Prize : </label>
        <input class="user" type="text" name="prize" placeholder="Enter Your Tournament Prize Pool" id="prize">
        <br>
        <br>
        <label class="text">Description : </label>
        <input class="user" type="text" name="description" placeholder="Enter description about your tournament id="description">
        <br>
        <br>
        <label class="text">No Phone : </label>
        <input class="user" type="text" name="customerNoPhone" placeholder="Enter Your Phone Number" id="customerNoPhone">
        <br>
        <br>
        <input class="login" type="submit" name="submit222" value="Submit" onclick="validateForm()">
        <br>
        <br>

</div>
    </form>

</div>
    
<?php

include 'database/connection.php';

if(isset($_POST["submit222"]))
{
    $tourName = $_POST['tourName'];
    $gameName = $_POST['gameName'];
    $prize =  $_POST['prize'];
    $description=  $_POST['description'];
    $customerNoPhone=  $_POST['customerNoPhone'];


    $insert = mysqli_query($conn,"INSERT INTO `createtour`(`tourName`,`gameName`,`prize`,
    `description`,`customerNoPhone`)VALUES('$tourName','$gameName','$prize','$description', '$customerNoPhone')");
    
    if(!$insert)
    {
        echo mysqli_error($conn);
    }
    else
    {
        header("Location: create.php");
    }  
}
?>
<?php 
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "fyp";
        
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        $query = "SELECT * FROM createtour";


        echo '<table> 
            <tr> 
                <td> <b>Tournament Name</b> </td> 
                <td> <b>GAME</b> </td> 
                <td> <b>Prize</b> </td> 
                <td> <b>Description</b> </td>
                <td> <b>No Phone</b> </td>  
            </tr>
            <style>
            table {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 1000px;
                margin-left: auto;
                margin-right:auto;
                margin-top: 20px;
                color:black;
                font-size:20px;
                text-align:center;
                background-color: white;
                border-color:black;

              }
              
              table td, .hosting th {
                border: 1px solid #ddd;
                padding: 8px;
                border-color:black;
              }
              
              table tr:nth-child(even){background-color: #dddddd;}
              table tr:hover {background-color: #e21e80;}
              
              table th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: white;
                color: white;
              }
            </style>';

            if ($result = $conn->query($query)) {
                while ($row = $result->fetch_assoc()) {
                    $field1nametour = $row["tourName"];
                    $field2nameGame = $row["gameName"];
                    $field3namePrize = $row["prize"];
                    $field4nameDesc = $row["description"]; 
                    $field5nameNo = $row["customerNoPhone"];  

                echo '<tr> 
                        <td>'.$field1nametour.'</td>
                        <td>'.$field2nameGame.'</td> 
                        <td>'.$field3namePrize.'</td> 
                        <td>'.$field4nameDesc.'</td> 
                        <td>'.$field5nameNo.'</td>
                    </tr>';
            }
            $result->free();
        }
?>
<br>
<br>
</body>
</html>