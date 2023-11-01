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
        <h1>Upload a video below: </h1>
        <form method="post" action="video_upload_handler.php">
            <div id="upload_form">Video title <input type="text"
                                                     value = "<?php echo isset($_SESSION['post']['title']) ? $_SESSION['post']['title'] : ''; ?>"
                                                     name="title"/></div>
            <div id="upload_form">Video link <input type="text"
                                                    value="<?php echo isset($_SESSION['post']['link']) ? $_SESSION['post']['link'] : ''; ?>"
                                                    name="link"
                                                    required pattern="https?://.+" title="https?://.+"></div>
            <div id="upload_form">Date <input type="date" name="date"/></div>
            <div id="submit_box"><input type="submit" name="Upload" value="Upload"/></div>
        </form>
    </div>

    <?php

    if (isset($_SESSION['videoMessages'])) {
        if (isset($_SESSION['videoMessages']['bad'])) {
            foreach ($_SESSION['videoMessages']['bad'] as $bad) {
                echo "<div class='videoMessage bad'>{$bad}</div>";
            }
        }
        if (isset($_SESSION['videoMessages']['good'])) {
            foreach ($_SESSION['videoMessages']['good'] as $good) {
                echo "<div class='videoMessage good'>{$good}</div>";
            }
        }
    }

    unset($_SESSION['videoMessages']);
    unset($_SESSION['post']);

    ?>

</body>

</html>
