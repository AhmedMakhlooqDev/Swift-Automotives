<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_name("u201700684");
session_start();

include_once "./Model/reservation.php";

$reservation_id = $_GET["resID"];
$invoice_id = $_GET["invID"];

//if ID has been found (or passed through the link) call the Delete Function
if(!empty($invoice_id) && !empty($reservation_id)){
    $resDel = new Reservation();
    $resDel->deleteResevation($reservation_id,$invoice_id);
}

header("Location: index.php");