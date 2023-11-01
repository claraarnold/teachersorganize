<?php

require_once("upload_nav.php");
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
    <h1>Upload a resource: </h1>
    <form method="post" action="resources_upload_handler.php" enctype="multipart/form-data">
        <label for="subject">Select a row:</label>
        <select name="subject" id="subject">
            <option value="Templates">Templates</option>
            <option value="Social-Emotional Exercises">Social-Emotional Exercises</option>
        </select>
        <div id="upload_form">Document name <input type="text"
                                                   value = "<?php echo isset($_SESSION['post']['name']) ? $_SESSION['post']['name'] : ''; ?>"
                                                   name="name"/></div>
        <div class="document-input">
            <label for="document">Choose a Document:</label>
            <input type="file" name="document" id="document">
        </div>

        <div class="submit-button">
            <input type="submit" name="upload" value="Upload Document">
        </div>
    </form>
</div>

<?php

if (isset($_SESSION['resourceMessages'])) {
    if (isset($_SESSION['resourceMessages']['bad'])) {
        foreach ($_SESSION['resourceMessages']['bad'] as $bad) {
            echo "<div class='resourceMessages bad'>{$bad}</div>";
        }
    }
    if (isset($_SESSION['resourceMessages']['good'])) {
        foreach ($_SESSION['resourceMessages']['good'] as $good) {
            echo "<div class='resourceMessages good'>{$good}</div>";
        }
    }
}

unset($_SESSION['resourceMessages']);
unset($_SESSION['post']);

?>

</body>

</html>
