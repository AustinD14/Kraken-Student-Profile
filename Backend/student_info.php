<?php
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
    <div style="height: 80px"></div>
    <div class="px-5 form-wrap">
        <form name="update-profile" action="student_info_update.php" method="POST">
            <div class="form-single-wrap">
                <label for="name">Name</label>
                <input type="text" name="name"></br>
            </div>
            <div class="form-single-wrap">
                <label for="student_id">Student ID</label>
                <input type="number" name="student_id"></br>
            </div>
            <div class="form-single-wrap">
                <label for="birthday">Birthday</label>
                <input type="date" name="birthday"></br>
            </div>
            <div class="form-single-wrap">
                <label for="phone_number">Phone Number</label>
                <input type="number" name="phone_number"></br>
            </div>
            <input type="submit">
        </form>
    </div>
</body>

</html>