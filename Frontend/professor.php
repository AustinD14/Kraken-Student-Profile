<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Student Profile</title>

  <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.min.css" />
  <link rel="stylesheet" href="Styles/site.css"" />
  </head>
  <body>
    <!-- Navbar -->
    <nav class=" navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="/">Student Profile</a>
  </nav>

  <!-- Form  -->
  <div style="height: 80px"></div>
  <table>
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

    ajax.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var data = JSON.parse(this.responseText);
        console.log(data);

        var html = "";
        for (var a = 0; a < data.length; a++) {
          var id = data[a].id;
          var name = data[a].user_name;
          var email = data[a].user_email;

          html += "<tr>";
          html += "<td>" + id + "</td>";
          html += "<td>" + name + "</td>";
          html += "<td>" + email + "</td>";
          html += "</tr>";
        }
        document.getElementById("data").innerHTML += html;
      }
    };
  </script>
  </body>

</html>