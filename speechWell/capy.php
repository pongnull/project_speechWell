<?php
session_start(); // Start the session

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['userID']; // Retrieve userID from session

// Check if the gameID is passed in the URL parameters
if (!isset($_GET['gameID'])) {
    // If gameID is not provided, redirect to an error page or handle the error appropriately
    header("Location: error.php");
    exit();
}

$gameID = $_GET['gameID']; // Retrieve gameID from URL parameters
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAPYBARA</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            background-image: url('pastel10.jpg'); /* Replace 'your-background-image.jpg' with the path to your image */
            background-size: cover; /* Cover the entire viewport */
            background-position: center; /* Center the background image */
        }
        .navbar-icon {
            margin-left: auto; /* Push the icon to the right */
            color: #fff; /* White color */
        }
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
        .card-title {
            margin-bottom: 20px;
        }
        .card-body {
            position: relative; /* Make the card body relative for absolute positioning */
            display: flex; /* Use flexbox for layout */
            align-items: center; /* Center items vertically */
            gap: 20px; /* Space between items */
        }
        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px; /* Ensure there's enough padding so it doesn't touch the navbar */
            box-sizing: border-box;
        }
        .card {
            width: 55rem; /* Reduced width */
            max-width: 100%;
            position: relative;
            padding: 20px;
        }
        .arrow-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
        }
        .result-display {
            background-color: transparent;
            text-align: center;
            font-size: 20px; /* Slightly smaller font size */
            font-weight: bold;
        }
        .title-container {
            text-align: center;
            position: relative;
        }
        .title-container .arrow-icon {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
        }
        #result-textarea {
    border: none;
}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">SpeechWell</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                <a class="nav-link" href="game.php">Game</a>
                <a class="nav-link" href="result.php">Result</a>
            </div>
        </div>
        <a href="profile.php" class="navbar-icon"><i class="far fa-user-circle" style="font-size:30px;"></i></a>
    </div>
</nav>
<br>
<br>

<div class="container">
    <div class="card shadow p-3 mb-5 bg-body rounded"> <!-- Updated width and max-width -->
        <div class="title-container mb-3">
            <strong style="font-size: 36px; font-weight: bold;">CAPYBARA</strong>
            <a href="result.php?gameID=<?php echo $gameID; ?>"> <!-- Anchor tag to navigate to tiger.php with gameID -->
                <i class='far fa-arrow-alt-circle-right arrow-icon' style='font-size:36px'></i>
            </a>
        </div>
        <div class="progress mb-3" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
            <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%"></div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6"> <!-- Column for image -->
                    <img src="capy.jpg" class="img-fluid mb-4">
                </div>
                <div class="col-md-6"> <!-- Column for textarea and buttons -->
                <br>
                <div id="result" class="mt-3 p-3 result-display"></div>
    <div class="d-grid gap-2">
    <textarea id="result-textarea" rows="1" cols="30" class="form-control mb-3 border-0"></textarea>
        <button id="listen" class="btn btn-primary" type="button">Listen</button>
        <button id="speak" class="btn btn-danger" type="button">Speak</button>
    </div>
</div>

            </div>
        </div>
    </div>
</div>


<!-- Bootstrap JavaScript link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- JavaScript to handle speech recognition and speech synthesis -->
<script type="text/javascript">
    var resultElement = document.getElementById('result-textarea');
    var recognition = new webkitSpeechRecognition();
    recognition.lang = window.navigator.language;
    recognition.interimResults = true;

    document.getElementById('listen').addEventListener('click', () => {
        speakAndDisplay("Please Repeat After Me CAPYBARA");
    });

    document.getElementById('speak').addEventListener('click', () => {
        recognition.start();
    });

    recognition.addEventListener('result', (event) => {
        const result = event.results[event.results.length - 1][0].transcript;
        resultElement.textContent = result;

        // Check if the recognized speech matches 
        if (result.toLowerCase() === "capybara") {
            // Send the result to the PHP script using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", `insert_resultcapy.php?gameID=<?php echo $gameID; ?>`, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    console.log("Result inserted successfully");
                }
            };
            xhr.send("result=1"); // Send 1 for correct answer

            // Update the progress bar to full
            var progressBar = document.getElementById('progress-bar');
            progressBar.style.width = '100%';

            // Redirect to the next page after a delay
            // Redirect to the next page after a delay
setTimeout(() => {
    window.location.href = 'result.php?gameID=<?php echo $gameID; ?>';
}, 2000);

        } else {
            // Display the modal if the speech is incorrect
            var myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
            myModal.show();

            // Send the result to the PHP script using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", `insert_resultcapy.php?gameID=<?php echo $gameID; ?>`, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("result=0"); // Send 0 for incorrect answer
        }
    });

    // Function to speak out the given text and display it word by word
    function speakAndDisplay(text) {
        var utterance = new SpeechSynthesisUtterance(text);
        utterance.rate = 0.2; // Set speech rate to 0.5 (slower)

        var words = text.split(' ');
        var wordIndex = 0;
        var resultContainer = document.getElementById('result');
        resultContainer.innerHTML = ''; // Clear the result container

        // Function to display each word at the appropriate time
        utterance.onboundary = function(event) {
            if (event.name === 'word') {
                var word = words[wordIndex];
                var span = document.createElement('span');
                span.textContent = ` ${word}`;
                resultContainer.appendChild(span);
                wordIndex++;
            }
        };

        // Speak the text
        window.speechSynthesis.speak(utterance);
    }

    // Function to speak out the given text
    function speak(text) {
        var utterance = new SpeechSynthesisUtterance(text);
        utterance.rate = 0.3; // Set speech rate to 0.5 (slower)
        window.speechSynthesis.speak(utterance);
    }
</script>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" style="margin-top: 50px;"> <!-- Adjust margin-top value as needed -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Incorrect Answer</h5>
            </div>
            <div class="modal-body">
                Your speech did not match the expected word.
            </div>
            <div class="modal-footer">
                <button id="repeatBtn" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Repeat</button>
                <button id="nextBtn" type="button" class="btn btn-primary">Next</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Get

  var repeatButton = document.getElementById('repeatBtn');
  var nextButton = document.getElementById('nextBtn');

  // Add event listener for the Repeat button
  repeatButton.addEventListener('click', function () {
    // Reload the page
    window.location.reload();
  });

  // Add event listener for the Next button
  nextButton.addEventListener('click', function () {
    // Redirect to panda.php
    window.location.href = 'result.php?gameID=<?php echo $gameID; ?>';
  });
</script>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

</body>
</html>