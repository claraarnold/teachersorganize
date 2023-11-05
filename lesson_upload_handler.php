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
$lessonMessages = array();
$lessonMessages['bad'] = array();

$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$link = trim($_POST['link']);
$date = $_POST['date'];

// Check if all forms filled in
if(empty($subject)) {
    $lessonMessages['bad'][] = "Please select a subject from the drop-down menu above.";
}

if($_FILES['document']['error'] != UPLOAD_ERR_OK) {
    $lessonMessages['bad'][] = "Error uploading document.";
}

if(empty($name)) {
    $lessonMessages['bad'][] = "Please enter the document NAME";
}

if (empty($link)) {
    $lessonMessages['bad'][] = "Please enter the video LINK";
}

if (empty($date)) {
    $imageMessages['bad'][] = "Please select a DATE";
}

if (count($lessonMessages['bad']) > 0) {
    // Set error messages and redirect back to upload_lesson.php
    $_SESSION['lessonMessages'] = $lessonMessages;
    $_SESSION['post'] = $_POST;
    header('Location: upload_lesson.php');
    exit();
} else { // if no bad messages
    // Save the document in database
    $dao->saveDocument($subject, $link, $name, $date);
    header('Location: lessonplan.php');
    exit();
}


