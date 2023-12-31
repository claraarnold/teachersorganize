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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                var $imageMessages = $(".message"); // Select elements with class 'message' once

                $imageMessages.fadeIn('slow'); // Fade in messages initially
                $imageMessages.fadeOut(5000); // Fade out messages after 5 seconds (adjust timing as needed)
            });
        </script>
    </head>
</header>

<body>
<div class="form-block">
    <h1>Upload an image below: </h1>
    <form method="post" action="image_upload_handler.php">
        <div id="upload_form"><label for="image title">Image title</label>
            <input type="text" value = "<?php echo isset($_SESSION['post']['title']) ? $_SESSION['post']['title'] : ''; ?>"
                   name="title"/>
        </div>
        <div id="upload_form"><label for="image link">Image link</label>
            <input type="text" value="<?php echo isset($_SESSION['post']['link']) ? $_SESSION['post']['link'] : ''; ?>"
                   name="link"
                   required pattern="https?://.+" title="https?://.+">
        </div>
        <div id="upload_form"><label for="image date">Date</label>
            <input type="date"
                   name="date"/>
        </div>
        <div id="submit_box"><input type="submit" name="Upload" value="Upload"/></div>
    </form>
</div>

<?php

if (isset($_SESSION['imageMessages'])) {
    if (isset($_SESSION['imageMessages']['bad'])) {
        foreach ($_SESSION['imageMessages']['bad'] as $bad) {
            echo "<div class='imageMessages bad'>" . htmlspecialchars($bad) . "</div>";
        }
    }
    if (isset($_SESSION['imageMessages']['good'])) {
        foreach ($_SESSION['imageMessages']['good'] as $good) {
            echo "<div class='imageMessages good'>" . htmlspecialchars($good) . "</div>";
        }
    }
}

unset($_SESSION['imageMessages']);
unset($_SESSION['post']);

?>

</body>

</html>

