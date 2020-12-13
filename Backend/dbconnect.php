<?php
$db['host'] = "localhost";  //
$db['user'] = "pma";  //
$db['pass'] = "123456";  //
$db['dbname'] = "Student_Profile";
$dsn = 'mysql:dbname=Student_Profile;host=localhost;charset=utf8mb4';
$user = $db['user'];
$pass = $db['pass'];
try {
    $dbh = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,]);
}   catch (PDOException $e) {
    echo "Database Connection Error　：".$e->getMessage();
}
?>
