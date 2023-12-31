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
                var $lessonMessages = $(".message"); // Select elements with class 'message' once

                $lessonMessages.fadeIn('slow'); // Fade in messages initially
                $lessonMessages.fadeOut(5000); // Fade out messages after 5 seconds (adjust timing as needed)
            });
        </script>
    </head>
</header>

<body>
<div class="form-block">
    <h1>Upload a lesson-plan: </h1>
    <form method="post" action="lesson_upload_handler.php">
        <label for="subject">Select Subject:</label>
        <select name="subject" id="subject">
            <option value="Math">Math</option>
            <option value="Science">Science</option>
            <option value="English">English</option>
            <option value="History">History</option>
            <option value="Brain Breaks">Brain Breaks</option>
            <option value="Spanish">Spanish</option>
            <option value="Art">Art</option>
        </select>
        <div id="upload_form"><label for="document title">Document title</label>
            <input type="text" value = "<?php echo isset($_SESSION['post']['name']) ? $_SESSION['post']['name'] : ''; ?>"
                   name="name"/>
        </div>
        <div id="upload_form"><label for="document link">Document link</label>
            <input type="text" value="<?php echo isset($_SESSION['post']['link']) ? $_SESSION['post']['link'] : ''; ?>"
                   name="link"
                   required pattern="https?://.+" title="https?://.+">
        </div>
        <div id="upload_form"><label for="date">Date</label>
            <input type="date" name="date"/>
        </div>
        <div class="submit-button">
            <input type="submit" name="upload" value="Upload Document">
        </div>
    </form>
</div>

<?php

if (isset($_SESSION['lessonMessages'])) {
    if (isset($_SESSION['lessonMessages']['bad'])) {
        foreach ($_SESSION['lessonMessages']['bad'] as $bad) {
            echo "<div class='lessonMessages bad'>" . htmlspecialchars($bad) . "</div>";
        }
    }
    if (isset($_SESSION['lessonMessages']['good'])) {
        foreach ($_SESSION['lessonMessages']['good'] as $good) {
            echo "<div class='lessonMessages good'>" . htmlspecialchars($good) . "</div>";
        }
    }
}

unset($_SESSION['lessonMessages']);
unset($_SESSION['post']);

?>

</body>

</html>

