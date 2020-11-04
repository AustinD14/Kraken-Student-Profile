<?php
session_start();

// check login condition
if (!isset($_SESSION["NAME"])) {
    header("Location: logout.php");
    exit;
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Main</title>
    </head>
    <body>
        <h1>Main menu</h1>
        <!-- ユーザーIDにHTMLタグが含まれても良いようにエスケープする -->
        <p>Welcome <u><?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?></u></p>
        <ul>
            <li><a href="logout.php">logout</a></li>
        </ul>
    </body>
</html>