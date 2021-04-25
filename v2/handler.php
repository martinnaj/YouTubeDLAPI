<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (isset($_GET['url'])) $url = $_GET['url']; elseif (isset($_POST['url'])) $url = $_POST['url']; else die(json_encode(['success' => false, 'error' => 'No URL']));

if ($url) {
    $ch = curl_init();
    curl_setopt_array($ch, [CURLOPT_URL => 'https://y2mate.guru/api/convert', CURLOPT_RETURNTRANSFER => 1, CURLOPT_POSTFIELDS => ['url' => $url]]);
        $response = curl_exec($ch);
    curl_close($ch);
    if ($response == file_get_contents("./assets/html/notFound.html")) die(json_encode(['success' => true, 'data' => []])); else die(json_encode(['success' => true, 'data' => json_decode($response, 1)]));
}else die(json_encode(['success' => false, 'error' => 'URL Empty']));

?>
