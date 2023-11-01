<?php require_once("nav.php");
session_start();
require_once 'Dao.php';
$dao = new Dao();

    if(!isset($_SESSION['authenticated'])) {
        header('Location: login.php');
        exit;
    }

    if ($_SESSION['authenticated']) {
    // The user is authenticated, fetch their first name
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
        <div class="persisted_header">
            <?php
            if (!empty($userFirstName)) {
                echo "Welcome, $userFirstName!";
            }
            // Other header content goes here
            ?>
        </div>

        <div class="header">
            Homebase
        </div>

        <hr>

        <!--    Calendar-->
        <?php
        $currentMonth = date('n'); // Get the current month (1-12)
        $currentYear = date('Y'); // Get the current year (e.g., 2023)

        $month = isset($_GET['month']) ? intval($_GET['month']) : $currentMonth;
        $year = isset($_GET['year']) ? intval($_GET['year']) : $currentYear;

        $firstDayTimestamp = strtotime("$year-$month-01");
        $firstDayOfWeek = date('w', $firstDayTimestamp); // 0 (Sun) to 6 (Sat)
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        // Calculate the previous and next months
        $prevMonth = date('n', strtotime("-1 month", $firstDayTimestamp));
        $prevYear = date('Y', strtotime("-1 month", $firstDayTimestamp));
        $nextMonth = date('n', strtotime("+1 month", $firstDayTimestamp));
        $nextYear = date('Y', strtotime("+1 month", $firstDayTimestamp));
        ?>

        <div class="month">
            <ul>
                <li><a href="?month=<?php echo $prevMonth; ?>&year=<?php echo $prevYear; ?>" class="prev">Prev</a></li>
                <li><a href="?month=<?php echo $nextMonth; ?>&year=<?php echo $nextYear; ?>" class="next">Next</a></li>
                <li><?php echo date('F Y', $firstDayTimestamp); ?></li>
            </ul>
        </div>

        <ul class="weekdays">
            <li>Sun</li>
            <li>Mon</li>
            <li>Tue</li>
            <li>Wed</li>
            <li>Thu</li>
            <li>Fri</li>
            <li>Sat</li>
        </ul>

        <ul class="days">
            <?php
            for ($i = 0; $i < $firstDayOfWeek; $i++) {
                echo '<li></li>'; // Add empty cells for days before the 1st of the month
            }

            for ($i = 1; $i <= $daysInMonth; $i++) {
                $dayOfWeek = date('w', strtotime("$year-$month-$i")); // Calculate the day of the week for the current date
                $isCurrentDay = ($i == date('j') && $month == date('n') && $year == date('Y'));

                if ($isCurrentDay) {
                    echo '<li><span class="active">' . $i . '</span></li>';
                } else {
                    echo '<li>' . ($dayOfWeek == 0 ? '<span class="sun">' : '') . $i . ($dayOfWeek == 0 ? '</span>' : '') . '</li>';
                }
            }
            ?>
        </ul>

        </ul>

    <div class="space"> </div>

    </body>
</html>
