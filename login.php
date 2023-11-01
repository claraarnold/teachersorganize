<?php
require_once("login_nav.php");
session_start();
?>

<html>

    <head>
        <link rel="stylesheet" href="login.css">
    </head>

    <body>
        <div class="form-block">
            <h1>Login</h1>
            <form method="post" action="login_handler.php">
                <div id="login_form">First name: <input type="text"
                                                        value = "<?php echo isset($_SESSION['post']['first']) ? $_SESSION['post']['first'] : ''; ?>"
                                                        name="first"/></div>
                <div id="login_form">Last name: <input type="text"
                                                       value = "<?php echo isset($_SESSION['post']['last']) ? $_SESSION['post']['last'] : ''; ?>"
                                                       name="last"/></div>
                <div id="login_form">Username: <input type="text"
                                                      value = "<?php echo isset($_SESSION['post']['username']) ? $_SESSION['post']['username'] : ''; ?>"
                                                      name="username"/></div>
                <div id="login_form">Password: <input type="password"
                                                      value = "<?php echo isset($_SESSION['post']['password']) ? $_SESSION['post']['password'] : ''; ?>"
                                                      name="password"/></div>
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
