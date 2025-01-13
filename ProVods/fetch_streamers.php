<?php
require_once 'streamerdatabase.php';
require_once 'getstreamer.php';

$role = $_GET['role'] ?? null;
$streamers = fetchstreamers($role);

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
