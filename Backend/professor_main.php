<?php
require_once("dbconnect.php");
session_start();

// check login condition
if (!isset($_SESSION["NAME"])) {
    header("Location: logout.php");
    exit;
}

echo "<br><br><br>";

// show professor's class list
$sql = 'SELECT * FROM class where instructor = :instructor';
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':instructor', $_SESSION["NAME"], PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    <h1>
        <p>Welcome Professor: <u><?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?></u></p>
    </h1>

    <h2>Your Class:</h2>
    <table class="table table-striped">
        <tr>
            <th>Class ID</th>
            <th>Class Name</th>
            <th>Instructor</th>
        </tr>
        <?php foreach ($result as $column) : ?>
            <tr>
                <td><?php echo $column["class_id"] ?> </td>
                <td><?php echo $column["class_name"] ?></td>
                <td><?php echo $column["instructor"] ?></td>
                <td><a href="professor_student_list.php?class_id=<?php echo $column["class_id"] ?>">View</a></td>
                <td><a href="delete_class.php?id=<?php echo $column['class_id'] ?>">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <ul>
        <li><a href="create_class.php">Create Your Class</a></li>
    </ul>
</body>

</html>