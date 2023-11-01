<?php require_once("nav.php");
    session_start();
    require_once 'Dao.php';
    $dao = new Dao();
    $videos = $dao->getVideos();

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

    // Handling display of videos on a chosen day
    $selectedDate = isset($_GET['days']) ? $_GET['days'] : null;
    if (!empty($selectedDate)) {
        list($month, $day, $year) = explode('_', $selectedDate);
        $dateString = "20$year-$month-$day";
        $videos = $dao->getVideosByDate($dateString);
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

        <div class="header">Videos</div>

        <!--Upload and Delete Buttons-->
        <div class="low-upload-box">
            <form method="post" action="upload_video.php">
                <input type="submit" value="Upload">
            </form>

            <form method="post" action="delete_video.php">
                <input type="submit" value="Delete">
            </form>
        </div>

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
                <div id="show"><input type="submit" value="Show Videos"></div>
            </form>
        </div>

        <!--Displaying videos-->
        <table class="video-container">
            <tr>
                <?php $count = 0; ?>
                <?php foreach ($videos as $video): ?>
                <td>
                    <div class="video-box">
                        <a href="<?php echo $video['link']; ?>"> <?php echo $video['title'];?> </a>

                    </div>
                </td>
                <?php $count++; ?>
                <?php if ($count === 5): ?>
            </tr><tr>
                <?php $count = 0; ?>
                <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        </table>

        <div class="space"> </div>

    </body>
</html>