<?php 

include 'config.php';

session_start();

error_reporting(0);

if (!isset($_SESSION['vname'])) {
    header("Location: login.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="table.css">
    <link rel="stylesheet" href="style3.css">
   <script src="https://kit.fontawesome.com/13c7fa4ddd.js" crossorigin="anonymous"></script>
    <style>

    .td2{
        padding-left:25px;
        padding-bottom:5px;
    }
    </style>

    <title>Loan Broker - Angebote</title>
</head>

<body>
<nav>

<div id="logo"><a style="text-decoration: none;
    color: #68a6da;" href="welcome.php">
         <h4><i class="fab fa-ethereum"></i>LOAN BROKER</h4></a>
    </div>
    <ul class="nav-links">
    <li> <a href="welcome.php">Startseite</a> </li>
    <li> <a href="request.php">Kreditanfrage</a> </li>
     <li> <a href="anfragen.php">Meine Anfragen</a> </li>
    <li> <a href="angebote.php">Meine Angebote</a> </li>
    <li> <a href="logout.php">Logout</a> </li>
    </ul>
    <div class="burger">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
    </div>
</nav>
<div class="body">
   <div class=title>
    <h1>Meine Kreditanfragen</h1>
    </div>

    <main class="anfrage">
  <div class="anfrage-wrapper">
  <form class="anfrage-form">
  <article name="angebote">
        <?php

        $sqli = "SELECT * FROM request order by Datum";
        if($resulti = mysqli_query($conn, $sqli)){
        if(mysqli_num_rows($resulti) > 0){
        echo "<table class='content-table'><thead>";
            echo "<tr>";
                echo "<th>Anfragedatum</th>";
                echo "<th>Nettokreditbetrag<br>in Euro</th>";
                echo "<th>Kreditlaufzeit<br>in Monaten</th>";
            echo "</tr></thead>";
        while($row = mysqli_fetch_array($resulti)){
            echo "<tbody><tr>";
                $date = new DateTime($row['Datum']);
                echo "<td>" . $date->format('d.m.y H:i:s'). "</td>";
                echo "<td>" . $row['Kredithöhe'] . "</td>";
                echo "<td>" . $row['Kreditlänge'] . "</td>";
            echo "</tr></tbody>";
        }
        echo "</table>";
        mysqli_free_result($resulti);
         } else{
        echo "No records matching your query were found.";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
    // Free result set
     
        // Close connection
        mysqli_close($conn);

        ?>
    </article>
    </form>
  </div>
</main>
</div>
</body>
</html>
