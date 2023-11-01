<?php
session_start();

if(!isset($_SESSION['authenticated'])) {
    header('Location: login.php');
    exit;
}

if(isset($_SESSION['authenticated']) && !$_SESSION['authenticated']) {
    header('Location: login.php');
    exit;
}

require_once 'Dao.php';
$dao = new Dao();
$videoDeleteMessages = array();
$videoDeleteMessages['bad'] = array();

$deleteTitle = trim($_POST['deleteTitle']);

// Check if all forms filled in
if (empty($deleteTitle)) {
    $videoDeleteMessages['bad'][] = "Please enter the video TITLE";
}

// Check if the title exists in the database
if (!$dao->videoExists($deleteTitle)) {
    $videoDeleteMessages['bad'][] = "Video not found in the database, please enter a video that is in the database.";
    $_SESSION['videoDeleteMessages'] = $videoDeleteMessages;
    header('Location: delete_video.php');
    exit();
}

if (count($videoDeleteMessages['bad']) > 0) {
    // Set error messages and redirect back to videos.php
    $_SESSION['videoDeleteMessages'] = $videoDeleteMessages;
    header('Location: delete_video.php');
    exit();
} else {
    // If no bad messages, delete the video and redirect back to videos.php
    $dao->deleteVideos($deleteTitle);
    header('Location: videos.php');
    exit();
}
