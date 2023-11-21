<?php
require_once("login_nav.php");
session_start();
?>

<html>

    <head>
        <link rel="stylesheet" href="login.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                var $messages = $(".message"); // Select elements with class 'message' once

                $messages.fadeIn('slow'); // Fade in messages initially
                $messages.fadeOut(5000); // Fade out messages after 5 seconds (adjust timing as needed)
            });
        </script>
    </head>

    <body>
        <div class="form-block">
            <h1>Login</h1>
            <form method="post" action="login_handler.php">
                <div id="login_form"><label for="first name">First name:</label>
                    <input type="text" value = "<?php echo isset($_SESSION['post']['first']) ? $_SESSION['post']['first'] : ''; ?>"
                           name="first"/>
                </div>
                <div id="login_form"><label for="last name">Last name:</label>
                    <input type="text" value = "<?php echo isset($_SESSION['post']['last']) ? $_SESSION['post']['last'] : ''; ?>"
                           name="last"/>
                </div>
                <div id="login_form"><label for="username">Username:</label>
                    <input type="text" value = "<?php echo isset($_SESSION['post']['username']) ? $_SESSION['post']['username'] : ''; ?>"
                           name="username"/>
                </div>
                <div id="login_form"><label for="password">Password:</label>
                    <input type="password" value = "<?php echo isset($_SESSION['post']['password']) ? $_SESSION['post']['password'] : ''; ?>"
                           name="password"/>
                </div>
                <div id="submit_box"><input type="submit" name="Login" value="Login"/></div>
            </form>
            <h5>Or register for an account: <a href="register.php">Register</a></h5>
        </div>

        <?php
        if (isset($_SESSION['messages'])) {
            if (isset($_SESSION['messages']['bad'])) {
                foreach ($_SESSION['messages']['bad'] as $bad) {
                    echo "<div class='message bad'>{$bad}</div>";
                }
            }
            if (isset($_SESSION['messages']['good'])) {
                foreach ($_SESSION['messages']['good'] as $good) {
                    echo "<div class='message good'>{$good}</div>";
                }
            }
        }

        unset($_SESSION['messages']);
        unset($_SESSION['post']);
        ?>
    </body>

</html>
