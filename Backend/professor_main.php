<?php
require_once("dbconnect.php");
session_start();

// check login condition
if (!isset($_SESSION["NAME"])) {
    header("Location: logout.php");
    exit;
}

// show professor's class list
$sql = 'SELECT * FROM class where instructor = :instructor';
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':instructor', $_SESSION["NAME"], PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Professor Main</title>
    </head>
    <body>
        <h1>Main menu</h1>
        <p>Welcome Professor <u><?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?></u></p>
        <h2>Your Class:</h2>
        <table>
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
                <td><a href="delete_class.php?id=<?php echo $column['class_id'] ?>">Delete</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <ul>
            <li><a href="create_class.php">Create Your Class</a></li>
        </ul>
        <ul>
            <li><a href="logout.php">logout</a></li>
        </ul>
    </body>
</html>
