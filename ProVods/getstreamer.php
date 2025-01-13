<?php


$clientkey = 'lvy6dxq98r60ltyoi4r6s3g1z63plm';
$client_secret = 'j2aowi0npspw28f4vsinqjuweo73b3';
$OAuthToken = '8d47aouuhl746v2s157kxl3spy87iw';

$ch = curl_init();

function getstreamerid($searchname)
{
    global $clientkey;
    global $client_secret;
    global $OAuthToken;
    global $ch;
    $fullurl = "https://api.twitch.tv/helix/users?login=$searchname";
    curl_setopt($ch, CURLOPT_URL, $fullurl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $OAuthToken",
        "Client-Id: $clientkey"
    ]);
    $response = json_decode(curl_exec($ch), true);

    return ($response);


}

/* KAZDYCH 3 MESIACE POTREBUJEM REFRESHNUT TWITCH OAUTH TOKEN
function getOAuthToken() {
    global $ch;
    global $clientkey;
    global $client_secret;
    $url = 'https://id.twitch.tv/oauth2/token';
    $data = [
        'client_id' => $clientkey,
        'client_secret' => $client_secret,
        'grant_type' => 'client_credentials',
    ];

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded',
    ]);
    $response = curl_exec($ch);

    $responseData = json_decode($response, true);

    print_r ($responseData);

    return $responseData['access_token'];
}

$OAuthToken = getOAuthToken();
------VYPIS------------
<pre>
<?php
    print_r (getuserid('xnapycz'));
?>
</pre>

*/
function getstreamdata($clientid)
{
    global $clientkey;
    global $client_secret;
    global $OAuthToken;
    global $ch;
    $fullurl = "https://api.twitch.tv/helix/streams?user_id=$clientid";
    curl_setopt($ch, CURLOPT_URL, $fullurl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $OAuthToken",
        "Client-Id: $clientkey"
    ]);
    $response = json_decode(curl_exec($ch), true);

    return ($response);




}
// LIVE STATY KTORE SA MOZU MENIT
if (empty($streamdata['data'])) {
    $islive = false;
    $viewercount = 0;
    $title = 'Streamer is offline';
} else {
    $islive = $streamdata['data'][0]['type'];
    $viewercount = $streamdata['data'][0]['viewer_count'];
    $title = $streamdata['data'][0]['title'];
}

/*
 ?>


<pre>
    <?php
    print_r($idandicon);
    ?>
</pre>
<pre>
    <?php
    print_r(getstreamdata($streamerid));

    ?>
</pre>
<pre>
    <?php
 print_r(fetchstreamers());

    print $islive;
    print $viewercount;
    print  $title;?>
</pre>
*/

?>