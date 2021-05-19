<?php 

// Beinhaltet die Connection zur Datenbank
include 'config.php';

// Sessionaufbau
session_start();

// Überprüfung der Session
if (!isset($_SESSION['vname'])) {
    header("Location: login.php");
}

// Fehlerberichterstattung
error_reporting(0);

// Variablen aus der Request
$amount = $_POST["amount"];
$term = $_POST["term"];
$vorname = $_SESSION["vname"];
$notify = $_POST["notify"];

// REST-Abfrage als zusammengesetzter String
$abfragekredit = "http://localhost:8080/vbank?arg0=" .$amount . "&arg1=" . $term . "&arg2=" .getVariableOfDatabase('ssn',$vorname);

// Deklaration und Decodierung der Abfrage
$json = file_get_contents($abfragekredit);
$data = json_decode($json,true);

// Ausgabe der Zinsrate
$abfrage = $data['creditrateresponse'];

// Datum
$datetime = date("Y-m-d H:i:s"); 
$dateMail = date("d.m.Y H:i");

// Kreditanfrage in die Datenbank speichern
$sql = "request (Datum, Kredithöhe, Kreditlänge, Zinssatz) VALUES ('$datetime','$amount','$term','$abfrage')";
$result = mysqli_query($conn, "INSERT INTO " .$sql );

// Überprüfen, ob die Datenbank nicht leer ist
$testForEmptyDB = true;
if ($result == null){
    $testForEmptyDB = false;
}
// Ausführung der Email-Bestätigung
sendMail($notify,$dateMail, $vorname, $amount, $term , $abfrage);

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
            <main class="anfrage">
                <div class="anfrage-wrapper">
                    <form class="anfrage-form">
                        <div>
                            <?php
                        
                            if ($testForEmptyDB) {

                                $url1 = "welcome.php";
                                $url2 = "anfragen.php";
                                echo "<div class ='box'><b>Die Kreditanfrage wurde verschickt!</b><br><br><br><br><br><a href='$url1'>Zurück zur Startseite</a><br><br><br><br><br><a href='$url2'>Meine Anfragen</a></div>"; 

                            } else {
                                print "Es ist ein Fehler aufgetreten.";        
                            }
                            $conn->close();  

                            ?>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </body>
<?php

// Select-Funktion
function getVariableOfDatabase($variable, $vorname) {

    include 'config.php';
    
    $queryText = "SELECT $variable FROM user WHERE vname = '$vorname'";
    $query = $conn->prepare($queryText); // Query vorbereiten
    $query->execute(); // Query ausführen
    $result = $query->get_result(); //Ergebnis abrufen, damit es innerhalb von PHP verwendet werden kann
    $r = $result->fetch_array(MYSQLI_ASSOC); //bindet die Daten der ersten Ergebniszeile an $r
    $returnVar = $r[$variable]; //SSN Variable definiern

    return $returnVar;
}

// E-Mail Versand Funktion
function sendMail($notify,$dateMail, $vorname, $amount, $term , $abfrage) {

    include 'config.php';
    
    // Wenn die Checkbox ausgewählt wurde, soll eine Emailbenachrichtigung verschickt werden
    if($notify != null){

        //Email-Metadaten
        $header = "Content-Type:text/html\r\n";

        //Email Betreff
        $sub = "Ihre Kreditanfrage vom " .$dateMail;

        //Email Nachricht
        $msg = "Hallo " .$vorname .", <br><br>Du hast ein Angebot für Deine Anfrage in Höhe von <strong>" .$amount ." Euro</strong> für eine Kreditlaufzeit von <strong>" .$term . " Monaten</strong> erhalten.
                <br>Der bestangebotene Zinssatz für Deine Anfrage beträgt <strong>" . round($abfrage,2). " Prozent</strong>.<br><br>
                Jetzt Angebot <a href='http://localhost/php/angebote.php'><strong>hier</a></strong> einsehen.<br><br>Bleib' gesund!<br><strong>Dein Loan Broker Team</strong><h3>
                <p class='MsoNormal' style='margin: 0cm 0cm 11.25pt; font-size: 11pt; font-family: Calibri, sans-serif; caret-color: rgb(255, 255, 255); color: rgb(255, 255, 255);'>
                    <b>
                        <span style='font-size: 10pt; font-family: Arial, sans-serif; color: black;'>
                            <o:p></o:p>
                        </span>
                    </b>
                </p>
                <p class='MsoNormal' style='margin: 0cm 0cm 11.25pt; font-size: 11pt; font-family: Calibri, sans-serif; caret-color: rgb(255, 255, 255); color: rgb(255, 255, 255);'>
                </p>
                <div style='caret-color: rgb(255, 255, 255); color: rgb(255, 255, 255); font-family: Helvetica; font-size: 12px; border-style: none none solid; border-bottom-width: 1pt; border-bottom-color: rgb(136, 136, 136); padding: 0cm 0cm 11pt;'>
                    <p class='MsoNormal' style='margin: 0cm 0cm 11.25pt; font-size: 11pt; font-family: Calibri, sans-serif; border: none; padding: 0cm;'>
                        <span style='font-size: 7.5pt; font-family: Arial, sans-serif; color: rgb(136, 136, 136);'>
                            Business Application Master| Unterallmendstra&szlig;e 21 |78120 Furtwangen im Schwarzwald | Germany
                            <br>
                            Phone: 07723 920-2931
                            <br>
                            E-Mail: buesra.alili@gmail.com
                        </span>
                    </p>
                    <p class='MsoNormal' style='margin: 0cm 0cm 11.25pt; font-size: 11pt; font-family: Calibri, sans-serif; border: none; padding: 0cm;'>
                        <span style='font-size: 7.5pt; font-family: Arial, sans-serif; color: rgb(136, 136, 136);'>
                            <br>
                        </span>
                        <span style='color: rgb(136, 136, 136); font-family: Arial, sans-serif; font-size: 7.5pt;'>Hauptsitz Hochschule Furtwangen&nbsp;</span>
                        <span style='color: rgb(136, 136, 136); font-family: Arial, sans-serif; font-size: 10px;'>|</span>
                        <span style='color: rgb(136, 136, 136); font-family: Arial, sans-serif; font-size: 10px;'>&nbsp;</span>
                        <span style='color: rgb(136, 136, 136); font-family: Arial, sans-serif; font-size: 10px;'>Robert-Gerwig-Platz 1 |78120 Furtwangen im Schwarzwald</span>
                        <span style='color: rgb(136, 136, 136); font-family: Arial, sans-serif; font-size: 10px;'>&nbsp;</span>
                    </p>
                </div>
                <p class='MsoNormal' style='margin: 0cm 0cm 11.25pt; font-size: 11pt; font-family: Calibri, sans-serif; caret-color: rgb(255, 255, 255); color: rgb(255, 255, 255);'>
                    <span style='font-size: 7.5pt; font-family: Arial, sans-serif; color: rgb(136, 136, 136);'>
                        <br>
                        Gesch&auml;ftsf&uuml;hrer: B&uuml;sra Alili, B&uuml;nyamin &Ouml;zg&uuml;r H&uuml;nerli, Tim L&uuml;hmann
                        <o:p></o:p>
                    </span>
                </p>
                <div style='caret-color: rgb(255, 255, 255); color: rgb(255, 255, 255); font-family: Helvetica; font-size: 12px; border-style: none none solid; border-bottom-width: 1pt; border-bottom-color: rgb(136, 136, 136); padding: 0cm 0cm 11pt;'>
                    <p class='MsoNormal' style='margin: 0cm 0cm 11.25pt; font-size: 11pt; font-family: Calibri, sans-serif; border: none; padding: 0cm;'>
                        <span style='font-size: 7.5pt; font-family: Arial, sans-serif; color: rgb(136, 136, 136);'>
                            Member of University Furtwangen
                            <o:p></o:p>
                        </span>
                    </p>
                </div>
                <p class='MsoNormal' style='margin: 0cm 0cm 11.25pt; font-size: 11pt; font-family: Calibri, sans-serif; caret-color: rgb(255, 255, 255); color: rgb(255, 255, 255);'>
                    <span style='font-size: 7.5pt; font-family: Arial, sans-serif; color: rgb(136, 136, 136);'>
                        Diese E-Mail kann vertrauliche und/oder gesetzlich gesch&uuml;tzte Informationen enthalten. Wenn Sie nicht der bestimmungsgem&auml;&szlig;e Adressat sind oder diese E-Mail irrt&uuml;mlich erhalten haben, unterrichten Sie bitte den Absender und vernichten Sie diese E-Mail. Anderen als dem bestimmungsgem&auml;&szlig;en Adressaten ist untersagt, diese E-Mail zu speichern, weiterzuleiten oder ihren Inhalt auf welche Weise auch immer zu verwenden.
                        <o:p></o:p>
                    </span>
                </p>
                <p class='MsoNormal' style='margin: 0cm 0cm 0.0001pt; font-size: 11pt; font-family: Calibri, sans-serif; caret-color: rgb(255, 255, 255); color: rgb(255, 255, 255);'>
                    <span style='font-size: 7.5pt; font-family: Arial, sans-serif; color: rgb(136, 136, 136);'>This e-mail may contain confidential and/or privileged information. If you are not the intended recipient of this e-mail, you are hereby notified that saving, distribution or use of the content of this e-mail in any way is prohibited. If you have received this e-mail in error, please notify the sender and delete the e-mail.</span>
                </p>
            </h3>";
        
        // Email verschicken
        mail(getVariableOfDatabase('email',$vorname),$sub,$msg, $header);
        }
    }
?>
</html>
