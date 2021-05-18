<?php 

include 'config.php';

session_start();

error_reporting(0);

if (!isset($_SESSION['vname'])) {
    header("Location: login.php");
}

$amount = $_POST["amount"];
$term = $_POST["term"];
$assn = $_SESSION["vname"];

$query = $conn->prepare("SELECT ssn FROM user WHERE vname = '$assn'"); // prepate a query
$query->bind_param($ssn);
$query->execute(); // actually perform the query
$result = $query->get_result(); // retrieve the result so it can be used inside PHP
$r = $result->fetch_array(MYSQLI_ASSOC); // bind the data from the first result row to $r
$ssn = $r['ssn']; // ssn definieren

$abfragekredit = "http://localhost:8080/vbank?arg0=" .$amount . "&arg1=" . $term . "&arg2=" .$ssn;

$json = file_get_contents($abfragekredit);

$data = json_decode($json,true);

$abfrage = $data['creditrateresponse'];

$aktuelles_datum = date("d.m.Y"); 

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
    <h1>Meine Kreditangebote</h1>
    </div>

    <main class="anfrage">
  <div class="anfrage-wrapper">
  <form action="" class="anfrage-form">
  <article name="angebote">
        <h1>Angebot vom:&nbsp; <?php echo $aktuelles_datum?> </h1>
        <section>
        <div>
        <br>
        <br>
        <table>
            <tr>
                <td>Nettokreditbetrag: </td>
                <td class="td2"><?php
                print_r($amount);
            ?> Euro</label></td>
            </tr>
            <tr>
            <td>Kreditlaufzeit: </td>
                <td class="td2"><?php
                print_r($term);
            ?> Monate</label></td>
            </tr>
            <tr>
            <td>Zinssatz: </td>
                <td class="td2">  <?php
                print_r(round($abfrage,2));
            ?> Prozent</label></td>
            </tr>
            <!--
            <tr>
            <td>SSN: </td>
                <td class="td2">  <?php/*
               echo $ssn;*/
            ?></label></td>
            </tr>-->
    </table>
        </section>
    </article>
  </div>
</main>
</div>
</body>
</html>
