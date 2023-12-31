<html>
    <head>
        <link rel="stylesheet" href="styles.css">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
    </head>

    <body>

        <div class="colored-box">
            <div class="nav-bar">
                <ul>
                    <li <?php if (basename($_SERVER['PHP_SELF']) == 'homebase.php') echo 'class="active"'; ?>><a href="homebase.php">Homebase</a></li>
                    <li <?php if (basename($_SERVER['PHP_SELF']) == 'images.php') echo 'class="active"'; ?>><a href="images.php">Images</a></li>
                    <li <?php if (basename($_SERVER['PHP_SELF']) == 'videos.php') echo 'class="active"'; ?>><a href="videos.php">Videos</a></li>
                    <li <?php if (basename($_SERVER['PHP_SELF']) == 'lessonplan.php') echo 'class="active"'; ?>><a href="lessonplan.php">Lesson-Plans</a></li>
                    <li <?php if (basename($_SERVER['PHP_SELF']) == 'blogs.php') echo 'class="active"'; ?>><a href="blogs.php">Blogs</a></li>
                    <li <?php if (basename($_SERVER['PHP_SELF']) == 'resources.php') echo 'class="active"'; ?>><a href="resources.php">Resources</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>

            <div id="favicon-container">
                <img id="favicon" src="favicon.ico" alt="Website Favicon">
            </div>

        </div>

        <div id="footer">
            <li class="first">2023 Teachers Organize</li>
            <li>
                <a href="resources.php">How the website works</a>
            </li>
            <li>
                <a href="http://www.boisestate.edu">Boise State University</a>
            </li>
        </div>


    </body>
</html>