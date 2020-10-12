<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Student Profile</title>

    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="Styles/site.css"" />
  <script src=" https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"> </script> </head> <body>
</head>

<body>
    <!-- Navbar -->
    <nav class=" navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="/">Student Profile</a>
    </nav>
    <!-- Form  -->
    <div style="height: 80px"></div>
    <table id="tableID">
        <tr>
            <th>id</th>
            <th>name</th>
            <th>email</th>
        </tr>

        <tbody id="data"></tbody>
    </table>

    <script>//DISPLAYS DATA OF SPECIFIC STUDENT CLICKED
        var studentinfo = JSON.parse(sessionStorage.getItem("studentInfo"));
        var html = "";
        html += "<tr>";
        html += "<td class='clickable' data-href='studentInfo.php'>" + studentinfo.id + "</td>";
        html += "<td>" + studentinfo.user_name + "</td>";
        html += "<td>" + studentinfo.user_email + "</td>";
        html += "</tr>";
        document.getElementById("data").innerHTML += html;
    </script>
</body>

</html>