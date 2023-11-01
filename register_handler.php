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
    $messages['bad'][] = "Please enter a USERNAME";
}
if(strlen($password) == 0) {
    $messages['bad'][] = "Please enter a PASSWORD";
}

if (count($messages['bad']) > 0) {
    // Set error messages and redirect back to register.php
    $_SESSION['messages'] = $messages;
    $_SESSION['post'] = $_POST;
    header('Location: register.php');
    exit();
}

// If the username is already taken
if ($dao->isUsernameTaken($username)) {
    // Username is already taken, display an error message
    $messages['bad'][] = "Username is already taken. Please choose a new username.";
    $_SESSION['messages'] = $messages;
    $_SESSION['post'] = $_POST;
    header('Location: register.php');
    exit();
}

$success = $dao->registerUser($first, $last, $username, $password);
if($success) {
    // Redirect to login page
    header('Location: login.php');
    $messages['good'][] = "Successfully created an account, please login!";
} else {
    // Set error message and redirect back to register.php
    $messages['bad'][] = "Registration failed. Please try again.";
    $_SESSION['messages'] = $messages;
    $_SESSION['post'] = $_POST;
    header('Location: register.php');
}

exit();

