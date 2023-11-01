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
$resourceDeleteMessages = array();
$resourceDeleteMessages['bad'] = array();

$deleteDocumentTitle = trim($_POST['deleteDocumentTitle']);

// Check if the title form field is empty
if (empty($deleteDocumentTitle)) {
    $resourceDeleteMessages['bad'][] = "Please enter the document TITLE";
} else {
    // Check if the resource exists in the database
    if (!$dao->resourceExists($deleteDocumentTitle)) {
        $resourceDeleteMessages['bad'][] = "Document not found in the database, please enter a document name that is in the database.";
    } else {
        // If the resource exists, delete it
        if (!$dao->deleteResource($deleteDocumentTitle)) {
            $resourceDeleteMessages['bad'][] = "Error deleting the document from the database.";
        }
    }
}

if (count($resourceDeleteMessages['bad']) > 0) {
    // Set error messages and redirect back to delete_resources.php
    $_SESSION['resourceDeleteMessages'] = $resourceDeleteMessages;
    header('Location: delete_resources.php');
    exit();
} else {
    // If no bad messages, redirect back to resources.php
    header('Location: resources.php');
    exit();
}
