<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProVods</title>
    <link rel="stylesheet" href="/Testik/Provods/provods.css">
    <style>
        #streamerForm {
            display: none;
        }
    </style>
</head>
<body>
    <?php
    require_once '../Player/designfunctions.php';
    renderNavbar();
    require_once 'streamerdatabase.php';
    ?>
    <div class="container">
        <div class="streamers-list">
            <h2>Streamers</h2>
            <ul>
                <?php
                $streamers = fetchstreamers();
                foreach ($streamers as $streamer) {
                    echo '<li><a href="#" onclick="showStream(\'' . $streamer['streamername'] . '\')"><img src="' . $streamer['streamericon'] . '"> ' . $streamer['streamername'] . '</a></li>';
                }
                ?>
            </ul>
            <button onclick="toggleForm()">Add Streamer</button>
        </div>
        <div class="stream-display">
            <div id="twitch-embed"></div>
        </div>
        <div id="streamerForm">
            <h2>Add a streamer</h2>
            <form action="process_form.php" method="POST">
                <label for="streamerName">Streamer Name:</label>
                <input type="text" id="streamerName" name="streamerName" placeholder="Rekkles" required>

                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="Top">Top</option>
                    <option value="Jungle">Jungle</option>
                    <option value="Mid">Mid</option>
                    <option value="ADC">ADC</option>
                    <option value="Support">Support</option>
                    <option value="Entertainer">Entertainer</option>
                </select>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script src="https://embed.twitch.tv/embed/v1.js"></script>
    <script type="text/javascript">
        var embed;
        function showStream(channel) {
            if (embed) {
                embed.setChannel(channel);
            } else {
                embed = new Twitch.Embed("twitch-embed", {
                    width: 1000,
                    height: 500,
                    channel: channel,
                });
            }
        }

    </script>

    <script>
        function toggleForm() {
            var form = document.getElementById('streamerForm');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
        
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('streamerForm').style.display = 'none';

            document.querySelector('#streamerForm form').addEventListener('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                fetch('process_form.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => { throw new Error(text); });
                    }
                    return response.text();
                })
                .then(data => {
                    alert('Streamer added successfully!');
                    document.querySelector('.streamers-list ul').innerHTML += data;
                    document.querySelector('#streamerForm form').reset();
                    document.getElementById('streamerForm').style.display = 'none';
                })
                .catch(error => {
                    alert(error.message);
                    console.error('Error:', error);
                    toggleForm();
                });
            });
        });
    </script>
</body>
</html>