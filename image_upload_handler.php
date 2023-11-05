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
$imageMessages = array();
$imageMessages['bad'] = array();

$title = trim($_POST['title']);
$link = trim($_POST['link']);
$date = $_POST['date'];

// Regular expression to match valid links
$linkPattern = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w\.-]*)*\/?$/';

// Check if video title and link are filled in
if (empty($title)) {
    $imageMessages['bad'][] = "Please enter the image TITLE";
}
if (empty($link)) {
    $imageMessages['bad'][] = "Please enter the image LINK";
} elseif (!preg_match($linkPattern, $link)) {
    $imageMessages['bad'][] = "Please enter a image LINK";
}
if (empty($date)) {
    $imageMessages['bad'][] = "Please select a DATE";
}


if (count($imageMessages['bad']) > 0) {
    // Set error messages and redirect back to upload_image.php
    $_SESSION['imageMessages'] = $imageMessages;
    $_SESSION['post'] = $_POST;
    header('Location: upload_image.php');
    exit();
} else { // if no bad messages redirect back to images.php
    $dao->saveImage($title, $link, $date);
    header('Location: images.php');
    exit();
}