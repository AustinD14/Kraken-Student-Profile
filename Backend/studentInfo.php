<?php
$conn = mysqli_connect("localhost", "pma", "123456", "Student_Profile");
$result = mysqli_query($conn, "SELECT * FROM users_data");

echo json_encode($data);
exit();