<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") { //Check it is comming from a form

    //mysql credentials
    $mysql_host = "localhost";
    $mysql_username = "root";
    $mysql_password = "rmpoke1945";
    $mysql_database = "Student_Profile";


    $u_name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $u_email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

    if (empty($u_name)) {
        die("Please enter your name");
    }
    if (empty($u_email) || !filter_var($u_email, FILTER_VALIDATE_EMAIL)) {
        die("Please enter valid email address");
    }


    $mysqli = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);

    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    $statement = $mysqli->prepare("INSERT INTO users_data (user_name, user_email) VALUES(?, ?)"); //prepare sql insert query
    //bind parameters for markers, where (s = string, i = integer, d = double,  b = blob)
    $statement->bind_param('ss', $u_name, $u_email); //bind values and execute insert query

    if ($statement->execute()) {
        print "Hello " . $u_name . "!, your info has been saved!";
    } else {
        print $mysqli->error; //show mysql error if any
    }
}
