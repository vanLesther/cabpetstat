<?php

require_once("class/pet.php");
require_once("class/notification.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Assuming you receive the parameters from a form submission or API request
    $residentID = $_POST['residentID'];
    $pname = $_POST['pname'];
    $petType = $_POST['petType'];
    $sex = $_POST['sex'];
    $neutering = $_POST['neutering'];
    $statusVac = $_POST['statusVac']; // corrected variable name
    $currentVac = isset($_POST['currentVac']) ? $_POST['currentVac'] : null; // Set to null if not set
    $color = $_POST['color'];
    $vetVac = $_POST['vetVac'];
    $age = $_POST['age'];
    $pdescription = $_POST['pdescription'];
    $brgyID = $_POST['brgyID'];
    $notifType = $_POST['notifType'];
    $notifMessage = $_POST['notifMessage'];

    $regDate = date('Y-m-d H:i:s');
    $notifDate = date('Y-m-d H:i:s');
    $pet = new Pet();
    $notif = new Notification();

    $newPet = $pet->addPetRes($residentID, $petType, $pname, $sex, $neutering, $color, $vetVac, $age, $regDate, $statusVac, $pdescription);
    $addNotif = $notif->addPetNotif($brgyID, $residentID, $notifType, $notifDate, $notifMessage);
    if ($newPet) {

        echo '<script>alert("Register Pet Successfully"); window.location.href = "./dashboard.php?active-tab=1";</script>';
    } else {
        echo '<script>alert("Failed to register Pet"); window.location.href = "./dashboard.php?active-tab=1";</script>';
    }
}
?>
