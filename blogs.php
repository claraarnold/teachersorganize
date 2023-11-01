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
            ?>
        </div>

        <div class="header">Blogs</div>

        <table class="blog-table">
            <tr>
                <th>Helpful Websites</th>
                <th>Description</th>
            </tr>
            <tr>
                <td><a href="https://www.teachjunkie.com/">teach JUNKIE</a></td>
                <td>Free teaching ideas and activities for K through 5th grade.</td>
            </tr>
            <tr>
                <td><a href="http://www.primarypunch.com/">primary PUNCH</a></td>
                <td>Free materials which can be downloaded, blogs from other teachers,
                and an interactive community.</td>
            </tr>
            <tr>
                <td><a href="https://www.weareteachers.com/">We Are Teachers</a></td>
                <td>Subject organized ideas for grades K-5th and 6th-12th with articles
                abo</td>
            </tr>
            <tr>
                <td><a href="https://www.teacherspayteachers.com/browse/free?
                gclid=Cj0KCQjwpc-oBhCGARIsAH6ote9eYxSyGj-FEySAx7zIRNgSCIAohyZ
                zsV9Qw8JamFLI2LCqMdZTIhwaArvJEALw_wcB">TPT</a></td>
                <td>Free resources for all grades and all subjects based on
                    relevance, rating, price, and more</td>
            </tr>
            <tr>
                <td><a href="https://www.edutopia.org/">eduTopia</a></td>
                <td>Articles about communication skills, social and emotional learning,
                    and more! </td>
            </tr>
            <tr>
                <td><a href="https://www.readworks.org/">ReadWorks</a></td>
                <td>Provides high-quality content, tools, and support for
                reading comprehension.</td>
            </tr>
            <tr>
                <td><a href="https://readingeggs.com/">Reading Eggs</a></td>
                <td>Online reading games, activities, and apps for grades
                K-3rd.</td>
            </tr>
            <tr>
                <td><a href="http://www.chompchomp.com/">Grammar Bytes!</a></td>
                <td>Grammar instruction with attitude! Grammar quizzes, presentations,
                videos, and exercises.</td>
            </tr>
            <tr>
                <td><a href="https://teach4theheart.com/best-websites-for-teachers/">Mathseeds</a></td>
                <td>Online math games, activities, and an app for ages 3-9. </td>
            </tr>
            <tr>
                <td><a href="http://www.chompchomp.com/">Grammar Bytes!</a></td>
                <td>Grammar instruction with attitude! Grammar quizzes, presentations,
                    videos, and exercises.</td>
            </tr>
            <tr>
                <td><a href="https://www.splashlearn.com/">SplashLearn</a></td>
                <td>Free K-5 math program with games and rewards.</td>
            </tr>
            <tr>
                <td><a href="https://mysteryscience.com/">mysteryscience</a></td>
                <td>Ready-to-go science lessons for K-5 grade.</td>
            </tr>

        </table>

        <div class="space"> </div>

    </body>
</html>
