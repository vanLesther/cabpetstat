<?php
session_start();
// var_dump($_POST);
require_once("class/cases.php");
require_once("class/geolocation.php");
require_once("class/pet.php");


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $residentID = $_POST['residentID'];
    $petID = $_POST['petID'];
    $brgyID = $_POST['brgyID'];
    $caseType = $_POST['caseType'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $caseStatus = $_POST['caseStatus'];
   

    $geolocation = new Geolocation();
    $geoID = $geolocation->saveGeolocation($latitude, $longitude);

    if ($geoID !== false) {
        $case = new Cases();
        
        $result = $case->addSuspectedCase($residentID, $brgyID, $petID, $geoID, $caseType, $description, $date, $caseStatus);
       
        if ($result === true) {
            echo '<script>alert("Report Suspected Rabid Case Successfully"); window.location.href = "./BAOpetdashboard.php?active-tab=4";</script>';
        } else {
            echo '<script>alert("Failed to Report Case: ' . $result . '"); window.location.href = "reportRabidBao.php";</script>';
        }
        // header('Location: ./BAOpetdashboard.php?active-tab=4');
    }
}
?>
