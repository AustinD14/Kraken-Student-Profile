<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <title>upload image</title>

    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../Frontend/Styles/site.css" />
</head>
<body>
    <nav class=" navbar navbar-expand-lg navbar-dark bg-dark fixed-top justify-content-between">
        <a class="navbar-brand">My Image</a>
        <form class="form-inline">
            <a class="btn btn-primary my-2 my-sm-0" href="main.php" role="button">Go back</a>
        </form>
    </nav>
<div class="container">
    <br>
    <br>
    <br>
    <div class="upfrm">
            <form action="upload.php" method="post" enctype="multipart/form-data">
            Select Image File to Upload:
            <input type="file" name="file">
            <input type="submit" name="submit" value="Upload">
        </form>
    </div>
    <p><font color="red">Please set your student ID first, then upload your image<br></p>



</div>
</body>
</html>