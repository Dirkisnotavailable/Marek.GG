<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $streamerName = $_POST['streamerName'];
    $role = $_POST['role'];
    require_once 'getstreamer.php';
    $idandicon = getstreamerid($streamerName);
    if (empty($idandicon['data'])) {
        http_response_code(404);
        echo "Streamer not found!";
        exit;
    } else {
        $streamerid = $idandicon['data'][0]['id'];
        $streamericon = $idandicon['data'][0]['profile_image_url'];
        $streamernick = $idandicon['data'][0]['display_name'];
        $streamdata = getstreamdata($streamerid);
        $viewercount = $streamdata['data'][0]['viewer_count'] ?? 0;
        $title = $streamdata['data'][0]['title'] ?? 'Streamer is offline';
    }
    require_once 'streamerdatabase.php';
    insertstreamer($streamernick, $streamerid, $streamericon, $role);
    echo '<li class="streamerbunk" onclick="showStream(\'' . $streamernick . '\')">
            <img src="' . $streamericon . '"> 
            <div class="streamer-info">
                <div class="streamer-header">
                    <span class="streamer-name">' . $streamernick . '</span>
                    <span class="viewer-count">Viewers: ' . $viewercount . '</span>
                </div>
                <div class="stream-title">
                    <p>' . $title . '</p>
                </div>
            </div>
          </li>';
}
?>
