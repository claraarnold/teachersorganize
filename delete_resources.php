<?php
require_once("delete_nav.php");
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

?>

<html>

<header>
    <head>
        <link rel="stylesheet" href="upload_delete.css">
    </head>
</header>

<body>
<div class="form-block">
    <h1>Delete a document below: </h1>
    <form method="post" action="resources_delete_handler.php">
        <div id="upload_form">Document Title <input type="text"
                                                    value="<?php echo isset($_SESSION['post']['deleteDocumentTitle']) ? $_SESSION['post']['deleteDocumentTitle'] : ''; ?>"
                                                    name="deleteDocumentTitle" /></div>
        <div id="submit_box"><input type="submit" name="Delete" value="Delete" /></div>
    </form>
</div>

<?php

if (isset($_SESSION['resourceDeleteMessages'])) {
    if (isset($_SESSION['resourceDeleteMessages']['bad'])) {
        foreach ($_SESSION['resourceDeleteMessages']['bad'] as $bad) {
            echo "<div class='resourceDeleteMessages bad'>{$bad}</div>";
        }
    }
    if (isset($_SESSION['resourceDeleteMessages']['good'])) {
        foreach ($_SESSION['resourceDeleteMessages']['good'] as $good) {
            echo "<div class='resourceDeleteMessages good'>{$good}</div>";
        }
    }
}

unset($_SESSION['resourceDeleteMessages']);
unset($_SESSION['post']);

?>

</body>

</html>
