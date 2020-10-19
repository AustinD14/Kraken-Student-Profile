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
  <script>
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "../Backend/list.php", true);
    ajax.send();

    var data;
    ajax.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        data = JSON.parse(this.responseText);
        console.log(data);

        var html = "";
        for (var a = 0; a < data.length; a++) {
          var id = data[a].id;
          var name = data[a].user_name;
          var email = data[a].user_email;

          html += "<tr>";
          html += "<td class='clickable' data-href='studentInfo.php'>" + id + "</td>";
          html += "<td>" + name + "</td>";
          html += "<td>" + email + "</td>";
          html += "</tr>";
        }
        document.getElementById("data").innerHTML += html;
      } //end if
    }; //end onreadystatechange


    // makes rows clickable and saves studentInfo to storage
    jQuery(document).ready(function($) {
      $(".clickable").click(function() {
        var studentinfo = data[$(this).text() - 1];
        sessionStorage.setItem("studentInfo", JSON.stringify(studentinfo));
        window.location = $(this).data("href");
      });
    });
  </script>

  </body>

</html>