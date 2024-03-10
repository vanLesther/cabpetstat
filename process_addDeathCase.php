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
    $cdate = $_POST['date'];
    $description = $_POST['description'];
    $CRabies = $_POST['confirmedRabies'];
    $caseType = $_POST['caseType'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $caseStatus = $_POST['caseStatus'];

    $geolocation = new Geolocation();
    $geoID = $geolocation->saveGeolocation($latitude, $longitude);

    if ($geoID !== false) {
        $case = new Cases();
        // Replace 'date' with the current date and time using the date function
        // $currentDate = date('Y-m-d H:i:s');
        //var_dump($currentDate); // Add this line to check the value
        $result = $case->addDeathCase($residentID, $brgyID, $petID, $geoID, $caseType, $description, $cdate, $CRabies, $caseStatus);
        
        if ($result === true) {
            echo '<script>alert("Report Death Case Successfully"); window.location.href = "./BAOpetdashboard.php?active-tab=3";</script>';
        } else {
            echo '<script>alert("Failed to Report Case: ' . $result . '"); window.location.href = "addDeathCase.php";</script>';
        }
    }
}
?>
