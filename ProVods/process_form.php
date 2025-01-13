<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $streamerName = $_POST['streamerName'];
    $role = $_POST['role'];
    require_once 'getstreamer.php';
    $idandicon = getstreamerid($streamerName);
    if (empty($idandicon['data'])) {
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

    /* Display the results
    echo "<pre>";
    print_r($idandicon);
    echo "</pre>";
    echo "<pre>";
    print_r($streamdata);
    echo "</pre>";
    echo "<pre>";
    print_r(fetchstreamers());
    echo "</pre>";
    echo "Role: " . htmlspecialchars($role);
*/
    }
?>
