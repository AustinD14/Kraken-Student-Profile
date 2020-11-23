<?php
$db['host'] = "localhost";  //
$db['user'] = "root";  //
$db['pass'] = "rmpoke1945";  //
$db['dbname'] = "student_profile";
$dsn = 'mysql:dbname=student_profile;host=localhost;charset=utf8mb4';
$user = $db['user'];
$pass = $db['pass'];
try {
    $dbh = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,]);
}   catch (PDOException $e) {
    echo "Database Connection Error　：".$e->getMessage();
}
?>