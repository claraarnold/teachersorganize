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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                var $videoDeleteMessages = $(".message"); // Select elements with class 'message' once

                $videoDeleteMessages.fadeIn('slow'); // Fade in messages initially
                $videoDeleteMessages.fadeOut(5000); // Fade out messages after 5 seconds (adjust timing as needed)
            });
        </script>
    </head>
</header>

<body>
<div class="form-block">

    <h1>Delete a video below: </h1>
    <form method="post" action="video_delete_handler.php">
        <div id="upload_form">Video title <input type="text"
                                                 value = "<?php echo isset($_SESSION['post']['deleteTitle']) ? $_SESSION['post']['deleteTitle'] : ''; ?>"
                                                 name="deleteTitle"/></div>
        <div id="submit_box"><input type="submit" name="Delete" value="Delete"/></div>
    </form>
</div>

<?php

if (isset($_SESSION['videoDeleteMessages'])) {
    if (isset($_SESSION['videoDeleteMessages']['bad'])) {
        foreach ($_SESSION['videoDeleteMessages']['bad'] as $bad) {
            echo "<div class='videoDeleteMessages bad'>{$bad}</div>";
        }
    }
    if (isset($_SESSION['videoDeleteMessages']['good'])) {
        foreach ($_SESSION['videoDeleteMessages']['good'] as $good) {
            echo "<div class='videoDeleteMessages good'>{$good}</div>";
        }
    }
}

unset($_SESSION['videoDeleteMessages']);
unset($_SESSION['post']);

?>

</body>

</html>
