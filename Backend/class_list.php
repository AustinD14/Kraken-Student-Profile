<?php
require_once("dbconnect.php");
session_start();

$_SESSION["STUDENT_ID"];

echo "<br><br><br>";

// show all class list
$sql = 'SELECT * FROM class';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// show registered class list
$sql = 'SELECT * FROM  class_registered where student_id = :student_id';
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':student_id', $_SESSION["STUDENT_ID"], PDO::PARAM_INT);
$stmt->execute();
$myclass = $stmt->fetchAll(PDO::FETCH_ASSOC);
/*
foreach($myclass as $mc) {
    try{
        $sql = 'SELECT * FROM class where class_id = :class_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':class_id', $mc["class_id"], PDO::PARAM_INT);
        $stmt->execute();
        $myclasslist = $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    catch(PDOException $e){
        $dbh->rollBack();
        exit($e);
    }

} */


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
        <a class="navbar-brand">Student Profile</a>
        <form class="form-inline">
            <a class="btn btn-primary my-2 my-sm-0" href="main.php" role="button">Go Back</a>
        </form>
    </nav>


    <h2>Your Class:</h2>
        <table class="table table-striped">
            <tr>
                <th>Class ID</th>
                <th>Class Name</th>
                <th>Instructor</th>
            </tr>
            <?php foreach($myclass as $mc):
                try{
                    $sql = 'SELECT * FROM class where class_id = :class_id';
                    $stmt = $dbh->prepare($sql);
                    $stmt->bindValue(':class_id', $mc["class_id"], PDO::PARAM_INT);
                    $stmt->execute();
                    $myclasslist = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach($myclasslist as $column): ?>
                    <tr>
                        <td><?php echo $column["class_id"] ?></td>
                        <td><?php echo $column["class_name"] ?></td>
                        <td><?php echo $column["instructor"] ?></td>
                        <td><a href="delete_stuclass.php?id=<?php echo $column['class_id'] ?>">Delete</a></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php
            
                }
                catch(PDOException $e){
                    $dbh->rollBack();
                    exit($e);
                }
                ?>
            
            <?php endforeach; ?>
        </table>

    <br><br>
    <h2>Class List:</h2>
    <table  class="table table-striped">
        <tr>
            <th>Class ID</th>
            <th>Class Name</th>
            <th>Instructor</th>
        </tr>
        <?php foreach($result as $column): ?>
        <tr>
            <td><?php echo $column["class_id"] ?></td>
            <td><?php echo $column["class_name"] ?></td>
            <td><?php echo $column["instructor"] ?></td>
            <td><a href="register_class.php?id=<?php echo $column['class_id'] ?>">Register</a></td>
        </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>