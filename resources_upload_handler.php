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
$resourceMessages = array();
$resourceMessages['bad'] = array();

$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$link = trim($_POST['link']);

// Check if name and file are filled in
if(empty($subject)) {
    $resourceMessages['bad'][] = "Please select a row to upload to from the drop-down menu above.";
}

if($_FILES['document']['error'] != UPLOAD_ERR_OK) {
    $resourceMessages['bad'][] = "Error uploading document.";
}

if(empty($name)) {
    $resourceMessages['bad'][] = "Please enter the document NAME";
}

if (empty($link)) {
    $resourceMessages['bad'][] = "Please enter the video LINK";
}

if (count($resourceMessages['bad']) > 0) {
    // Set error messages and redirect back to upload_resources.php
    $_SESSION['resourceMessages'] = $resourceMessages;
    $_SESSION['post'] = $_POST;
    header('Location: upload_resources.php');
    exit();
} else { // if no bad messages
    // Save the document in database
    $dao->saveResource($subject, $link, $name);
    header('Location: resources.php');
    exit();
}
