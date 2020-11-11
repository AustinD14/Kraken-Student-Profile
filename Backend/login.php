<?php
// require 'password.php'; //php5.5.0~
//require_once 'dbconnect.php';
session_start();

// Attention, these variables are needed to change to your or AWS environment.
$db['host'] = "localhost";  //
$db['user'] = "pma";  //
$db['pass'] = "123456";  //
$db['dbname'] = "Student_Profile";  //

// init error message
$errorMessage = "";

// Login btn
if (isset($_POST["login"])) {
    // user email
    if (empty($_POST["mail"])) {  // empty if blank
        $errorMessage = 'No email address entered';
    } else if (empty($_POST["password"])) {
        $errorMessage = 'No password entered';
    }

    if (!empty($_POST["mail"]) && !empty($_POST["password"])) {
        //
        $mail = $_POST["mail"];

        //
        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8mb4', $db['host'], $db['dbname']);

        //
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

            $stmt = $pdo->prepare('SELECT * FROM user_data WHERE mail = ?');
            $stmt->execute(array($mail));

            $password = $_POST["password"];
            //$password_hash =  password_hash($password, PASSWORD_DEFAULT);
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($password, $row['password'])) {
                    session_regenerate_id(true);

                    // get user name
                    /*
                    $mail = $row['mail'];
                    $sql = "SELECT * FROM user_data WHERE mail = $mail";  //obtain name correspond to mail
                    $stmt = $pdo->query($sql);
                    foreach ($stmt as $row) {
                        $row['name'];  // user name
                    }*/
                    $_SESSION["NAME"] = $row['name'];
                    $_SESSION["ROLE"] = $row['role'];
                    if ($_SESSION["ROLE"] == 0) {
                        header("Location: main.php");  // move to student main
                        exit();
                    } else {
                        header("Location: professor_main.php");
                    }
                } else {
                    // failed
                    //var_dump($row['password']);
                    $errorMessage = 'Email ooor Password is wrong.';
                }
            } else {
                //
                // cant find data
                $errorMessage = 'Email or Password is wrong.';
            }
        } catch (PDOException $e) {
            $errorMessage = 'Database error';
            $errorMessage = $sql;
            echo $e->getMessage();
        }
    }
}
?>

<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>
    <h1>Login</h1>
    <form id="loginForm" name="loginForm" action="" method="POST">
        <fieldset>
            <legend>Login Form</legend>
            <div>
                <font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font>
            </div>
            <label for="mail">Email</label><input type="text" id="mail" name="mail" placeholder="Enter your email" value="<?php if (!empty($_POST["mail"])) {
                                                                                                                                echo htmlspecialchars($_POST["mail"], ENT_QUOTES);
                                                                                                                            } ?>">
            <br>
            <label for="password">Password</label><input type="password" id="password" name="password" value="" placeholder="Enter your password">
            <br>
            <input type="submit" id="login" name="login" value="Login">
        </fieldset>
    </form>
    <br>
    <form action="signup_mail.php">
        <fieldset>
            <legend>Sign Up</legend>
            <input type="submit" value="signup">
        </fieldset>
    </form>
</body>

</html>