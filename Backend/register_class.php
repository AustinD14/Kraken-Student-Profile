<?php
require_once("dbconnect.php");
session_start();
$errors = array();

// confirm or not 0,1
$confirm = 0;

echo "<br><br><br>";
if(isset($_GET['id'])) { $class_id = $_GET['id']; }
try{
    $sql = 'SELECT * FROM class where class_id = :class_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':class_id', $class_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
    $dbh->rollBack();
    exit($e);
}
$class_id = $result["class_id"];
$class_name = $result["class_name"];
$instructor = $result["instructor"];
$student_id = $_SESSION["STUDENT_ID"];

//echo $class_id, $class_name, $instructor, $student_id;

// confirm register class
if(isset($_POST["confirm"])){



        $dbh->beginTransaction();
/*
        //DB check
       $sql = "SELECT * FROM class_registered WHERE class_id=:class_id";
       $stm = $dbh->prepare($sql);
       $stm->bindValue(':class_id', $class_id, PDO::PARAM_INT);
       
       $stm->execute();
       $result = $stm->fetchAll(PDO::FETCH_ASSOC);
       //if same value is in class table, throw error
       if($result["student_id"] == $student_id){
			$errors['user_check'] = "This class is already registered.";
       }*/
       if(count($errors)===0){
        $sql = 'INSERT INTO
                        class_registered (class_id, student_id)
                    VALUES
                    (:class_id, :student_id)';
            try{
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(':class_id', $class_id, PDO::PARAM_INT);
                $stmt->bindValue(':student_id', $student_id, PDO::PARAM_INT);
                $stmt->execute();
                $dbh->commit();
                echo 'Class: '. $class_name.' has been registered.';
                $confirm = 1;
            }
            catch(PDOException $e){
                $dbh->rollBack();
                exit($e);
            }
        }

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
        <a class="navbar-brand">Student Profile</a>
        <form class="form-inline">
            <a class="btn btn-primary my-2 my-sm-0" href="class_list.php" role="button">Go Back</a>
        </form>
    </nav>

    <?php
    if($confirm == 0): ?>

    <p id="confirm">
    <pre>    <?php echo "Do you want to register this class? <br><br>  Class ID: $class_id <br>  Class: $class_name <br>  Instructor: $instructor"  ?>
    </pre>
    </p>
    <form action="" method="post" id="submit">
		<input type="submit" name="confirm" value="confirm" id="submit">
    </form>
    <?php endif; ?>
</body>
</html>