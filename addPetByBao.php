<?php
session_start();
require_once 'class/resident.php';

$resident = new Resident();

// Check if the user is logged in
if (isset($_POST['residentID'])) {
    // Retrieve the residentID from the POST data
    $residentID = $_POST['residentID'];

    // Now, you can use $residentID as needed
    $_SESSION['residentID'] = $residentID; // Optionally store it in the session for later use
}
if (isset($_POST['userType'])) {
    // Retrieve the residentID from the POST data
    $userType = $_POST['userType'];

    // Now, you can use $residentID as needed
    $_SESSION['userType'] = $userType; // Optionally store it in the session for later use
}
if (isset($_POST['brgyID'])) {
    // Retrieve the residentID from the POST data
    $brgyID = $_POST['brgyID'];

    // Now, you can use $residentID as needed
    $_SESSION['brgyID'] = $brgyID; // Optionally store it in the session for later use
}



// Retrieve residentID from the session
$residentIDFromSession = isset($_SESSION['residentID']) ? $_SESSION['residentID'] : '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Pet Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Add jQuery library -->

    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body>
    <div class="container">
    <div class="col-md-auto">
                            <a href="./dashboard1.php?active-tab=2" class="btn btn-primary rounded-circle p-2">
                                <i class="bi bi-arrow-left"></i>
                            </a>
                        </div>
        <h1>Pet Registration Form</h1>
        <form id="addPetForm" action="process_addByBAO.php" onsubmit="return confirmAdd();" method="POST">
        <div class="mb-3">
    <label for="pname" class="form-label">Pet's Name:<span class="text-danger">*</span></label>
    <input type="text" class="form-control" name="pname" id="pname" required>
</div>
<div class="mb-3">
    <label for="petType" class="form-label">Species:<span class="text-danger">*</span></label>
    <select class="form-select" name="petType" id="petType" required>
        <option value="">Select Pet Type</option>
        <option value="0">Dog</option>
        <option value="1">Cat</option>
    </select>
</div>
<div class="mb-3">
    <label for="sex" class="form-label">Sex:<span class="text-danger">*</span></label>
    <select class="form-select" name="sex" id="sex" required>
        <option value="">Select Sex</option>
        <option value="0">Male</option>
        <option value="1">Female</option>
    </select>
</div>
<div class="mb-3">
    <label for="color" class="form-label">Color:<span class="text-danger">*</span></label>
    <input type="text" class="form-control" name="color" id="color" required>
</div>
<div class="mb-3">
    <label for="neutering" class="form-label">Neutering Status:<span class="text-danger">*</span></label>
    <select class="form-select" name="neutering" id="neutering" required>
        <option value="">Select Status</option>
        <option value="0">Yes</option>
        <option value="1">No</option>
    </select>
</div>
<div class="mb-3">
    <label for="statusVac" class="form-label">Vaccination Status:<span class="text-danger">*</span></label>
    <select class="form-select" name="statusVac" id="statusVac" required onchange="toggleCurrentVac()">
        <option value="">Select Status</option>
        <option value="0">Yes</option>
        <option value="1">No</option>
    </select>
</div>
<div class="mb-3">
    <label for="vetVac" class="form-label">Select if pet is vet Vaccinated</label><br>
    <input type="radio" name="vetVac" id="notVetVaccinated" value="0" checked>
    <label for="notVetVaccinated">Yes</label><br>
    <input type="radio" name="vetVac" id="vetVaccinated" value="1">
    <label for="vetVaccinated">No</label>
</div>

<div class="mb-3">
    <label for="currentVac" class="form-label">Current Vaccination</label>
    <input type="date" class="form-control" name="currentVac" id="currentVac" disabled>
</div>
<div class="mb-3">
    <label for="age" class="form-label">Pet's Age:</label>
    <input type="numbers" class="form-control" name="age" id="age">
</div>
<div class="mb-3">
    <label for="pdescription" class="form-label">Description:<span class="text-danger">*</span></label>
    <textarea class="form-control" name="pdescription" id="pdescription" required></textarea>
</div>
            <div class="modal-footer">
            <input type="hidden" name="status" id="status" value="1">
            <input type="hidden" name="regDate" id="regDate" value="<?php echo date('Y-m-d'); ?>">
            <input type="hidden" name="residentID" id="residentID" value="<?php echo $residentIDFromSession; ?>">
            <input type="hidden" name="notifType" id="notifType" value="1">
            <input type="hidden" name="notifDate" id="notifDate" value="<?php echo date('Y-m-d'); ?>">
            <input type="hidden" name="notifMessage" id="notifMessage" value="A pet has been registered under you.">
            <input type="hidden" name="userType" ided="userType" value="<?php echo $userType; ?>">
            <input type="hidden" name="brgyID" id="brgyID" value="<?php echo $brgyID; ?>">
                <input type="submit" value="Add Pet" class="btn btn-primary">
            </div>
</form>
            <!-- <form method="post" action="./dashboard1.php?active-tab=2" onsubmit="switchToValidResidentsTab()">
                <input type="hidden" name="residentID" id="residentID" value="<?php echo $residentIDFromSession; ?>">
                <button type="submit" class="btn btn-primary">Back</button>
            </form> -->
</div>
<script>
    function toggleCurrentVac() {
        var statusVac = document.getElementById("statusVac");
        var currentVac = document.getElementById("currentVac");

        if (statusVac.value === "0") {
            currentVac.disabled = false;
        } else {
            currentVac.disabled = true;
            currentVac.value = ""; // Clear the input value when disabled
        }
    }
</script>
    <!-- Add Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>

   
