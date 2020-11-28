<?php
session_start();

if (isset($_SESSION["NAME"])) {
    $errorMessage = "logged out";
} else {
    $errorMessage = "timeout session";
}

// clear session
$_SESSION = array();

//
@session_destroy();
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Logout</title>
    </head>
    <body>
        <h1>Logout</h1>
        <div><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></div>
        <ul>
            <li><a href="Login.php">Back to login page</a></li>
        </ul>
    </body>
</html>