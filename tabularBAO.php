<?php
session_start();
require_once("class/pet.php");
require_once("class/barangay.php");
require_once("class/db_connect.php");
require_once("class/resident.php");
require_once("class/cases.php");
$active_tab = $_GET['active-tab'];
$pet = new Pet();
$barangay = new Barangay();
$resident = new Resident();
$case = new Cases();

$user = $_SESSION['user'];
// $brgyID = isset($_SESSION['user']['brgyID']) ? $_SESSION['user']['brgyID'] : '';
$residentID = isset($_SESSION['user']['residentID']) ? $_SESSION['user']['residentID'] : '';
// $userType = isset($_SESSION['user']['userType']) ? $_SESSION['user']['userType'] : '';
$name = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : '';
$brgyID = isset($_SESSION['user']['brgyID']) ? $_SESSION['user']['brgyID'] : '';

$cases = null;
$officers = null;
$pets = null;

$sex = array(
    0 => "Male",
    1 => "Female"
);

$neutering = array(
    0 => "Not Neutered",
    1 => "Neutered"
);

$vacStatus = array(
    0 => "Vaccinated",
    1 => "Not Vaccinated"
);

$petType = array(
    0 => "Dog",
    1 => "Cat"
);

$brgyID = isset($_POST["brgyID"]) ? $_POST["brgyID"] : null;

$pets = $pet->getRegistries($brgyID);
$bites = $case->getAllValidBiteCaseByBrgy($brgyID);
$death = $case->getDeathByBrgy($brgyID);
$rabid = $case->getRabidByBrgy($brgyID);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="petstaticon.png">

    <style>
  body {
            background-color: white;
        }

        .container {
            /* margin-top: 50px; */
            background-color:  white;
            /* padding: 20px; */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            height: 100%;
            width: 200%;
            margin-left: -200px; 
            margin-right: auto;
            /* align-items: start; */
        }
        .container .content {
            flex: 1; /* This will make the content area fill the remaining space */
            overflow-y: auto; /* Add scroll if content overflows */
        }
        h1 {
            color: black;
            font-weight: bold;
        }

        .left-sidebar--sticky-container {
            width: 100%;
        }

        .nav-tabs {
            margin-bottom: 1rem;
        }

        .modal-dialog {
            margin: 0 auto;
        }

        #main-content {
            flex: 1;
            padding: 20px;
            box-sizing: border-box;
        }

        #map {
            width: 100%; /* Adjust width to match container */
            height: 50vh;
            border: none; /* Remove border */
        }

        #myChart,
        #pieChart {
            width: 300%; /* Adjust width to match container */
            border: black; /* Remove border */
        }

        


        @media (min-width: 576px) {
            .h-sm-100 {
                height: 100%;
            }
        }



        .chart-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: start;
        }

        @media (min-width: 768px) {
            .chart-container {
                flex-wrap: nowrap;
            }
        }

        canvas {
            max-width: 200%;
            height: auto;
        }
        .col-12,
        .col-xl-2 {
            width: 20%;
        }

        .px-sm-2,
        .px-0 {
            padding-right: 20px;
            padding-left: 20px;
        }

        .pt-2 {
            padding-top: 20px; 
        }
        .bg-gray {
             background-color: #c5c6d0; 
        }
        img{
            align-items: end;
        }
    </style>
</head>

<body>
    <div class="container-fluid overflow-hidden">
        <div class="row vh-100 overflow-auto">
            <div class="col-12 col-sm-3 shadow-sm bg-gray col-xl-2 px-sm-2 px-0 d-flex sticky-top">
                <div class="d-flex flex-sm-column flex-row flex-grow-1 align-items-center align-items-sm-start px-3 pt-2 text-white">
                    <!-- <div class="row " style="width: 100%;">
                        <div class="container-fluid">
                            <div class="col-md-3 shadow-sm p-3 mb-5 bg-white rounded .col-sm-1 .col-lg-2 d-flex flex-column flex-shrink-0 p-3 bg-light " style="width: 280px;">
                                <div class="left-sidebar--sticky-container js-sticky-leftnav">
                                    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none"> -->
                    <a href="dashboardBAO.php" class="navbar-brand fs-4 d-flex align-items-center d-flex mb-3 mb-md-0 me-md-auto link-dark">
                        <span class=> <img class=" bi me-2" width="55" height="55" role="img" src="petstaticon.svg">
                            </img>
                            <span class="d-none d-sm-inline pt-3"><strong>PETSTAT</strong></span></span>
                    </a>
                    <ul class="nav nav-underline flex-sm-column flex-row flex-nowrap flex-shrink-1 flex-sm-grow-0 flex-grow-1 mb-sm-auto justify-content-center align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="dashboardBAO.php" class="flex-sm-fill text-sm-center nav-link text-dark" aria-current="page">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" />
                                </svg><span class="ms-2 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <form method="post" action="./BAOpetdashboard.php?active-tab=1">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="userType" value="<?php echo $userType; ?>">
                                <input type="hidden" name="active-tab" value="1">
                                <button type="submit" data-bs-toggle="collapse" class="nav-link text-dark px-sm-0 px-2"> <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z" />
                                    </svg> <span class="ms-2 d-none d-sm-inline">Pet Dashboard</span></button>
                            </form>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle text-decoration-none text-dark px-sm-0 px-1" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V299.6l-94.7 94.7c-8.2 8.2-14 18.5-16.8 29.7l-15 60.1c-2.3 9.4-1.8 19 1.4 27.8H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM549.8 235.7l14.4 14.4c15.6 15.6 15.6 40.9 0 56.6l-29.4 29.4-71-71 29.4-29.4c15.6-15.6 40.9-15.6 56.6 0zM311.9 417L441.1 287.8l71 71L382.9 487.9c-4.1 4.1-9.2 7-14.9 8.4l-60.1 15c-5.5 1.4-11.2-.2-15.2-4.2s-5.6-9.7-4.2-15.2l15-60.1c1.4-5.6 4.3-10.8 8.4-14.9z" />
                                </svg><span class="ms-2 d-none d-sm-inline">Report Case</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-lg" aria-labelledby="dropdown">
                                <li><a class="dropdown-item" href="addBiteCase.php">Report Bite Case</a></li>
                                <li><a class="dropdown-item" href="addDeathCase.php">Report Death Case</a></li>
                                <li><a class="dropdown-item" href="reportRabidBao.php">Report Rabid Case</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle text-decoration-none text-dark px-sm-0 px-1" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M448 160H320V128H448v32zM48 64C21.5 64 0 85.5 0 112v64c0 26.5 21.5 48 48 48H464c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48H48zM448 352v32H192V352H448zM48 288c-26.5 0-48 21.5-48 48v64c0 26.5 21.5 48 48 48H464c26.5 0 48-21.5 48-48V336c0-26.5-21.5-48-48-48H48z" />
                                </svg><span class="ms-2 d-none d-sm-inline">Manage</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-lg " aria-labelledby="dropdown">
                                <li><a class="dropdown-item" href="./dashboard1.php?active-tab=1">Manage Resident</a></li>
                                <li><a class="dropdown-item" href="./dashboard1pet.php?active-tab=1">Manage Pet</a></li>
                                <li><a class="dropdown-item" href="./dashboardBiteCases.php?active-tab=1">Manage Bite Cases</a></li>
                                <li><a class="dropdown-item" href="./dashboardRabidCases.php?active-tab=1">Manage Suspected Cases</a></li>
                                <li><a class="dropdown-item" href="./dashboardDeathCases.php?active-tab=1">Manage Death Cases</a></li>
                            </ul>
                        </li>
                        <!-- <li class="nav-item">
                            <form method="POST" action="reportCase.php" id="reportBiteCaseForm" style="display: inline;">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="userType" value="<?php echo $userType; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <button class="nav-link text-dark" type="submit" class="btn">Report Case</button>
                            </form>
                        </li> -->
                        <li class="nav-item">
                            <form method="post" action="./tabularBAO.php?active-tab=1" style="display: inline;">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="userType" value="<?php echo $userType; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <button type="submit" data-bs-toggle="collapse" class="nav-link active text-dark px-sm-0 px-2"> <svg xmlns="http://www.w3.org/2000/svg" height="20" width="15" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128z" />
                                    </svg><span class="ms-2 d-none d-sm-inline"> Reports</span></button>
                            </form>
                        </li>

                        <!-- <li class="nav-item"><a href="viewHeatmaps.php" class="nav-link text-dark">View Heatmaps</a></li> -->
                        <!-- <li class="nav-item">
                            <form method="post" action="./dashboard1.php?active-tab=1" style="display: inline;">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <button type="submit" class="nav-link text-dark">Manage Resident</button>
                            </form>
                        </li>
                        <li class="nav-item">
                            <form method="post" action="./dashboard1pet.php?active-tab=1" style="display: inline;">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <button type="submit" class="nav-link text-dark">Manage Pet</button>
                            </form>
                        </li>
                        <li class="nav-item">
                            <form method="post" action="./dashboardBiteCases.php?active-tab=1" style="display: inline;">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="userType" value="<?php echo $userType; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <button type="submit" class="nav-link text-dark">Manage Bite Cases</button>
                            </form>
                        </li>
                        <li>
                            <form method="post" action="./dashboardRabidCases.php?active-tab=1" style="display: inline;">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="userType" value="<?php echo $userType; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <button type="submit" class="nav-link text-dark">Manage Suspected Cases</button>
                            </form>
                        </li>
                        <li>
                            <form method="post" action="./dashboardDeathCases.php?active-tab=1" style="display: inline;">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="userType" value="<?php echo $userType; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <button type="submit" class="nav-link text-dark">Manage Death Cases</button>
                            </form>
                        </li> -->

                        <li class="nav-item">
                            <form method="post" action="createAccForResident.php" style="display: inline;">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <button type="submit" data-bs-toggle="collapse" class="nav-link text-dark px-sm-0 px-2"> <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                                    </svg><span class="ms-2 d-none d-sm-inline">Account for Resident</span></button>
                                </a>
                            </form>
                        </li>
                        <div class="dropdown py-sm-4 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
                            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" class="rounded-circle me-2 outline" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                                </svg>
                                <strong><span class="d-none d-sm-inline mx-1"> <?php echo isset($user['name']) ? $user['name'] : ''; ?> </span>
                                </strong>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </ul>
                </div>
            </div>

            <div class="col d-flex flex-column h-sm-100">
                <main class="row overflow-auto">
                    <div class="col-md-8 p-1 mt-2 my-auto mx-auto">
                        <div class="container mt-2">
                            <form method="POST" action="" id="tabform" name="Tabform">
                                <h1>Reported Cases</h1>
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link<?=($active_tab == 1) ? ' active' : '' ?>" href="./tabularBAO.php?active-tab=1#registered" data-bs-toggle="tab">Registries</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link<?=($active_tab == 2) ? ' active' : '' ?>" href="./tabularBAO.php?active-tab=2#Bites" data-bs-toggle="tab">Bites</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link<?=($active_tab == 3) ? ' active' : '' ?>" href="./tabularBAO.php?active-tab=3#Deaths" data-bs-toggle="tab">Deaths</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link<?=($active_tab == 4) ? ' active' : '' ?>" href="./tabularBAO.php?active-tab=4#Rabid" data-bs-toggle="tab">Rabid</a>
                                    </li>
                                </ul>
                                <!-- Tab Content -->
                                <div class="tab-content">
                                    <!-- Valid Residents -->
                                    <div class="tab-pane <?=($active_tab == 1) ? ' active show' : '' ?>"  id="registered">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <div class="row">
                                                    <thead>
                                                        <tr>
                                                            <th>Owner's Name</th>
                                                            <th>Date of Registry</th>
                                                            <th>Pet Type</th>
                                                            <th>Name of Pet</th>
                                                            <th>Sex</th>
                                                            <th>Age</th>
                                                            <th>Neutering</th>
                                                            <th>Color</th>
                                                            <th>Vaccination Status</th>
                                                            <th>Last Vaccination</th>
                                                            <th>Current Vaccination</th>
                                                            <th>Address</th>
                                                        </tr>
                                                    </thead>
                                                    </div>
                                                    <tbody>
                                                        <?php
                                                        // Database connection
                                                        $servername = "localhost";
                                                        $username = "root";
                                                        $password = "";
                                                        $dbname = "petstatvan";

                                                        // Create connection
                                                        $conn = new mysqli($servername, $username, $password, $dbname);

                                                        // Check connection
                                                        if ($conn->connect_error) {
                                                            die("Connection failed: " . $conn->connect_error);
                                                        }

                                                        // Define the brgyID you want to filter by
                                                        $brgyID = isset($_GET['brgyID']) ? $_GET['brgyID'] : ''; // Assuming you're passing brgyID via GET parameter

                                                        // Pagination
                                                        $items_per_page = 7; // Adjust this value as needed
                                                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                                        $offset = ($page - 1) * $items_per_page;

                                                        // SQL query to fetch pets information for a specific barangay with pagination
                                                        $sql = "SELECT p.*, r.*, v.*, b.*, p.petID
                                                                FROM resident AS r
                                                                NATURAL JOIN pet AS p
                                                                LEFT JOIN (
                                                                    SELECT petID, MAX(lastVaccination) AS maxlastVaccination, lastVaccination
                                                                    FROM vaccination
                                                                    GROUP BY petID
                                                                ) AS v ON p.petID = v.petID
                                                                LEFT JOIN barangay AS b ON r.brgyID = b.brgyID
                                                                WHERE p.status = 1 ";

                                                        // If brgyID is provided, filter by it
                                                        if ($brgyID !== '') {
                                                            $sql .= "AND r.brgyID = '$brgyID' ";
                                                        }

                                                        $sql .= "ORDER BY v.maxlastVaccination DESC
                                                                LIMIT $items_per_page OFFSET $offset";

                                                        $result = $conn->query($sql);

                                                        if ($result->num_rows > 0) {
                                                            // Output data of each row
                                                            while ($row = $result->fetch_assoc()) {
                                                                echo "<tr>";
                                                                echo "<td>" . $row["name"] . "</td>";
                                                                $input_date = $row['regDate'];
                                                                $date_obj = new DateTime($input_date);
                                                                $formatted_date = $date_obj->format("F j Y");
                                                                echo '<td>' . $formatted_date . '</td>';
                                                                echo "<td>" . ($row["petType"] == 0 ? 'Dog' : 'Cat') . "</td>";
                                                                echo "<td>" . $row["pname"] . "</td>";
                                                                echo "<td>" . ($row["sex"] == 0 ? 'Male' : 'Female') . "</td>";
                                                                echo "<td>" . $row["age"] . "</td>";
                                                                echo "<td>" . ($row["Neutering"] == 0 ? 'Neutered' : 'Not Neutered') . "</td>";
                                                                echo "<td>" . $row["color"] . "</td>";
                                                                echo "<td>" . ($row["statusVac"] == 0 ? 'Vaccinated' : 'Unvaccinated') . "</td>";
                                                                $input_date = $row['lastVaccination'];
                                                                $date_obj = new DateTime($input_date);
                                                                $formatted_date = $date_obj->format("F j Y");
                                                                echo '<td>' . $formatted_date . '</td>';
                                                                $input_date = $row['currentVac'];
                                                                $date_obj = new DateTime($input_date);
                                                                $formatted_date = $date_obj->format("F j Y");
                                                                echo '<td>' . $formatted_date . '</td>';
                                                                echo "<td>" . $row["barangay"] . "</td>";
                                                                echo "</tr>";
                                                            }
                                                                } else {
                                                                    echo "<tr><td colspan='12'>No pets found for this barangay.</td></tr>";
                                                                }
                                                            ?>
                                                        </tbody>
                                                        </table>

                                                        <!-- Pagination -->
                                                        <div class="d-flex justify-content-center mt-4">
                                                            <ul class="pagination">
                                                                <?php
                                                                    // Count total number of pets
                                                                    $total_pets_sql = "SELECT COUNT(*) AS total FROM resident AS r
                                                                                        NATURAL JOIN pet AS p
                                                                                        LEFT JOIN (
                                                                                            SELECT petID
                                                                                            FROM vaccination
                                                                                            GROUP BY petID
                                                                                        ) AS v ON p.petID = v.petID
                                                                                        LEFT JOIN barangay AS b ON r.brgyID = b.brgyID
                                                                                        WHERE p.status = 1 ";

                                                                    // If brgyID is provided, filter by it
                                                                    if ($brgyID !== '') {
                                                                        $total_pets_sql .= "AND r.brgyID = '$brgyID' ";
                                                                    }

                                                                    $total_pets_result = $conn->query($total_pets_sql);
                                                                    $total_pets = $total_pets_result->fetch_assoc()['total'];

                                                                    // Calculate total pages
                                                                    $total_pages = ceil($total_pets / $items_per_page);

                                                                    // Pagination links
                                                                    for ($i = 1; $i <= $total_pages; $i++) {
                                                                        echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='./tabularBAO.php?active-tab=1&brgyID=$brgyID&page=$i'>$i</a></li>";
                                                                    }
                                                                ?>
                                                            </ul>
                                                        </div>

                                                        <?php
                                                            // Close connection
                                                            $conn->close();
                                                        ?>
                                                    </div>
                                                    </div>


                                    <!-- Cases -->
                                    <div class="tab-pane <?=($active_tab == 2) ? ' active show' : '' ?>"  id="Bites">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <div class="row">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>Victim's Name</th>
                                                            <th>Species</th>
                                                            <th>Pet's Name</th>
                                                            <th>Owner's Name</th>
                                                            <th>Date Occurred</th>
                                                            <th>Address</th>
                                                            <th>Vaccination Status</th>
                                                            <th>Body Part Bitten</th>
                                                            <th>Description</th>
                                                            <th>Rabies</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="valid-c">
                                                        <?php
                                                        // Database connection
                                                        $servername = "localhost";
                                                        $username = "root";
                                                        $password = "";
                                                        $dbname = "petstatvan";

                                                        // Create connection
                                                        $conn = new mysqli($servername, $username, $password, $dbname);

                                                        // Check connection
                                                        if ($conn->connect_error) {
                                                            die("Connection failed: " . $conn->connect_error);
                                                        }

                                                        // Define the brgyID you want to filter by
                                                        $brgyID = isset($_GET['brgyID']) ? $_GET['brgyID'] : ''; // Assuming you're passing brgyID via GET parameter

                                                        // Pagination
                                                        $items_per_page = 5; // Adjust this value as needed
                                                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                                        $offset = ($page - 1) * $items_per_page;

                                                        // SQL query to fetch cases information for a specific barangay with pagination
                                                        $sql = "SELECT c.*, p.*, r.*, b.*
                                                                FROM `case` AS c
                                                                INNER JOIN pet AS p ON c.petID = p.petID
                                                                INNER JOIN resident AS r ON p.residentID = r.residentID
                                                                INNER JOIN barangay AS b ON c.brgyID = b.brgyID
                                                                WHERE c.caseStatus = 1 AND c.caseType = 0";

                                                        // If brgyID is provided, filter by it
                                                        if ($brgyID !== '') {
                                                            $sql .= " AND r.brgyID = '$brgyID'";
                                                        }

                                                        $count_sql = "SELECT COUNT(*) AS total FROM (`case` AS c
                                                                    INNER JOIN pet AS p ON c.petID = p.petID
                                                                    INNER JOIN resident AS r ON p.residentID = r.residentID
                                                                    INNER JOIN barangay AS b ON c.brgyID = b.brgyID)
                                                                    WHERE c.caseStatus = 1 AND c.caseType = 0";

                                                        // If brgyID is provided, filter by it
                                                        if ($brgyID !== '') {
                                                            $count_sql .= " AND r.brgyID = '$brgyID'";
                                                        }

                                                        $total_cases_result = $conn->query($count_sql);
                                                        $total_cases = $total_cases_result->fetch_assoc()['total'];

                                                        $sql .= " ORDER BY c.date DESC
                                                                LIMIT $items_per_page OFFSET $offset";

                                                        $result = $conn->query($sql);

                                                        if ($result->num_rows > 0) {
                                                            while ($case = $result->fetch_assoc()) {
                                                                echo '<tr class="text-center">';
                                                                echo '<td>' . $case['victimsName'] . '</td>';
                                                                echo '<td>' . ($case['petType'] == 0 ? 'Dog' : 'Cat') . '</td>';
                                                                echo '<td>' . $case['pname'] . '</td>';
                                                                echo '<td>' . $case['name'] . '</td>';
                                                                $input_date = $case['date'];
                                                                $date_obj = new DateTime($input_date);
                                                                $formatted_date = $date_obj->format("F j, Y");
                                                                echo '<td>' . $formatted_date . '</td>';
                                                                echo '<td>' . $case['barangay'] . '</td>';
                                                                echo '<td>' . ($case['statusVac'] == 0 ? 'Vaccinated' : 'Unvaccinated') . '</td>';
                                                                echo '<td>' . (
                                                                    $case['bpartBitten'] == 0 ? 'Head and Neck Area' :
                                                                    ($case['bpartBitten'] == 1 ? 'Thorax Area' :
                                                                    ($case['bpartBitten'] == 2 ? 'Abdomen Area' :
                                                                    ($case['bpartBitten'] == 3 ? 'Upper Extremities' :
                                                                    ($case['bpartBitten'] == 4 ? 'Lower Extremities' : 'Unknown')))))
                                                                    . '</td>';
                                                                echo '<td>' . $case['description'] . '</td>';
                                                                echo '<td>' . ($case['confirmedRabies'] == 0 ? 'No' : 'Yes') . '</td>';
                                                                echo '</tr>';
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='10'>No pet cases found for this barangay.</td></tr>";
                                                        }

                                                        // Close connection
                                                        $conn->close();
                                                        ?>
                                                    </tbody>
                                                </div>
                                            </table>
                                            <!-- Pagination -->
                                            <div class="d-flex justify-content-center mt-4">
                                                <ul class="pagination">
                                                    <?php
                                                    $total_pages = ceil($total_cases / $items_per_page);
                                                    for ($i = 1; $i <= $total_pages; $i++) {
                                                        echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='./tabularBAO.php?active-tab=2&brgyID=$brgyID&page=$i'>$i</a></li>";
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Death -->
                                    <div class="tab-pane <?=($active_tab == 3) ? ' active show' : '' ?>"  id="Deaths">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>Owner's Name</th>
                                                        <th>Pet's Name</th>
                                                        <th>Date Occurred</th>
                                                        <th>Description</th>
                                                        <th>Address</th>
                                                        <th>Rabies</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="valid-d">
                                                <?php
                                                    // Database connection
                                                    $servername = "localhost";
                                                    $username = "root";
                                                    $password = "";
                                                    $dbname = "petstatvan";

                                                    // Create connection
                                                    $conn = new mysqli($servername, $username, $password, $dbname);

                                                    // Check connection
                                                    if ($conn->connect_error) {
                                                        die("Connection failed: " . $conn->connect_error);
                                                    }

                                                    // Define the brgyID you want to filter by
                                                    $brgyID = isset($_GET['brgyID']) ? $_GET['brgyID'] : ''; // Assuming you're passing brgyID via GET parameter

                                                    // Pagination
                                                    $items_per_page = 5; // Adjust this value as needed
                                                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                                    $offset = ($page - 1) * $items_per_page;

                                                    // SQL query to fetch cases information for a specific barangay with pagination
                                                    $sql = "SELECT c.*, p.*, r.*, b.*
                                                            FROM `case` AS c
                                                            INNER JOIN pet AS p ON c.petID = p.petID
                                                            INNER JOIN resident AS r ON p.residentID = r.residentID
                                                            INNER JOIN barangay AS b ON c.brgyID = b.brgyID
                                                            WHERE c.caseStatus = 1 AND c.caseType = 1";

                                                    // If brgyID is provided, filter by it
                                                    if ($brgyID !== '') {
                                                        $sql .= " AND r.brgyID = '$brgyID'";
                                                    }

                                                    $count_sql = "SELECT COUNT(*) AS total FROM (`case` AS c
                                                                INNER JOIN pet AS p ON c.petID = p.petID
                                                                INNER JOIN resident AS r ON p.residentID = r.residentID
                                                                INNER JOIN barangay AS b ON c.brgyID = b.brgyID)
                                                                WHERE c.caseStatus = 1 AND c.caseType = 1";

                                                    // If brgyID is provided, filter by it
                                                    if ($brgyID !== '') {
                                                        $count_sql .= " AND r.brgyID = '$brgyID'";
                                                    }

                                                    $total_cases_result = $conn->query($count_sql);
                                                    $total_cases = $total_cases_result->fetch_assoc()['total'];

                                                    $sql .= " ORDER BY c.date DESC
                                                            LIMIT $items_per_page OFFSET $offset";

                                                    $result = $conn->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        while ($death = $result->fetch_assoc()) {
                                                            echo '<tr class="text-center">';
                                                            echo '<td>' . $death['name'] . '</td>';
                                                            echo '<td>' . $death['pname'] . '</td>';
                                                            $input_date = $death['date'];

                                                            // Convert the input date to a DateTime object
                                                            $date_obj = new DateTime($input_date);

                                                            // Format the date as "Month Day, Year"
                                                            $formatted_date = $date_obj->format("F j, Y");

                                                            // Print the formatted date
                                                            echo '<td>' . $formatted_date . '</td>';
                                                            echo '<td>' . $death['description'] . '</td>';
                                                            echo '<td>' . $death['barangay'] . '</td>';
                                                            echo '<td>' . ($death['confirmedRabies'] == 0 ? 'Natural Cause' : 'Rabies') . '</td>';
                                                            echo '</tr>';
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='6'>No death cases found for this barangay.</td></tr>";
                                                    }

                                                    // Close connection
                                                    $conn->close();
                                                    ?>
                                                </tbody>
                                            </table>
                                            <!-- Pagination -->
                                            <div class="d-flex justify-content-center mt-4">
                                                <ul class="pagination">
                                                    <?php
                                                    $total_pages = ceil($total_cases / $items_per_page);
                                                    for ($i = 1; $i <= $total_pages; $i++) {
                                                        echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='./tabularBAO.php?active-tab=3&brgyID=$brgyID&page=$i'>$i</a></li>";
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="tab-pane <?=($active_tab == 4) ? ' active show' : '' ?>"  id="Rabid">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>Owner's Name</th>
                                                        <th>Pet's Name</th>
                                                        <th>Date Discovered</th>
                                                        <th>Description</th>
                                                        <th>Address</th>
                                                        <th>Rabies</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="valid-s">
                                                <?php
                                                    // Database connection
                                                    $servername = "localhost";
                                                    $username = "root";
                                                    $password = "";
                                                    $dbname = "petstatvan";

                                                    // Create connection
                                                    $conn = new mysqli($servername, $username, $password, $dbname);

                                                    // Check connection
                                                    if ($conn->connect_error) {
                                                        die("Connection failed: " . $conn->connect_error);
                                                    }

                                                    // Define the brgyID you want to filter by
                                                    $brgyID = isset($_GET['brgyID']) ? $_GET['brgyID'] : ''; // Assuming you're passing brgyID via GET parameter

                                                    // Pagination
                                                    $items_per_page = 5; // Adjust this value as needed
                                                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                                    $offset = ($page - 1) * $items_per_page;

                                                    // SQL query to fetch cases information for a specific barangay with pagination
                                                    $sql = "SELECT c.*, p.*, r.*, b.*
                                                            FROM `case` AS c
                                                            LEFT JOIN pet AS p ON c.petID = p.petID
                                                            LEFT JOIN resident AS r ON r.residentID = c.residentID
                                                            LEFT JOIN barangay AS b ON c.brgyID = b.brgyID
                                                            WHERE c.caseStatus = 1 AND c.caseType = 2";

                                                    // If brgyID is provided, filter by it
                                                    if ($brgyID !== '') {
                                                        $sql .= " AND r.brgyID = '$brgyID'";
                                                    }

                                                    $count_sql = "SELECT COUNT(*) AS total FROM (`case` AS c
                                                                LEFT JOIN pet AS p ON c.petID = p.petID
                                                                LEFT JOIN resident AS r ON r.residentID = c.residentID
                                                                LEFT JOIN barangay AS b ON c.brgyID = b.brgyID)
                                                                WHERE c.caseStatus = 1 AND c.caseType = 2";

                                                    // If brgyID is provided, filter by it
                                                    if ($brgyID !== '') {
                                                        $count_sql .= " AND r.brgyID = '$brgyID'";
                                                    }

                                                    $total_cases_result = $conn->query($count_sql);
                                                    $total_cases = $total_cases_result->fetch_assoc()['total'];

                                                    $sql .= " ORDER BY c.date DESC
                                                            LIMIT $items_per_page OFFSET $offset";

                                                    $result = $conn->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        while ($rabid = $result->fetch_assoc()) {
                                                            echo '<tr class="text-center">';
                                                            echo '<td>' . $rabid['name'] . '</td>';
                                                            echo '<td>' . $rabid['pname'] . '</td>';
                                                            $input_date = $rabid['date'];

                                                            // Convert the input date to a DateTime object
                                                            $date_obj = new DateTime($input_date);

                                                            // Format the date as "Month Day, Year"
                                                            $formatted_date = $date_obj->format("F j, Y");

                                                            // Print the formatted date
                                                            echo '<td>' . $formatted_date . '</td>';
                                                            echo '<td>' . $rabid['description'] . '</td>';
                                                            echo '<td>' . $rabid['barangay'] . '</td>';
                                                            echo '<td>' . ($rabid['confirmedRabies'] == 0 ? 'No' : 'Yes') . '</td>';
                                                            echo '</tr>';
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='6'>No rabid cases found for this barangay.</td></tr>";
                                                    }

                                                    // Close connection
                                                    $conn->close();
                                                    ?>
                                                </tbody>
                                            </table>
                                            <!-- Pagination -->
                                            <div class="d-flex justify-content-center mt-4">
                                                <ul class="pagination">
                                                    <?php
                                                    $total_pages = ceil($total_cases / $items_per_page);
                                                    for ($i = 1; $i <= $total_pages; $i++) {
                                                        echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='./tabularBAO.php?active-tab=4&brgyID=$brgyID&page=$i'>$i</a></li>";
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                    <script>
                        // Export buttons
                        function RegistriesExport() {
                            // Prevent the default action (form submission or link click)
                            event.preventDefault();

                            // var searchValue = $("#yearSrch").val().toLowerCase();
                            // var rows = $("#valid-r tr:visible");    
                            // // Your data to be converted to CSV
                            const data = [
                                ['Owner\'s Name', 'Date of Registry', 'Pet Type', 'Name of Pet', 'Sex', 'Age', 'Neutering', 'Color', 'Vaccination Status', 'Last Vaccination', 'Current Vaccination', 'Address', ''],
                                <?php
                                foreach ($pets as $pet) {
                                    $input_date1 = $pet['regDate'];
                                    $date_obj1 = new DateTime($input_date1);
                                    $formatted_date1 = $date_obj1->format("F j-Y");

                                    $input_date2 = $pet['lastVaccination'];
                                    $date_obj2 = new DateTime($input_date2);
                                    $formatted_date2 = $date_obj2->format("F j-Y");

                                    $input_date3 = $pet['currentVac'];
                                    $date_obj3 = new DateTime($input_date3);
                                    $formatted_date3 = $date_obj3->format("F j-Y");

                                    echo '["' . $pet['name'] . '","' . $formatted_date1 . '","' . $petType[$pet['petType']] . '","' . $pet['pname'] . '","' . $sex[$pet['sex']] . '","' . $pet['age'] . '","' . $neutering[$pet['Neutering']] . '","' . $pet['color'] . '","' . $vacStatus[$pet['statusVac']] . '","' . $formatted_date2 . '","' . $formatted_date3 . '","' . $pet['barangay'] . '"],';
                                }
                                ?>
                            ];

                            // Convert the data to CSV format
                            const csvContent = data.map(row => row.join(',')).join('\n');

                            // Create a Blob containing the CSV data
                            const blob = new Blob([csvContent], {
                                type: 'text/csv;charset=utf-8;'
                            });

                            // Create a link element to trigger the download
                            const link = document.createElement('a');
                            link.href = URL.createObjectURL(blob);
                            link.setAttribute('download', 'Registries.csv');
                            document.body.appendChild(link);

                            // Trigger the click event on the link to initiate the download
                            link.click();

                            // Remove the link element after a delay to ensure the download has started
                            setTimeout(function() {
                                document.body.removeChild(link);
                            }, 1000); // You can adjust the delay as needed
                        }

                        function BitesExport() {
                            // Prevent the default action (form submission or link click)
                            event.preventDefault();

                            // Your data to be converted to CSV
                            const data = [
                                ['Victim\'s Name', 'Pet Type', 'Pet Name', 'Owner\'s Name', 'Date', 'Barangay', 'Vaccination Status', 'Bitten Area', 'Description', 'Confirmed Rabies'],
                                <?php
                                foreach ($bites as $case) {
                                    $input_date = $case['date'];
                                    // Convert the input date to a DateTime object
                                    $date_obj = new DateTime($case['date']);
                                    // Format the date as "F j, Y"
                                    $formatted_date = $date_obj->format("F j, Y");

                                    echo '["' . $case['victimsName'] . '","' . ($case['petType'] == 0 ? 'Dog' : 'Cat') . '","' . $case['pname'] . '","' . $case['name'] . '","' . $formatted_date . '","' . $case['barangay'] . '","' . ($case['statusVac'] == 0 ? 'Vaccinated' : 'Unvaccinated') . '","' . (
                                        $case['bpartBitten'] == 0 ? 'Head and Neck Area' : ($case['bpartBitten'] == 1 ? 'Thorax Area' : ($case['bpartBitten'] == 2 ? 'Abdomen Area' : ($case['bpartBitten'] == 3 ? 'Upper Extremities' : ($case['bpartBitten'] == 4 ? 'Lower Extremities' : 'Unknown'))))) . '","' . $case['description'] . '","' . ($case['confirmedRabies'] == 0 ? 'Natural Cause' : 'Rabies') . '"],';
                                }
                                ?>
                            ];

                            // Convert the data to CSV format
                            const csvContent = data.map(row => row.join(',')).join('\n');

                            // Create a Blob containing the CSV data
                            const blob = new Blob([csvContent], {
                                type: 'text/csv;charset=utf-8;'
                            });

                            // Create a link element to trigger the download
                            const link = document.createElement('a');
                            link.href = URL.createObjectURL(blob);
                            link.setAttribute('download', 'Cases.csv');
                            document.body.appendChild(link);

                            // Trigger the click event on the link to initiate the download
                            link.click();

                            // Remove the link element after a delay to ensure the download has started
                            setTimeout(function() {
                                document.body.removeChild(link);
                            }, 1000); // You can adjust the delay as needed
                        }


                        function DeathsExport() {
                            // Prevent the default action (form submission or link click)
                            event.preventDefault();

                            // Your data to be converted to CSV
                            const data = [
                                ['Owner\'s Name', 'Pet Name', 'Date', 'Description', 'Barangay', 'Rabies Status'],
                                <?php
                                foreach ($death as $deaths) {
                                    $input_date = $deaths['date'];
                                    $date_obj = new DateTime($input_date);
                                    $formatted_date = $date_obj->format("F j Y");

                                    echo '["' . $deaths['name'] . '","' . $deaths['pname'] . '","' . $formatted_date . '","' . $deaths['description'] . '","' . $deaths['barangay'] . '","' . ($deaths['confirmedRabies'] == 0 ? 'Natural Cause' : 'Rabies') . '"],';
                                }
                                ?>
                            ];

                            // Convert the data to CSV format
                            const csvContent = data.map(row => row.join(',')).join('\n');

                            // Create a Blob containing the CSV data
                            const blob = new Blob([csvContent], {
                                type: 'text/csv;charset=utf-8;'
                            });

                            // Create a link element to trigger the download
                            const link = document.createElement('a');
                            link.href = URL.createObjectURL(blob);
                            link.setAttribute('download', 'Deaths.csv');
                            document.body.appendChild(link);

                            // Trigger the click event on the link to initiate the download
                            link.click();

                            // Remove the link element after a delay to ensure the download has started
                            setTimeout(function() {
                                document.body.removeChild(link);
                            }, 1000); // You can adjust the delay as needed
                        }

                        function RabidsExport() {
                            // Prevent the default action (form submission or link click)
                            event.preventDefault();

                            // Your data to be converted to CSV
                            const data = [
                                ['Owner\'s Name', 'Pet Name', 'Date', 'Description', 'Barangay', 'Rabies Status'],
                                <?php
                                foreach ($rabid as $rabids) {
                                    $input_date = $rabids['date'];
                                    $date_obj = new DateTime($input_date);
                                    $formatted_date = $date_obj->format("F j Y");

                                    echo '["' . $rabids['name'] . '","' . $rabids['pname'] . '","' . $formatted_date . '","' . $rabids['description'] . '","' . $rabids['barangay'] . '","' . ($rabids['confirmedRabies'] == 0 ? 'No' : 'Yes') . '"],';
                                }
                                ?>
                            ];

                            // Convert the data to CSV format
                            const csvContent = data.map(row => row.join(',')).join('\n');

                            // Create a Blob containing the CSV data
                            const blob = new Blob([csvContent], {
                                type: 'text/csv;charset=utf-8;'
                            });

                            // Create a link element to trigger the download
                            const link = document.createElement('a');
                            link.href = URL.createObjectURL(blob);
                            link.setAttribute('download', 'Rabids.csv');
                            document.body.appendChild(link);

                            // Trigger the click event on the link to initiate the download
                            link.click();

                            // Remove the link element after a delay to ensure the download has started
                            setTimeout(function() {
                                document.body.removeChild(link);
                            }, 1000); // You can adjust the delay as needed
                        }
                    </script>

                    <script>
                        // year search buttons
                        //registries
                        $("#RegYrsBtn").click(function() {
                            var searchValue = $("#RegYrs").val().toLowerCase();
                            var rows = $("#valid-r tr");

                            var matchingRows = rows.filter(function() {
                                return $(this).text().toLowerCase().indexOf(searchValue) > -1;
                            });

                            rows.hide(); // Hide all rows

                            if (matchingRows.length > 0) {
                                matchingRows.show(); // Show matching rows
                            } else {
                                // Display a message when there are no search results
                                $("#valid-r").append('<tr><td colspan="6">No matching results found.</td></tr>');
                            }
                        });
                        //bites
                        $("#BiteYrsBtn").click(function() {
                            var searchValue = $("#BiteYrs").val().toLowerCase();
                            var rows = $("#valid-c tr");

                            var matchingRows = rows.filter(function() {
                                return $(this).text().toLowerCase().indexOf(searchValue) > -1;
                            });

                            rows.hide(); // Hide all rows

                            if (matchingRows.length > 0) {
                                matchingRows.show(); // Show matching rows
                            } else {
                                // Display a message when there are no search results
                                $("#valid-c").append('<tr><td colspan="6">No matching results found.</td></tr>');
                            }
                        });

                        // deaths
                        $("#DeathYrsBtn").click(function() {
                            var searchValue = $("#DeathYrs").val().toLowerCase();
                            var rows = $("#valid-d tr");

                            var matchingRows = rows.filter(function() {
                                return $(this).text().toLowerCase().indexOf(searchValue) > -1;
                            });

                            rows.hide(); // Hide all rows

                            if (matchingRows.length > 0) {
                                matchingRows.show(); // Show matching rows
                            } else {
                                // Display a message when there are no search results
                                $("#valid-d").append('<tr><td colspan="6">No matching results found.</td></tr>');
                            }
                        });
                        $("#DeathYrsBtn").click(function() {
                            var searchValue = $("#DeathYrs").val().toLowerCase();
                            var rows = $("#valid-d tr");

                            var matchingRows = rows.filter(function() {
                                return $(this).text().toLowerCase().indexOf(searchValue) > -1;
                            });

                            rows.hide(); // Hide all rows

                            if (matchingRows.length > 0) {
                                matchingRows.show(); // Show matching rows
                            } else {
                                // Display a message when there are no search results
                                $("#valid-d").append('<tr><td colspan="6">No matching results found.</td></tr>');
                            }
                        });
                    </script>

                    <script>
                        // search buttons
                        $("#regSrchBtn").click(function() {
                            var searchValue = $("#regSrch").val().toLowerCase();
                            var rows = $("#valid-r tr");

                            if (searchValue.trim() === "") {
                                rows.show();
                            } else {
                                rows.hide();


                                var matchingRows = rows.filter(function() {
                                    return $(this).text().toLowerCase().indexOf(searchValue) > -1;
                                });

                                if (matchingRows.length > 0) {
                                    matchingRows.show();
                                } else {
                                    $("#valid-r").append('<tr><td colspan="13">No matching results found.</td></tr>');
                                }
                            }
                        });

                        $("#casesSrchBtn").click(function() {
                            var searchValue = $("#casesSearch").val().toLowerCase();
                            var rows = $("#valid-c tr");

                            if (searchValue.trim() === "") {
                                rows.show();
                            } else {
                                rows.hide();


                                var matchingRows = rows.filter(function() {
                                    return $(this).text().toLowerCase().indexOf(searchValue) > -1;
                                });

                                if (matchingRows.length > 0) {
                                    matchingRows.show();
                                } else {
                                    $("#valid-c").append('<tr><td colspan="13">No matching results found.</td></tr>');
                                }
                            }
                        });

                        $("#DeathSrchBtn").click(function() {
                            var searchValue = $("#deathSearch").val().toLowerCase();
                            var rows = $("#valid-d tr");

                            if (searchValue.trim() === "") {
                                rows.show();
                            } else {
                                rows.hide();


                                var matchingRows = rows.filter(function() {
                                    return $(this).text().toLowerCase().indexOf(searchValue) > -1;
                                });

                                if (matchingRows.length > 0) {
                                    matchingRows.show();
                                } else {
                                    $("#valid-d").append('<tr><td colspan="13">No matching results found.</td></tr>');
                                }
                            }
                        });

                        $("#rabidYrsSrchBtn").click(function() {
                            var searchValue = $("#rabidYrs").val().toLowerCase();
                            var rows = $("#valid-s tr");

                            if (searchValue.trim() === "") {
                                rows.show();
                            } else {
                                rows.hide();

                                var matchingRows = rows.filter(function() {
                                    var rowData = $(this).text().toLowerCase();
                                    return rowData.indexOf(searchValue) > -1;
                                });

                                if (matchingRows.length > 0) {
                                    matchingRows.show();
                                } else {
                                    $("#valid-s").append('<tr><td colspan="13">No matching results found.</td></tr>');
                                }
                            }
                        });
                    </script>
                    </form>
                </main>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Add Bootstrap JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>