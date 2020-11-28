<?php
session_start();

// check login condition
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

$db_id = $_SESSION["ID"]; //database ID/row #

$servername = "localhost";
$username = "pma";
$password = "123456";
$dbname = "Student_Profile";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name, student_id, mail, birthday FROM user_data WHERE id=$db_id ";
$result = $conn->query($sql);
$student_info = $result->fetch_assoc();
$student_id = $student_info["student_id"];
$_SESSION["NAME"] = $student_info["name"];
$_SESSION["STUDENT_ID"] = $student_id;
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
            <a class="btn btn-primary mr-sm-2" href="upload_image.php">My Image</a>
            <a class="btn btn-primary mr-sm-2" href="student_info.php" role="button">Update Profile</a>
            <a class="btn btn-primary my-2 my-sm-0" href="logout.php" role="button">Logout</a>
        </form>
    </nav>
    <div style="height: 80px"></div>
    <h1>Welcome Student: <u><?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?></u></h1>

    <?php
// Include the database configuration file
include 'dbconnect.php';

// Get images from the database
$sql = "SELECT * FROM upimages WHERE student_id = :student_id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':student_id', $student_id, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($result);
if($result > 0){
    foreach($result as $column)
        $imageURL = 'upload_image/'.$column["file_name"];
?>
    <img id="photo" src="<?php echo $imageURL; ?>" alt="" />
<?php
}else{ ?>
    <p>No image(s) found...</p>
    <p>Please set your student id first, then upload your image<br></p>
<?php }
?>

    <div class="px-5">
        Student ID: <?php echo $student_info["student_id"] ?></br>
        Email: <?php echo $student_info["mail"] ?></br>
        Birthday: <?php echo $student_info["birthday"] ?></br>
    </div>

    <br><br>
    <ul>
        <li><a href="class_list.php">Class List & Register</a></li>
    </ul>
</body>

</html>