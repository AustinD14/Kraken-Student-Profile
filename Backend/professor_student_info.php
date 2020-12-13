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
$student_id = $_GET['student_id'];

echo "<br><br><br>";

//student info
$sql = 'SELECT student_id, name, mail, birthday, phone_number FROM user_data where student_id = :student_id';
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':student_id', $student_id, PDO::PARAM_STR);
$stmt->execute();
$student_info = $stmt->fetch(PDO::FETCH_ASSOC);


//student image
$sql = 'SELECT file_name FROM upimages where student_id = :student_id';
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':student_id', $student_id, PDO::PARAM_STR);
$stmt->execute();
$student_image = $stmt->fetch(PDO::FETCH_ASSOC);

$imageURL = 'upload_image/' . $student_image["file_name"];
console_log($imageURL);
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
    <div class="px-2 py-1">
        <img src="<?php echo $imageURL; ?>" id="photo" class="rounded float-left" alt="no image" />
        <div class="px-5">
            Name: <?php echo $student_info["name"] ?></br>
            Student ID: <?php echo $student_info["student_id"] ?></br>
            Email: <?php echo $student_info["mail"] ?></br>
            Phone Number: <?php echo $student_info["phone_number"] ?></br>
            Birthday: <?php echo $student_info["birthday"] ?></br>
        </div>
    </div>
</body>

</html>