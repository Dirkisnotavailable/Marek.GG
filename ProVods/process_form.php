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
    }
    require_once 'streamerdatabase.php';
    insertstreamer($streamernick, $streamerid, $streamericon, $role);
    echo '<li><a href="#" onclick="showStream(\'' . $streamernick . '\')"><img src="' . $streamericon . '"> ' . $streamernick . '</a></li>';
}
?>
