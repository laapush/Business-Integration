<?php 

include 'config.php';

session_start();

if (!isset($_SESSION['vname'])) {
    header("Location: login.php");
}

error_reporting(0);

$amount = $_POST["amount"];
$term = $_POST["term"];
$assn = $_SESSION["vname"];

$query = $conn->prepare("SELECT ssn FROM user WHERE vname = '$assn'"); // prepate a query
$query->execute(); // actually perform the query
$result = $query->get_result(); // retrieve the result so it can be used inside PHP
$r = $result->fetch_array(MYSQLI_ASSOC); // bind the data from the first result row to $r
$ssn = $r['ssn']; // ssn Variable definiern

$abfragekredit = "http://localhost:8080/vbank?arg0=" .$amount . "&arg1=" . $term . "&arg2=" .$ssn;

$json = file_get_contents($abfragekredit);

$data = json_decode($json,true);

$abfrage = $data['creditrateresponse'];

$datetime = date("Y-m-d H:i:s"); 

$helper = false;

$sql = "request (Datum, Kredithöhe, Kreditlänge, Zinssatz) VALUES ('$datetime','$amount','$term','$abfrage')";
$result = mysqli_query($conn, "INSERT INTO " .$sql );

if ($result != null){
    $helper = true;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="angebot.css">
   <script src="https://kit.fontawesome.com/13c7fa4ddd.js" crossorigin="anonymous"></script>
    <style>

    .td2{
        padding-left:25px;
        padding-bottom:5px;
    }
    </style>

    <title>Loan Broker - Anfrage</title>
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
    </div>

    <main class="anfrage">
  <div class="anfrage-wrapper">
  <form class="anfrage-form">
      <div>

        <?php
        
        if ($helper == true) {

            $url1 = "welcome.php";
            $url2 = "anfragen.php";
        	echo "<div class ='box'><b>Die Kreditanfrage wurde verschickt!</b><br><br><br><br><br><a href='$url1'>Zurück zur Startseite</a><br><br><br><br><br><a href='$url2'>Zu Meine Anfragen</a></div>"; 

        } else {
        	print "Es ist ein Fehler aufgetreten.";        
        }

        $conn->close();  
    
        ?>
  </div>
    </form>
</main>
</div>
</body>
</html>
