<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>MANGO</title>
  <!-- Bootstrap CSS link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome link -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    .navbar-icon {
      margin-left: auto; /* Push the icon to the right */
      color: #fff; /* White color */
    }
    /* Custom CSS for centering the card */
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
    }
    .back-button {
      position: absolute;
      top: 10px;
      left: 10px;
      cursor: pointer;
      color: #000;
    }
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh; /* Set height to full viewport height */
    }
    .arrow-icon {
      position: absolute;
      top: 10px; /* Adjust top position */
      right: 10px; /* Adjust right position */
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
          <a class="nav-link active" aria-current="page" href="#">Home</a>
          <a class="nav-link" href="#">Game</a>
          <a class="nav-link" href="#">Result</a>
        </div>
      </div>
      <a href="profile.php" class="navbar-icon"><i class="far fa-user-circle" style="font-size:30px;"></i></a>
    </div>
  </nav>
  <div class="container">
    <div class="card shadow p-3 mb-5 bg-body rounded" style="width: 30rem; position: relative;">
    <a href="apple.php"> <!-- Anchor tag to navigate to panda.php -->
        <i class='far fa-arrow-alt-circle-right arrow-icon' style='font-size:36px'></i>
      </a>      
      <br>
      <div class="card-body">
        <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
          <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%"></div>
        </div>
        <div class="text-center mb-3">
          <strong style="font-size: 36px; font-weight: bold;">MANGO</strong>
        </div>
        <img src="mango.jpg" class="img-fluid mb-3">
        <textarea id="result" rows="1" cols="30" class="form-control mb-3"></textarea>
        <div class="d-grid gap-2">
          <button id="start" class="btn btn-primary" type="button">Start</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JavaScript link -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- JavaScript to handle speech recognition and progress bar -->
  <script type="text/javascript">
    var startButton = document.getElementById('start');
    var resultElement = document.getElementById('result');
    var recognition = new webkitSpeechRecognition();

    recognition.lang = window.navigator.language;
    recognition.interimResults = true;

    startButton.addEventListener('click', () => { 
      // Speak out "Repeat After Me Pan Da" before starting recognition
      speak("Repeat After Me Mango");
      recognition.start(); 
    });
    recognition.addEventListener('result', (event) => {
      const result = event.results[event.results.length - 1][0].transcript;
      resultElement.textContent = result;
      
      // Check if the recognized speech matches "Panda"
      if (result.toLowerCase() === "mango") {
        setTimeout(() => {
          window.location.href = 'banana.php';
        }, 2000);
        // Update the progress bar every second
        var progressBar = document.getElementById('progress-bar');
        var progress = 0;
        var interval = setInterval(() => {
          progress += 10;
          progressBar.style.width = progress + '%';
          // Clear the interval when progress reaches 100%
          if (progress >= 100) {
            clearInterval(interval);
          }
        }, 10);
      } else {
        // Display the modal if the speech is incorrect
        var myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
        myModal.show();
      }
    });

    // Function to speak out the given text
    function speak(text) {
      var utterance = new SpeechSynthesisUtterance(text);
      utterance.rate = 0.3; // Set speech rate to 0.5 (slower)
      window.speechSynthesis.speak(utterance);
    }
  </script>

  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
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
    // Get the buttons
var repeatButton = document.getElementById('repeatBtn');
var nextButton = document.getElementById('nextBtn');

// Add event listener for the Repeat button
repeatButton.addEventListener('click', function() {
    // Reload the page
    window.location.reload();
});

// Add event listener for the Next button
nextButton.addEventListener('click', function() {
    // Redirect to test.php
    window.location.href = 'banana.php';
});
</script>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

</body>
</html>
