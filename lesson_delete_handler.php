<?php

session_start();

if (!isset($_SESSION['authenticated'])) {
    header('Location: login.php');
    exit;
}

if (isset($_SESSION['authenticated']) && !$_SESSION['authenticated']) {
    header('Location: login.php');
    exit;
}

require_once 'Dao.php';
$dao = new Dao();
$lessonDeleteMessages = array();
$lessonDeleteMessages['bad'] = array();

$deleteDocumentTitle = trim($_POST['deleteDocumentTitle']);

// Check if all forms filled in
if (empty($deleteDocumentTitle)) {
    $lessonDeleteMessages['bad'][] = "Please enter the document TITLE";
} else {
    // Check if the lesson plan exists in the database
    if (!$dao->documentExists($deleteDocumentTitle)) {
        $lessonDeleteMessages['bad'][] = "Document not found in the database, please enter a document name that is in the database.";
    } else {
        // If the lesson plan exists, delete it
        if (!$dao->deleteDocument($deleteDocumentTitle)) {
            $lessonDeleteMessages['bad'][] = "Error deleting the document from the database.";
        }
    }
}

if (count($lessonDeleteMessages['bad']) > 0) {
    // Set error messages and redirect back to delete_lesson.php
    $_SESSION['lessonDeleteMessages'] = $lessonDeleteMessages;
    header('Location: delete_lesson.php');
    exit();
} else {
    // If no bad messages, redirect back to lessonplan.php
    header('Location: lessonplan.php');
    exit();
}
