<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marek.gg - ProVods</title>
    <link rel="stylesheet" href="/Testik/Provods/provods.css">
    <style>
        #streamerForm {
            display: none;
        }
    </style>
</head>
<body>
    <?php
    require_once '../Library/sessionstart.php';
    require_once '../CSS/designfunctions.php';
    renderNavbar();
    require_once 'streamerdatabase.php';
    require_once 'getstreamer.php';
    ?>
    <div class="container">
        <div class="streamers-list">
            <div class="role-buttons">
                <button onclick="filterStreamers('Support', this)">SUP</button>
                <button onclick="filterStreamers('ADC', this)">ADC</button>
                <button onclick="filterStreamers('Mid', this)">MID</button>
                <button onclick="filterStreamers('Jungle', this)">JGL</button>
                <button onclick="filterStreamers('Top', this)">TOP</button>
            </div>
            <ul id="streamerList">
                <?php
                $streamers = fetchstreamers();
                foreach ($streamers as $streamer) {
                    $data = getstreamdata($streamer['streamerid']);
                    $viewercount = $data['data'][0]['viewer_count'] ?? 0;
                    $title = $data['data'][0]['title'] ?? 'Streamer is offline';
                    echo '<li class="streamerbunk" onclick="showStream(\'' . $streamer['streamername'] . '\')">
                            <img src="' . $streamer['streamericon'] . '"> 
                            <div class="streamer-info">
                                <div class="streamer-header">
                                    <span class="streamer-name">' . $streamer['streamername'] . '</span>
                                    <span class="viewer-count">Viewers: ' . $viewercount . '</span>
                                </div>
                                <div class="stream-title">
                                    <p>' . $title . '</p>
                                </div>
                            </div>
                          </li>';
                }
                ?>
                <button onclick="toggleForm()" class="addstreamerbutton">Add Streamer</button>
            </ul>
            <div id="streamerForm">
                <form>
                    <label for="streamerName">Streamer Name:</label>
                    <input type="text" id="streamerName" name="streamerName" required>
                    <label for="role">Role:</label>
                    <select id="role" name="role" required>
                        <option value="Support">Support</option>
                        <option value="ADC">ADC</option>
                        <option value="Mid">Mid</option>
                        <option value="Jungle">Jungle</option>
                        <option value="Top">Top</option>
                    </select>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
        <div class="stream-display">
            <div id="twitch-embed"></div>
        </div>
    </div>

    <script src="https://embed.twitch.tv/embed/v1.js"></script>
    <script type="text/javascript">
        var embed;
        var selectedRole = null;

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

        function filterStreamers(role, button) {
            if (selectedRole === role) {
                selectedRole = null;
                button.classList.remove('selected');
                fetch('fetch_streamers.php')
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('streamerList').innerHTML = data;
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                selectedRole = role;
                document.querySelectorAll('.role-buttons button').forEach(btn => btn.classList.remove('selected'));
                button.classList.add('selected');
                fetch('fetch_streamers.php?role=' + role)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('streamerList').innerHTML = data;
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

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
<footer>
    <?php
    renderFooter();
    ?>
</footer>
</html>