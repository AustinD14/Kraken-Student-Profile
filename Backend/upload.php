<?php
// Include the database configuration file
include 'dbconnect.php';
$statusMsg = '';

session_start();
$student_id = $_SESSION["STUDENT_ID"];

echo '<br>';
echo '<br>';
echo '<br>';

// File upload path
$targetDir = "upload_image/"; //!!!!!!!!!!!!  adjust to your directory   !!!!!!!!!!!!!!!
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $insert = $dbh->query("INSERT into upimages (file_name, uploaded_on, student_id) VALUES ('".$fileName."', NOW(), $student_id)");
            if($insert){
                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
            }else{
                $statusMsg = "File upload failed, please try again.";
            }
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
    //$sql = 'INSERT into upimages (student_id) VALUES (:student_id)';
    //$stmt = $dbh->prepare($sql);
    //$stmt->bindValue(':student_id', $_SESSION["STUDENT_ID"], PDO::PARAM_STR);
    //$stmt->execute();

}else{
    $statusMsg = 'Please select a file to upload.';
}

// Display status message
echo $statusMsg;
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
        <a class="navbar-brand">My Image</a>
        <form class="form-inline">
            <a class="btn btn-primary my-2 my-sm-0" href="main.php" role="button">Go back</a>
        </form>
    </nav>
    <br>
    <br>
    <br>
</body>
</html>