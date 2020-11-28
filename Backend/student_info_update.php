<?php
session_start();

//ERROR CHECKING
ini_set('display_errors', '1');
ini_set('error_reporting', E_ALL);


if (!isset($_SESSION["NAME"])) {
    header("Location: logout.php");
    exit;
}

//for debugging
function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "rmpoke1945";
    $dbname = "Student_Profile";

    $db_id = $_SESSION["ID"]; //database ID/row #

    $name = $_POST["name"];
    $student_id = $_POST["student_id"];
    $birthday = strtotime($_POST["birthday"]);
    $birthday = date('Y-m-d H:i:s', $birthday);
    $phone_number = $_POST["phone_number"];


    if (empty($name)) {
        die("Please enter your Name");
    }
    if (empty($student_id)) {
        die("Please enter your Student ID");
    }
    if (empty($birthday)) {
        die("Please enter your Birthday");
    }

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE user_data SET name='$name', student_id=$student_id, birthday='$birthday', phone_number=$phone_number WHERE id=$db_id";
    if ($conn->query($sql) === TRUE) {
        echo '<div style="height: 80px"></div>';
        echo "Record updated successfully";
    } else {
        echo '<div style="height: 80px"></div>';
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
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
    <link rel="stylesheet" href="../Frontend/Styles/site.css" />
</head>

<body>
    <nav class=" navbar navbar-expand-lg navbar-dark bg-dark fixed-top justify-content-between">
        <a class="navbar-brand">Student Profile</a>
        <form class="form-inline">
            <a class="btn btn-primary my-2 my-sm-0" href="main.php" role="button">Go back</a>
        </form>
    </nav>
</body>

</html>