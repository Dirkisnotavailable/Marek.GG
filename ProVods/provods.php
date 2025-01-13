<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProVods</title>
    <link rel="stylesheet" href="/Testik/Provods/provods.css">
</head>
<body>
    <?php
    require_once '../Player/designfunctions.php';
    renderNavbar(); ?>
    <div class="container">
        <div class="streamers-list">
            <h2>Streamers</h2>
            <ul>
                <li><a href="#" onclick="showStream('humzh')"><img src="/Testik/Provods/icons/streamer1.png"> Streamer 1</a></li>
                <li><a href="#" onclick="showStream('streamer2')"><img src="/Testik/Provods/icons/streamer2.png"> Streamer 2</a></li>
                <li><a href="#" onclick="showStream('streamer3')"><img src="/Testik/Provods/icons/streamer3.png"> Streamer 3</a></li>
            </ul>
        </div>
        <div class="stream-display">
            <div id="twitch-embed"></div>
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
</body>
</html>