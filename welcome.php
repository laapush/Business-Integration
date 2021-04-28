<?php 

session_start();

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
   <script src="https://kit.fontawesome.com/13c7fa4ddd.js" crossorigin="anonymous"></script>

    <title>Loan Broker</title>
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
    <?php echo "
   <div class=title>
    <h1>Willkommen " . $_SESSION['vname'] . "</h1>"; ?></div>
</body>
</html>
