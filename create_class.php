<?php
require_once('dbconnect.php');
session_start();
$errors = array();

$name = $_SESSION["NAME"];
if(isset($_POST["create"])){
    if (empty($_POST["class_id"])) {  // empty if blank
        $errorMessage = 'No Class ID entered';
    } else if (empty($_POST["class_name"])) {
        $errorMessage = 'No Class Name entered';
    }
    if (!empty($_POST["class_id"]) && !empty($_POST["class_name"])) {
        $class_name = $_POST["class_name"];
        
        $dbh->beginTransaction();
        
        //DB check
       $sql = "SELECT class_id FROM class WHERE class_id=:class_id";
       $stm = $dbh->prepare($sql);
       $stm->bindValue(':class_id', $_POST["class_id"], PDO::PARAM_INT);
       
       $stm->execute();
       $result = $stm->fetch(PDO::FETCH_ASSOC);
       //if same value is in class table, throw error
       if(isset($result["class_id"])){
			$errors['user_check'] = "This class is already registered.";
       }
       if(count($errors)===0){
        $sql = 'INSERT INTO
                        class(class_id, class_name, instructor)
                    VALUES
                        (:class_id, :class_name, :instructor)';
            try{
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(':class_id', $_POST["class_id"], PDO::PARAM_INT);
                $stmt->bindValue(':class_name', $_POST["class_name"], PDO::PARAM_STR);
                $stmt->bindValue(':instructor', $name, PDO::PARAM_STR);
                $stmt->execute();
                $dbh->commit();
                echo $class_name.' has been registered.';
            }
            catch(PDOException $e){
                $dbh->rollBack();
                exit($e);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>CreateClassForm</title>
	</head>
	<body>
		<h2>Create Your Class</h2>
        <form action="" method="POST">
            <p>Class ID</p>
            <input type="text" name="class_id">
            <p>Class Name</p>
            <input type="text" name="class_name">
            <p>Instructor：<?=htmlspecialchars($name, ENT_QUOTES)?></p>
            <input type="submit" name="create" value="Create">
        </form>
        <?php if(count($errors) > 0): ?>
            <?php
            foreach($errors as $value){
            echo "<p class='error'>".$value."</p>";
            }
            ?>
        <?php endif; ?>
        <ul>
            <li><a href="professor_main.php">Back to main page</a></li>
        </ul>
	</body>
</html>