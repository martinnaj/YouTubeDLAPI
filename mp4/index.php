<?php
function get_youtube_title($video_id){
        $response = file_get_contents("https://www.youtube.com/watch?v=$video_id");
        $takeAllAfter = ",\\\"title\\\":\\\"";
        $response = substr($response, strripos($response, $takeAllAfter)+strlen($takeAllAfter));
        $response = substr($response, 0, strpos($response, "\\\",\\\"leng"));
        return $response;
    } 
 
// Load and initialize downloader class 
include_once 'YouTubeDownloader.class.php'; 
$handler = new YouTubeDownloader(); 
 
// Youtube video url 
if(isset($_POST['id'])){$id = $_POST['id'];}elseif(isset($_GET['id'])){$id = $_GET['id'];}
if(isset($id)) {
    $youtubeURL = "https://youtube.com/watch?v=$id"; 
}
 
// Check whether the url is valid 
if(!empty($id) && !filter_var($youtubeURL, FILTER_VALIDATE_URL) === false){ 
    // Get the downloader object 
    $downloader = $handler->getDownloader($youtubeURL); 
     
    // Set the url 
    $downloader->setUrl($youtubeURL); 
     
    // Validate the youtube video url 
    if($downloader->hasVideo()){ 
        // Get the video download link info 
        $videoDownloadLink = $downloader->getVideoDownloadLink(); 
        $videoTitle = $title = get_youtube_title($id);
        $videoQuality = $videoDownloadLink[0]['qualityLabel']; 
        $videoFileName = "$videoTitle.mp4";
        $downloadURL = $videoDownloadLink[0]; 
        $fileName = $videoFileName;
         
        if(!empty($downloadURL)){ 
            //Define header for force download 
            header("Cache-Control: public"); 
            header("Content-Description: File Transfer"); 
            header("Content-Disposition: attachment; filename=$videoFileName"); 
            header("Content-Type: application/zip"); 
            header("Content-Transfer-Encoding: binary"); 
             
            // Read the file 
            readfile($downloadURL); 
        } 
    }else{ 
        echo "The video is not found, please check YouTube ID."; 
    } 
}else{ 
    echo "Please provide valid ID."; 
} 
 
?>
