<?php require_once("nav.php");
    session_start();
    require_once 'Dao.php';
    $dao = new Dao();

    // Checking authentication of user session
    if(!isset($_SESSION['authenticated'])) {
        header('Location: login.php');
        exit;
    }

    if ($_SESSION['authenticated']) {
        // Fetching user's 'first'
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $user = $dao->getUserInfo($user_id);
            $userFirstName = $user['first_name'];
        }
    }
?>

<html>
    <head>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>

        <!--Displaying user's first name-->
        <div class="persisted_header">
            <?php
            if (!empty($userFirstName)) {
                echo "Welcome, $userFirstName!";
            }
            ?>
        </div>

        <div class="header">Resources</div>

        <!--Upload and Delete Buttons-->
        <div class="low-upload-box">
            <form method="post" action="upload_resources.php">
                <input type="submit" value="Upload">
            </form>
            <form method="post" action="delete_resources.php">
                <input type="submit" value="Delete">
            </form>
        </div>

        <!--Displaying resources-->
        <div class="lesson-plan-table">
            <table>
                <?php
                $subjects = ["Templates", "Social-Emotional Exercises"];

                foreach ($subjects as $subject) {
                    $documents = $dao->getDocumentsByRow($subject);

                    echo '<tr>';
                    echo "<td>$subject</td>";

                    if (!empty($documents)) {
                        foreach ($documents as $document) {
                            $document_path = $document['document_path'];
                            $document_name = $document['name'];

                            // new column for each document name
                            echo '<td>';
                            echo '<a href="/teachersorganize/' . $document_path . '" target="_blank" class="document-link">';
                            echo $document_name;
                            echo '</a>';
                            echo '</td>';
                        }
                    } else {
                        // If no documents available, display message
                        echo '<td>No documents available</td>';
                    }

                    echo '</tr>';
                }
                ?>
            </table>
        </div>

        <div class="how-to-div">
            <h3>How the website works: </h3>
            <p class="paragraph">Welcome to Teachers Organize where you can organize all your images, videos, and lesson-plans into
                the days you want to use and present them to your class! For each image, video and lesson-plan you upload,
                you must give it a title in order for it to be displayed in an organized fashion. When deleting any of these forms,
                it will ask for the title which must be spelled correctly, or it won't be able to be found in the database!
            </p>
            <p class="paragraph">The video and lesson-plans titles will appear as a link that will take you right to your video or lesson-plan,
                while the images themselves are a link that will take you to your image in a larger form when clicked on.
            </p>
            <p class="paragraph">While uploading you will notice that each item you upload needs to be attached to a date. This is
                for your own benefit so when you need to look something up for the day's lectures, lessons, and activities it will be
                right there on the day you want it! You must upload each item with a date attach because we want to be able to
                keep all your forms organized and easy to find.
            </p>
        </div>

        <div class="space"> </div>

    </body>
</html>
