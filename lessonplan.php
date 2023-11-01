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

    // Handling display of lesson-plans on a chosen day
    $dateString = "";
    $selectedDate = isset($_GET['days']) ? $_GET['days'] : null;
    if (!empty($selectedDate)) {
        list($month, $day, $year) = explode('_', $selectedDate);
        $dateString = "20$year-$month-$day";
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

        <div class="header">Lesson Plans</div>

        <!--Menu to display images for specific date-->
        <div class="drop-menu">
            <h4 class="daily-schedules">Daily Schedules</h4>
            <form method="get">
                <select id="schedules" name="days">
                    <?php
                    $currentYear = date('Y');  // current year
                    $startDate = strtotime($currentYear . '-01-01'); // start day
                    $endDate = strtotime($currentYear . '-12-31');   // end day

                    for ($timestamp = $startDate; $timestamp <= $endDate; $timestamp += 86400) {
                        $date = date('m/d/y', $timestamp);
                        $value = date('m_d_y', $timestamp);
                        echo "<option value=\"$value\" " . ($value === $selectedDate ? 'selected' : '') . ">$date</option>";
                    }
                    ?>
                </select>
                <!--button to show images of chose date-->
                <div id="show"><input type="submit" value="Show Lessons"></div>
            </form>
        </div>

        <!--Upload and Delete Buttons-->
        <div class="low-upload-box">
            <form method="post" action="upload_lesson.php">
                <input type="submit" value="Upload">
            </form>
            <form method="post" action="delete_lesson.php">
                <input type="submit" value="Delete">
            </form>
        </div>

        <!--Displaying lesson plans-->
        <div class="lesson-plan-table">
            <table>
                <?php
                $subjects = ["Math", "Science", "English", "History", "Brain Breaks", "Spanish", "Art"];

                foreach ($subjects as $subject) {
                    $documents = $dao->getDocumentsBySubjectAndDate($subject, $dateString);

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

        <div class="space"> </div>

    </body>
</html>
