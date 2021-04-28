<?php 
session_start();



if (!isset($_SESSION['vname'])) {
    header("Location: login.php");

}

$amount = $_POST["amount"];
$term = $_POST["term"];
$ssn = $_POST["ssn"];

$abfragekredit = "http://localhost:8080/vbank?arg0=" .$amount . "&arg1=" . $term . "&arg2=" . $ssn;

/*header("Location:" .$abfragekredit);*/

$json = file_get_contents($abfragekredit);

$data = json_decode($json,true);

$amount2 = $data['creditrateresponse'];

print_r($amount2);

exit;

?>

