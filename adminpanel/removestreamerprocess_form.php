<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $streamerName = $_POST['streamerName'];
    require_once 'adminfunctions.php';

    if (!getStreamerbynick($streamerName)) {
        header('Location: streamers.php?failure=1');
        exit;
    } else {
        removestreamer($streamerName);
        header('Location: streamers.php?success=2');
        exit;
    }
}
?>
