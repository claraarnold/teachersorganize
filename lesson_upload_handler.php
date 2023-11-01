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
    $uploadDirectory = "lessonPlans/";

    $uploadedFile = $_FILES['document']['tmp_name'];
    $uploadedFileName = basename($_FILES['document']['name']);

    $newFilePath = $uploadDirectory . $uploadedFileName;

    if (!move_uploaded_file($uploadedFile, $newFilePath)) {
        // Handle file move error
        $lessonMessages['bad'][] = "Error moving the uploaded document.";
        $_SESSION['lessonMessages'] = $lessonMessages;
        header('Location: upload_lesson.php');
        exit();
    }

    // Save the document in database
    $dao->saveDocument($subject, $newFilePath, $name, $date);
    header('Location: lessonplan.php');
    exit();
}


