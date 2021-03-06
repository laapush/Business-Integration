<?php 

//Sessionaufbau
session_start();

//Überprüfung der Session
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
        <div id="logo">
          <a style="text-decoration: none; color: #68a6da;" href="welcome.php"><h4><i class="fab fa-ethereum"></i>LOAN BROKER</h4></a>
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

          <!--Formular für die Kreditanfrage-->
          <form action="angebot_request.php"method="post" class="anfrage-form">

            <label for="amount">Nettokreditbetrag:</label>
            <input type="number" id="amount" name ="amount"min="100" max="100000" <!--pattern="[100-100000]-->"maxlength="6"  placeholder="Euro" required>       </input><br>

            <label for="term">Kreditlaufzeit:</label>
            <input type="number" id="term" name="term" placeholder="Monate" min="1" max="36" <!--pattern="[1-36]{2} -->"maxlength="2" required>    </input><br>

            <label>Optionen:</label>
            <div><label style="font-weight:normal; font-size:small">E-Mail Benachrichtigung<input type="checkbox" id="notify" name="notify"></label>
            </div>

            <button type="submit"  class="button">Absenden</button>
          </form>
          </div>
        </main>
      </div>
    </body>
  </html>
