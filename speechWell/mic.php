<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speech Recognition Example</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #result p {
            display: inline;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="d-grid gap-2">
        <button id="listen" class="btn btn-primary" type="button">Listen</button>
    </div>
    <div id="result" class="mt-3 p-3 border border-primary rounded"></div>

    <!-- Bootstrap JavaScript link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript to handle speech recognition and speech synthesis -->
    <script type="text/javascript">
        var resultElement = document.getElementById('result');

        document.getElementById('listen').addEventListener('click', () => {
            var text = "Please repeat after me P, A, N, D, A, PANDA";
            speakAndDisplay(text);
        });

        // Function to speak out the given text and display it word by word
        function speakAndDisplay(text) {
            var utterance = new SpeechSynthesisUtterance(text);
            utterance.rate = 0.5; // Set speech rate to 0.5 (slower)

            var words = text.split(' ');
            var wordIndex = 0;
            resultElement.innerHTML = ''; // Clear the result element

            // Function to display each word at the appropriate time
            utterance.onboundary = function(event) {
                if (event.name === 'word') {
                    var word = words[wordIndex];
                    var span = document.createElement('span');
                    span.textContent = ` ${word}`;
                    resultElement.appendChild(span);
                    wordIndex++;
                }
            };

            // Speak the text
            window.speechSynthesis.speak(utterance);
        }
    </script>
</body>
</html>
