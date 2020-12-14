<?php
require_once("dbconnect.php");
session_start();

echo "<br><br><br>";

$student_id = $_SESSION["STUDENT_ID"];

if(isset($_GET['id'])) { $class_id = $_GET['id']; }
try{
    $sql = 'DELETE FROM class_registered where class_id = :class_id AND student_id = :student_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':class_id', (int)$class_id, \PDO::PARAM_INT);
    $stmt->bindValue(':student_id', (int)$student_id, \PDO::PARAM_INT);
    $stmt->execute();
}
catch(PDOException $e){
    exit($e);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Student Profile</title>

    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="site.css" />
</head>

<body>
    <nav class=" navbar navbar-expand-lg navbar-dark bg-dark fixed-top justify-content-between">
        <a class="navbar-brand">Delete Class</a>
        <form class="form-inline">
            <a class="btn btn-primary my-2 my-sm-0" href="class_list.php" role="button">Go Back</a>
        </form>
    </nav>

    <big>Deleted.</big>
</body>
</html>