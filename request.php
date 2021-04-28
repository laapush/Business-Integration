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
    <link rel="stylesheet" href="style3.css">
   <script src="https://kit.fontawesome.com/13c7fa4ddd.js" crossorigin="anonymous"></script>

    <title>Loan Broker - Kreditanfrage</title>
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
    <h1>Kreditanfrage</h1>
    </div>

    <main class="anfrage">
  <div class="anfrage-wrapper">
    <form action="" class="anfrage-form">

      <label for="betrag">Nettokreditbetrag:</label>
      <input type="text" id="betrag" placeholder="Euro" required>       </input><br>

      <label for="laufzeit">Kreditlaufzeit:</label>
      <input type="text" id="laufzeit" placeholder="Jahre" required>    </input><br>

      <label for="vwzk">Verwendungszweck:   </label>
        <select class="anfrage-form2" required>
          <option>Freie Verwendung</option>
          <option>Gebrauchtfahrzeug</option>
          <option>Neufahrzeug</option>
          <option>Umschuldung/Kredit ablösen</option>
          <option>Ausgleich Dispo</option>
          <option>Einrichtung/Möbel</option>
          <option>Modernisierung/Baufinanzierung</option>
        </select>

      <label>Optionen:</label>
      <div>
      <label style="font-weight:normal; font-size:small">Nur die niedrigste Rate erhalten<input type="checkbox" id="lowest" name="lowest"></label>
    </div>
    <div>   <label style="font-weight:normal; font-size:small">E-Mail Benachrichtigung<input type="checkbox" id="notify" name="notify"></label>
    </div>
      <button type="submit" class="button">Absenden</button>
    </form>
  </div>
</main>
</div>
</body>
</html>
