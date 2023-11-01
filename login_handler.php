<?php
session_start();

require_once 'Dao.php';
$dao = new Dao();
$messages = array();
$messages['bad'] = array();

$first = trim($_POST['first']);
$last = trim($_POST['last']);
$username = trim($_POST['username']);
$password = trim($_POST['password']);



// Check if first, last, username, and password are filled in
if(strlen($first) == 0) {
    $messages['bad'][] = "Please enter your FIRST NAME";
}
if(strlen($last) == 0) {
    $messages['bad'][] = "Please enter your LAST NAME";
}
if(strlen($username) == 0) {
    $messages['bad'][] = "Please enter your USERNAME";
}
if(strlen($password) == 0) {
    $messages['bad'][] = "Please enter your PASSWORD";
}

if (count($messages['bad']) > 0) {
    // Set error messages and redirect back to login.php
    $_SESSION['messages'] = $messages;
    $_SESSION['post'] = $_POST;
    header('Location: login.php');
    exit();
}

$_SESSION['authenticated'] = $dao->authenticate($first, $last, $username, $password);

if($_SESSION['authenticated']) {
    $user = $dao->getUserInfo($_SESSION['user_id']);
    $_SESSION['first_name'] = $user['first_name'];
    // Redirect to home page if authentication is successful
    header('Location: homebase.php');
} else {
    // Set error message and redirect back to login.php
    $messages['bad'][] = "Login failed. Please try again.";
    $_SESSION['messages'] = $messages;
    $_SESSION['post'] = $_POST;
    header('Location: login.php');
}

exit();