<?php
session_start();
require_once("login_nav.php");

?>

<html>

<head>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="form-block">
        <h1 id="register_header">Please register for an account below</h1>
        <form method="post" action="register_handler.php">
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
            <div id="login_form"><input type="submit" name="Register" value="Register"/></div>
        </form>
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

