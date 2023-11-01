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

    <h1>Delete an image below: </h1>
    <form method="post" action="image_delete_handler.php">
        <div id="upload_form">Image title <input type="text"
                                                 value = "<?php echo isset($_SESSION['post']['deleteImageTitle']) ? $_SESSION['post']['deleteImageTitle'] : ''; ?>"
                                                 name="deleteImageTitle"/></div>
        <div id="submit_box"><input type="submit" name="Delete" value="Delete"/></div>
    </form>
</div>

<?php

if (isset($_SESSION['imageDeleteMessages'])) {
    if (isset($_SESSION['imageDeleteMessages']['bad'])) {
        foreach ($_SESSION['imageDeleteMessages']['bad'] as $bad) {
            echo "<div class='imageDeleteMessages bad'>{$bad}</div>";
        }
    }
    if (isset($_SESSION['imageDeleteMessages']['good'])) {
        foreach ($_SESSION['imageDeleteMessages']['good'] as $good) {
            echo "<div class='imageDeleteMessages good'>{$good}</div>";
        }
    }
}

unset($_SESSION['imageDeleteMessages']);
unset($_SESSION['post']);

?>

</body>

</html>
