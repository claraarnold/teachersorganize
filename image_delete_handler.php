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
$imageDeleteMessages = array();
$imageDeleteMessages['bad'] = array();

$deleteImageTitle = trim($_POST['deleteImageTitle']);

// Checking that everything filled out
if (empty($deleteImageTitle)) {
    $imageDeleteMessages['bad'][] = "Please enter the image TITLE";
}
// Check if the title exists in the database
if (!$dao->imageExists($deleteImageTitle)) {
    $imageDeleteMessages['bad'][] = "Image not found in the database, please enter an image that is in the database.";
    $_SESSION['imageDeleteMessages'] = $imageDeleteMessages;
    header('Location: delete_image.php');
    exit();
}

if (count($imageDeleteMessages['bad']) > 0) {
    // Set error messages and redirect back to images.php
    $_SESSION['imageDeleteMessages'] = $imageDeleteMessages;
    header('Location: delete_image.php');
    exit();
} else {
    // If no bad messages, delete the image and redirect back to images.php
    $dao->deleteImage($deleteImageTitle);
    header('Location: images.php');
    exit();
}
