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

// Functions to get the first day of the month and the number of days in a month
function getFirstDay($year, $month) {
    return date("w", strtotime("$year-$month-01"));
}

function getDaysInMonth($year, $month) {
    return date("t", strtotime("$year-$month-01"));
}

$currentMonth = date('n'); // Get the current month (1-12)
$currentYear = date('Y'); // Get the current year (e.g., 2023)

$month = isset($_GET['month']) ? intval($_GET['month']) : $currentMonth;
$year = isset($_GET['year']) ? intval($_GET['year']) : $currentYear;

$firstDayOfWeek = getFirstDay($year, $month);
$daysInMonth = getDaysInMonth($year, $month);

// Calculate the previous and next months
$prevMonth = ($month > 1) ? $month - 1 : 12;
$prevYear = ($month > 1) ? $year : $year - 1;
$nextMonth = ($month < 12) ? $month + 1 : 1;
$nextYear = ($month < 12) ? $year : $year + 1;

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

<!-- Calendar -->
<div class="month">
    <ul>
        <li><a href="?month=<?php echo $prevMonth; ?>&year=<?php echo $prevYear; ?>" class="prev">Prev</a></li>
        <li><a href="?month=<?php echo $nextMonth; ?>&year=<?php echo $nextYear; ?>" class="next">Next</a></li>
        <li><?php echo date('F Y', strtotime("$year-$month-01")); ?></li>
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
    // Fill in empty cells before the first day of the month
    for ($i = 0; $i < $firstDayOfWeek; $i++) {
        echo '<li></li>';
    }

    // Loop through the days of the month
    for ($i = 1; $i <= $daysInMonth; $i++) {
        // Determine if the current day is the active day (today)
        $isCurrentDay = ($i == date('j') && $month == date('n') && $year == date('Y'));

        if ($isCurrentDay) {
            echo '<li><span class="active">' . $i . '</span></li>';
        } else {
            echo '<li>' . $i . '</li>';
        }

        // Start a new row at the beginning of each week
        if (($i + $firstDayOfWeek) % 7 === 0 || $i === $daysInMonth) {
            echo '</ul><ul class="days">';
        }
    }
    ?>
</ul>

<div class="space"> </div>

</body>
</html>
