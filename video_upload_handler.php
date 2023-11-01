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
$videoMessages = array();
$videoMessages['bad'] = array();

$title = trim($_POST['title']);
$link = trim($_POST['link']);
$date = $_POST['date'];

// Regular expression to match valid links
$linkPattern = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w\.-]*)*\/?$/';

// Check if video title and link are filled in
if(strlen($title) == 0 || strlen($link) == 0) {
    if (empty($title)) {
        $videoMessages['bad'][] = "Please enter the video TITLE";
    }
    if (empty($link)) {
        $videoMessages['bad'][] = "Please enter the video LINK";
    } elseif (!preg_match($linkPattern, $link)) {
        $videoMessages['bad'][] = "Please enter a valid LINK";
    }
    if (empty($date)) {
        $videoMessages['bad'][] = "Please select a DATE";
    }
}

if (count($videoMessages['bad']) > 0) {
    // Set error messages and redirect back to upload_video.php
    $_SESSION['videoMessages'] = $videoMessages;
    $_SESSION['post'] = $_POST;
    header('Location: upload_video.php');
    exit();
} else { // if no bad messages redirect back to videos.php
    $dao->saveVideo($title, $link, $date);
    header('Location: videos.php');
    exit();
}