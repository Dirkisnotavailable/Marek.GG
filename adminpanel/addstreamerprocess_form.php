<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $streamerName = $_POST['streamerName'];
    $role = $_POST['role'];
    require_once 'getstreamer.php';
    require_once 'adminfunctions.php';
    $idandicon = getstreamerid($streamerName);
    if (empty($idandicon['data'])) {
        header('Location: streamers.php?failure=3');
        exit;
    } else if (!getStreamerbynick($streamerName)) {
        $streamerid = $idandicon['data'][0]['id'];
        $streamericon = $idandicon['data'][0]['profile_image_url'];
        $streamernick = $idandicon['data'][0]['display_name'];
        $streamdata = getstreamdata($streamerid);
        $viewercount = $streamdata['data'][0]['viewer_count'] ?? 0;
        $title = $streamdata['data'][0]['title'] ?? 'Streamer is offline';
    } else {
        header('Location: streamers.php?failure=2');
        exit;
    }
    require_once 'adminfunctions.php';
    insertstreamer($streamernick, $streamerid, $streamericon, $role);
    header('Location: streamers.php?success=1');
    //Pridat daco naozaj do succes=1
    exit();
}
?>
