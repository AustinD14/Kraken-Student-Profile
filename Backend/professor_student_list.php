<?php
require_once("dbconnect.php");
session_start();

function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

// check login condition
if (!isset($_SESSION["NAME"])) {
    header("Location: logout.php");
    exit;
}
$class_id = $_GET['class_id'];

echo "<br><br><br>";

$sql = 'SELECT * FROM class_registered where class_id = :class_id';
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':class_id', $class_id, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

console_log($result);

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
            <a class="btn btn-primary my-2 my-sm-0" href="logout.php" role="button">Logout</a>
        </form>
    </nav>
    <table class="table table-striped">
        <tr>
            <th>Student ID</th>
        </tr>
        <?php foreach ($result as $column) : ?>
            <tr>
                <td><?php echo $column["student_id"] ?> </td>
                <td><a href="professor_student_info.php?student_id=<?php echo $column["student_id"] ?>">View</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>

<!--
     TODO 
        ADD STUDENT NAME TO class_registered TABLE
        CHANGE THE UPLOAD TO class_registred TO INCLUDE STUDENT NAME
        SHOW NAME HERE INSTEAD OF STUDENT ID
-->