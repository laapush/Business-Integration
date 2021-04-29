<?php 
session_start();

if (!isset($_SESSION['vname'])) {
    header("Location: login.php");

}

$amount = $_POST["amount"];
$term = $_POST["term"];
$ssn = $_POST["ssn"];

$abfragekredit = "http://localhost:8080/vbank?arg0=" .$amount . "&arg1=" . $term . "&arg2=" . $ssn;

$json = file_get_contents($abfragekredit);

$data = json_decode($json,true);

$abfrage = $data['creditrateresponse'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="style3.css">
   <script src="https://kit.fontawesome.com/13c7fa4ddd.js" crossorigin="anonymous"></script>

    <title>Loan Broker - Anfragen</title>
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
  <form action="" class="anfrage-form">

<label for="score">Ihr Score-Wert lautet:
  <?php
    print_r($abfrage);
    exit;
  ?></label>
  </div>
</main>
</div>
</body>
</html>
