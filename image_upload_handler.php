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
$date = $_POST['date'];

// Checking that everything is filled out
if(empty($title)) {
        $imageMessages['bad'][] = "Please enter the image TITLE";
}

if (empty($date)) {
    $imageMessages['bad'][] = "Please select a DATE";
}

if($_FILES['image']['error'] != UPLOAD_ERR_OK) {
    $imageMessages['bad'][] = "Error uploading image.";
}

if (count($imageMessages['bad']) > 0) {
    // Set error messages and redirect back to upload_image.php
    $_SESSION['imageMessages'] = $imageMessages;
    $_SESSION['post'] = $_POST;
    header('Location: upload_image.php');
    exit();
} else { // if no bad messages
    $uploadDirectory = "websiteImages/";

    $uploadedFile = $_FILES['image']['tmp_name'];
    $uploadedFileName = basename($_FILES['image']['name']);

    $newFilePath = $uploadDirectory . $uploadedFileName;

    if (!move_uploaded_file($uploadedFile, $newFilePath)) {
        // Handle file move error
        $imageMessages['bad'][] = "Error moving the uploaded image.";
        $_SESSION['imageMessages'] = $imageMessages;
        header('Location: upload_image.php');
        exit();
    }

    // Saving the image in database
    $dao->saveImage($title, $newFilePath, $date);
    header('Location: images.php');
    exit();
}

