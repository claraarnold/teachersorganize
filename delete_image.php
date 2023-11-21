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
                var $imageDeleteMessages = $(".message"); // Select elements with class 'message' once

                $imageDeleteMessages.fadeIn('slow'); // Fade in messages initially
                $imageDeleteMessages.fadeOut(5000); // Fade out messages after 5 seconds (adjust timing as needed)
            });
        </script>
    </head>
</header>

<body>
<div class="form-block">

    <h1>Delete an image below: </h1>
    <form method="post" action="image_delete_handler.php">
        <div id="upload_form"><label for="image title">Image title</label>
            <input type="text" value = "<?php echo isset($_SESSION['post']['deleteImageTitle']) ? $_SESSION['post']['deleteImageTitle'] : ''; ?>"
                   name="deleteImageTitle"/>
        </div>                                        name="deleteImageTitle"/></div>
        <div id="submit_box"><input type="submit" name="Delete" value="Delete"/></div>
    </form>
</div>

<?php

if (isset($_SESSION['imageDeleteMessages'])) {
    if (isset($_SESSION['imageDeleteMessages']['bad'])) {
        foreach ($_SESSION['imageDeleteMessages']['bad'] as $bad) {
            echo "<div class='imageDeleteMessages bad'>" . htmlspecialchars($bad) . "</div>";
        }
    }
    if (isset($_SESSION['imageDeleteMessages']['good'])) {
        foreach ($_SESSION['imageDeleteMessages']['good'] as $good) {
            echo "<div class='imageDeleteMessages good'>" . htmlspecialchars($good) . "</div>";
        }
    }
}

unset($_SESSION['imageDeleteMessages']);
unset($_SESSION['post']);

?>

</body>

</html>

