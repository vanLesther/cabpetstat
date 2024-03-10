<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pet Information</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.maptiler.com/maptiler-sdk-js/v1.1.1/maptiler-sdk.umd.js"></script>
    <link href="https://cdn.maptiler.com/maptiler-sdk-js/v1.1.1/maptiler-sdk.css" rel="stylesheet" />
    <script src="https://cdn.maptiler.com/leaflet-maptilersdk/v1.0.0/leaflet-maptilersdk.js"></script>
    <script src="https://unpkg.com/heatmap.js"></script>
    <script src="https://unpkg.com/leaflet.heat"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="manifest" href="/manifest.json">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="petstaticon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
   
</head>
<style>
  .filter-row {
  display: flex;
  justify-content: flex-end;
}

.filter-item {
  margin-left: 10px; /* Adjust spacing between items */
  flex: 1; /* Equal width for each item */
  max-width: 150px; /* Limit width of select elements */
}
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
                                    <div class="navbar-brand fs-4 d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark">
                                    <a href="dashboardMao.php" class="d-flex align-items-center link-dark">
                                        <span class="">
                                            <img class="bi me-2" width="55" height="55" role="img" src="petstaticon.svg"></img>
                                            <span class="d-none d-sm-inline pt-3"><strong>PETSTAT</strong></span>
                                        </span>
                                    </a>
                                    <div class="d-flex align-items-center ms-auto">
                                        <button class="btn btn-link me-2" data-bs-toggle="modal" data-bs-target="#notificationModal">
                                            <i class="bi bi-bell fs-4"></i>
                                        </button>
                                    </div>
                                </div>

                    <ul class="nav nav-underline flex-sm-column flex-row flex-nowrap flex-shrink-1 flex-sm-grow-0 flex-grow-1 mb-sm-auto justify-content-center align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="dashboardMAO.php" class="flex-sm-fill text-sm-center nav-link active" aria-current="page">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" />
                                </svg><span class="ms-2 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <form method="post" action="./assign_officer.php?active-tab=1">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="userType" value="<?php echo $userType; ?>">
                                <input type="hidden" name="active-tab" value="1">
                                <button type="submit" data-bs-toggle="collapse" class="nav-link text-dark px-sm-0 px-2">
                                    <strong><i class="bi bi-person-plus" style="font-size: 1.2rem;"></i></strong> <!-- Bootstrap person plus icon -->
                                    <span class="ms-2 d-none d-sm-inline">Assign Officer</span>
                                </button>
                            </form>
                        </li>

                        <!-- <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle text-decoration-none text-dark px-sm-0 px-1" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <!-- <path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V299.6l-94.7 94.7c-8.2 8.2-14 18.5-16.8 29.7l-15 60.1c-2.3 9.4-1.8 19 1.4 27.8H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM549.8 235.7l14.4 14.4c15.6 15.6 15.6 40.9 0 56.6l-29.4 29.4-71-71 29.4-29.4c15.6-15.6 40.9-15.6 56.6 0zM311.9 417L441.1 287.8l71 71L382.9 487.9c-4.1 4.1-9.2 7-14.9 8.4l-60.1 15c-5.5 1.4-11.2-.2-15.2-4.2s-5.6-9.7-4.2-15.2l15-60.1c1.4-5.6 4.3-10.8 8.4-14.9z" />
                                </svg><span class="ms-2 d-none d-sm-inline">Report Case</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-lg" aria-labelledby="dropdown">
                                <li><a class="dropdown-item" href="addBiteCase.php">Report Bite Case</a></li>
                                <li><a class="dropdown-item" href="addDeathCase.php">Report Death Case</a></li>
                                <li><a class="dropdown-item" href="reportRabidBao.php">Report Rabid Case</a></li>
                            </ul>
                        </li> --> 
                        <!-- <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle text-decoration-none text-dark px-sm-0 px-1" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <!-- <path d="M448 160H320V128H448v32zM48 64C21.5 64 0 85.5 0 112v64c0 26.5 21.5 48 48 48H464c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48H48zM448 352v32H192V352H448zM48 288c-26.5 0-48 21.5-48 48v64c0 26.5 21.5 48 48 48H464c26.5 0 48-21.5 48-48V336c0-26.5-21.5-48-48-48H48z" />
                                </svg><span class="ms-2 d-none d-sm-inline">Manage</span>
                            </a> -->
                            <!-- <ul class="dropdown-menu dropdown-menu-dark text-lg " aria-labelledby="dropdown">
                                <li><a class="dropdown-item" href="./dashboard1.php?active-tab=1">Manage Resident</a></li>
                                <li><a class="dropdown-item" href="./dashboard1pet.php?active-tab=1">Manage Pet</a></li>
                                <li><a class="dropdown-item" href="./dashboardBiteCases.php?active-tab=1">Manage Bite Cases</a></li>
                                <li><a class="dropdown-item" href="./dashboardRabidCases.php?active-tab=1">Manage Suspected Cases</a></li>
                                <li><a class="dropdown-item" href="./dashboardDeathCases.php?active-tab=1">Manage Death Cases</a></li>
                            </ul>
                        </li> -->
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
                            <form method="post" action="./tabular.php?active-tab=1" style="display: inline;">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="userType" value="<?php echo $userType; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <button type="submit" data-bs-toggle="collapse" class="nav-link text-dark px-sm-0 px-2"> <svg xmlns="http://www.w3.org/2000/svg" height="20" width="15" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128z" />
                                    </svg><span class="ms-2 d-none d-sm-inline"> Reports</span></button>
                            </form>
                        </li>

                        <li class="nav-item">
                            <form method="post" action="logout.php" style="display: inline;">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="userType" value="<?php echo $userType; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <button type="submit" class="nav-link text-dark px-sm-0 px-2">
                                    <i class="bi bi-arrow-left"></i> 
                                    <span class="ms-2 d-none d-sm-inline"> Log-out</span>
                                </button>
                            </form>
                        </li>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">


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

                        <!-- <li class="nav-item">
                            <form method="post" action="createAccForResident.php" style="display: inline;">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>"> -->
                                <!-- <button type="submit" data-bs-toggle="collapse" class="nav-link text-dark px-sm-0 px-2"> <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <!-- <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                                    </svg><span class="ms-2 d-none d-sm-inline">Account for Resident</span></button>
                                </a>
                            </form>
                        </li> -->
                        <!-- <div class="dropdown py-sm-4 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
                            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" class="rounded-circle me-2 outline" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <!-- <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                                </svg>
                                <strong><span class="d-none d-sm-inline mx-1"> <?php echo isset($user['name']) ? $user['name'] : ''; ?> </span>
                                </strong>
                            </a> -->
                            <!-- <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </div> -->
                    </ul>
                </div>
            </div>
            <div class="col d-flex flex-column h-sm-200">
                <main class="row overflow-auto">
                    <div class="col-md-8 p-1 mt-2 my-auto mx-auto">
                        <div class="container mt-2 p-4"> 
<!-- <div class="container"> -->
  <!-- <div class="container mt-5"> -->
                    <form action="dashboardMAO.php">
                    <button value="Back" class="btn btn-primary">Back</button>
                    </form>
                      <h2>Reports</h2>
                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="registries-tab" data-toggle="tab" href="#registries" role="tab" aria-controls="registries" aria-selected="true">Registries</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="bites-tab" data-toggle="tab" href="#bites" role="tab" aria-controls="bites" aria-selected="false">Bites</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="death-tab" data-toggle="tab" href="#death" role="tab" aria-controls="death" aria-selected="false">Death</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="suspected-tab" data-toggle="tab" href="#suspected" role="tab" aria-controls="suspected" aria-selected="false">Suspected</a>
                        </li>
                      </ul>

                      <div class="tab-content" id="myTabContent">
                        <!-- Registries Tab -->
                        <div class="tab-pane fade show active" id="registries" role="tabpanel" aria-labelledby="registries-tab">
                          <form action="" method="GET" id="registriesForm">
                            <div class="form-group">
                              <label for="barangaySelectRegistries">Select Barangay:</label>
                              <select class="form-control" id="barangaySelectRegistries" name="barangay_registries" onchange="submitForm('registriesForm')">
                                <option value="0">Select Barangay</option>
                                <?php
                                // Database connection
                                $servername = "localhost";
                                $username = "root";
                                $password = "";
                                $dbname = "petstatvan";
                                $conn = new mysqli($servername, $username, $password, $dbname);
                                if ($conn->connect_error) {
                                  die("Connection failed: " . $conn->connect_error);
                                }
                                $sql = "SELECT * FROM barangay";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                  while($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["brgyID"] . "'>" . $row["barangay"] . "</option>";
                                  }
                                } else {
                                  echo "<option value>No barangays found</option>";
                                }
                                $conn->close();
                                ?>
                              </select>
                            </div>
                          </form>
                        <!-- Display registries data here -->
                        <div>
                        <?php
                            if (isset($_GET['barangay_registries'])) {
                                $selected_barangay = $_GET['barangay_registries'];

                                // Database connection
                                $conn = new mysqli($servername, $username, $password, $dbname);

                                // Check connection
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Query to count total registries in selected barangay for each pet type and sex
                                $count_query_dog = "SELECT COUNT(*) as total_dogs
                                    FROM resident AS r
                                    INNER JOIN pet AS p ON r.residentID = p.residentID
                                    WHERE p.status = 1 AND r.brgyID = ? AND p.petType = 0";
                                $stmt_count_dog = $conn->prepare($count_query_dog);
                                $stmt_count_dog->bind_param("i", $selected_barangay);
                                $stmt_count_dog->execute();
                                $result_count_dog = $stmt_count_dog->get_result();
                                $count_row_dog = $result_count_dog->fetch_assoc();
                                $total_dogs = $count_row_dog['total_dogs'];
                                $stmt_count_dog->close();

                                $count_query_cat = "SELECT COUNT(*) as total_cats
                                    FROM resident AS r
                                    INNER JOIN pet AS p ON r.residentID = p.residentID
                                    WHERE p.status = 1 AND r.brgyID = ? AND p.petType = 1";
                                $stmt_count_cat = $conn->prepare($count_query_cat);
                                $stmt_count_cat->bind_param("i", $selected_barangay);
                                $stmt_count_cat->execute();
                                $result_count_cat = $stmt_count_cat->get_result();
                                $count_row_cat = $result_count_cat->fetch_assoc();
                                $total_cats = $count_row_cat['total_cats'];
                                $stmt_count_cat->close();

                                // Pagination setup
                                $items_per_page = 7;

                                // Set total pages based on whether there is filtering by pet type or sex
                                if (isset($_GET['gender_filter']) && ($_GET['gender_filter'] == '0' || $_GET['gender_filter'] == '1')) {
                                    if (isset($_GET['sex_filter']) && ($_GET['sex_filter'] == '0' || $_GET['sex_filter'] == '1')) {
                                        $total_pages = ($_GET['sex_filter'] == '0') ? ceil($total_dogs / $items_per_page) : ceil($total_cats / $items_per_page);
                                    } else {
                                        $total_pages = ($_GET['gender_filter'] == '0') ? ceil($total_dogs / $items_per_page) : ceil($total_cats / $items_per_page);
                                    }
                                } else {
                                    $total_pages = ceil(($total_dogs + $total_cats) / $items_per_page);
                                }

                                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                $start_index = ($page - 1) * $items_per_page;

                                // Query to count total number of pets based on the year
                                $count_query_year = "SELECT COUNT(*) as total_pets
                                    FROM resident AS r
                                    INNER JOIN pet AS p ON r.residentID = p.residentID
                                    WHERE p.status = 1 AND r.brgyID = ?";

                                // Add the filter condition for year if selected
                                if (isset($_GET['year_filter']) && !empty($_GET['year_filter'])) {
                                    $count_query_year .= " AND YEAR(p.regDate) = ?";
                                }

                                $stmt_count_year = $conn->prepare($count_query_year);

                                // Define an array to hold the types of the parameters
                                $types = 'i'; // Start with one integer type for $selected_barangay

                                // Define an array to hold the values of the parameters
                                $params = array($selected_barangay);

                                // Add parameters and types based on filter conditions
                                if (isset($_GET['year_filter']) && !empty($_GET['year_filter'])) {
                                    $types .= 'i'; // Add an integer type for year_filter
                                    $params[] = $_GET['year_filter']; // Add the value of year_filter to the params array
                                }

                                // Combine the types into a string
                                $types_string = implode('', str_split($types));

                                // Bind the parameters dynamically
                                $stmt_count_year->bind_param($types_string, ...$params);

                                $stmt_count_year->execute();
                                $result_count_year = $stmt_count_year->get_result();
                                $count_row_year = $result_count_year->fetch_assoc();
                                $total_pets = $count_row_year['total_pets'];
                                $stmt_count_year->close();

                                // Calculate total pages based on the total number of pets and items per page
                                $total_pages = ceil($total_pets / $items_per_page);

                                // Query to fetch registries data for the selected barangay with pagination and pet type/sex filter
                                $sql = "SELECT p.*, r.*, v.*, b.*, p.petID
                                    FROM resident AS r
                                    NATURAL JOIN pet AS p
                                    LEFT JOIN (
                                        SELECT petID, MAX(lastVaccination) AS maxlastVaccination, lastVaccination
                                        FROM vaccination
                                        GROUP BY petID
                                    ) AS v ON p.petID = v.petID
                                    LEFT JOIN barangay AS b ON r.brgyID = b.brgyID
                                    WHERE p.status = 1 AND r.brgyID = ?";

                                // Add the filter condition for pet type if selected
                                if (isset($_GET['gender_filter']) && ($_GET['gender_filter'] == '0' || $_GET['gender_filter'] == '1')) {
                                    $sql .= " AND p.petType = ?";
                                }

                                // Add the filter condition for sex if selected
                                if (isset($_GET['sex_filter']) && ($_GET['sex_filter'] == '0' || $_GET['sex_filter'] == '1')) {
                                    $sql .= " AND p.sex = ?";
                                }

                                // Add the filter condition for year if selected
                                if (isset($_GET['year_filter']) && !empty($_GET['year_filter'])) {
                                    $sql .= " AND YEAR(p.regDate) = ?";
                                }

                                // Add the filter condition for vaccination status if selected
                                if (isset($_GET['vaccination_filter']) && ($_GET['vaccination_filter'] == '0' || $_GET['vaccination_filter'] == '1')) {
                                    $sql .= " AND v.maxlastVaccination IS " . ($_GET['vaccination_filter'] == '0' ? "NOT NULL" : "NULL");
                                }

                                $sql .= " ORDER BY p.petID DESC LIMIT ?, ?";

                                $stmt = $conn->prepare($sql);

                                // Define an array to hold the types of the parameters
                                $types = 'i'; // Start with one integer type for $selected_barangay

                                // Define an array to hold the values of the parameters
                                $params = array($selected_barangay);

                                // Add parameters and types based on filter conditions
                                if (isset($_GET['gender_filter']) && ($_GET['gender_filter'] == '0' || $_GET['gender_filter'] == '1')) {
                                    $types .= 'i'; // Add an integer type for gender_filter
                                    $params[] = $_GET['gender_filter']; // Add the value of gender_filter to the params array
                                }

                                if (isset($_GET['sex_filter']) && ($_GET['sex_filter'] == '0' || $_GET['sex_filter'] == '1')) {
                                    $types .= 'i'; // Add an integer type for sex_filter
                                    $params[] = $_GET['sex_filter']; // Add the value of sex_filter to the params array
                                }

                                if (isset($_GET['year_filter']) && !empty($_GET['year_filter'])) {
                                    $types .= 'i'; // Add an integer type for year_filter
                                    $params[] = $_GET['year_filter']; // Add the value of year_filter to the params array
                                }

                                // Add integer types for start_index and items_per_page
                                $types .= 'ii';

                                // Add start_index and items_per_page to the params array
                                $params[] = $start_index;
                                $params[] = $items_per_page;

                                // Combine the types into a string
                                $types_string = implode('', str_split($types));

                                // Bind the parameters dynamically
                                $stmt->bind_param($types_string, ...$params);

                                $stmt->execute();
                                $result = $stmt->get_result();

                                // Display table
                                // Display select filtering for gender
                                echo "<form action='tabular.php' method='GET' id='genderFilterForm'>";
                                echo "<div class='filter-row'>";
                                echo "<div class='filter-item'>";
                                echo "<select class='form-control' id='genderSelect' name='gender_filter' onchange='submitForm(\"genderFilterForm\")'>";
                                echo "<option value='' ".(!isset($_GET['gender_filter']) ? 'selected' : '').">Select Species</option>";
                                echo "<option value='0' ".(isset($_GET['gender_filter']) && $_GET['gender_filter'] == '0' ? 'selected' : '').">Dog</option>";
                                echo "<option value='1' ".(isset($_GET['gender_filter']) && $_GET['gender_filter'] == '1' ? 'selected' : '').">Cat</option>";
                                echo "</select>";
                                echo "</div>"; // End of filter-item div
                                
                                echo "<div class='filter-item'>";
                                echo "<select class='form-control' id='sexSelect' name='sex_filter' onchange='submitForm(\"genderFilterForm\")'>";
                                echo "<option value='' ".(!isset($_GET['sex_filter']) ? 'selected' : '').">Select Sex</option>";
                                echo "<option value='0' ".(isset($_GET['sex_filter']) && $_GET['sex_filter'] == '0' ? 'selected' : '').">Male</option>";
                                echo "<option value='1' ".(isset($_GET['sex_filter']) && $_GET['sex_filter'] == '1' ? 'selected' : '').">Female</option>";
                                echo "</select>";
                                echo "</div>"; // End of filter-item div
                                
                                // Display select filtering for vaccination status
                                echo "<div class='filter-item'>";
                                echo "<select class='form-control' id='vaccinationSelect' name='vaccination_filter' onchange='submitForm(\"genderFilterForm\")'>";
                                echo "<option value='' ".(!isset($_GET['vaccination_filter']) ? 'selected' : '').">Select Vaccination Status</option>";
                                echo "<option value='0' ".(isset($_GET['vaccination_filter']) && $_GET['vaccination_filter'] == '0' ? 'selected' : '').">Vaccinated</option>";
                                echo "<option value='1' ".(isset($_GET['vaccination_filter']) && $_GET['vaccination_filter'] == '1' ? 'selected' : '').">Unvaccinated</option>";
                                echo "</select>";
                                echo "</div>"; // End of filter-item div
                                
                                echo "<div class='filter-item'>";
                                // Display select filtering for year
                                echo "<select class='form-control' id='yearSelect' name='year_filter' onchange='submitForm(\"genderFilterForm\")'>";
                                echo "<option value='' ".(!isset($_GET['year_filter']) ? 'selected' : '').">Select Year of Registry</option>";
                                for ($year = date("Y"); $year >= 2016; $year--) {
                                    echo "<option value='".$year."' ".(isset($_GET['year_filter']) && $_GET['year_filter'] == $year ? 'selected' : '').">".$year."</option>";
                                }
                                echo "</select>";              
                                echo "</div>"; // End of filter-item div
                                
                                echo "<input type='hidden' name='barangay_registries' value='" . $selected_barangay . "'>";
                                echo "</div>"; // End of filter-row div
                                echo "</form>";
                                
                                echo "<table class='table'>";
                                // Table headers
                                echo "<thead>
                                      <tr>
                                          <th>Owner's Name</th>
                                          <th>Date of Registry</th>
                                          <th>Species</th>
                                          <th>Name of Pet</th>
                                          <th>Sex</th>
                                          <th>Age</th>
                                          <th>Neutering</th>
                                          <th>Color</th>
                                          <th>Vaccination Status</th>
                                          <th>Last Vaccination</th>
                                          <th>Latest Vaccination</th>
                                          <th>Address</th>
                                      </tr>
                                  </thead>";
                                // Table body
                                echo "<tbody>";
                                while ($row = $result->fetch_assoc()) {
                                  echo "<tr>
                                      <td>" . $row["name"] . "</td>
                                      <td>";
                                      $input_date = $row['regDate'];
                                      $date_obj = new DateTime($input_date);
                                      $formatted_date = $date_obj->format("F j Y");
                                      echo $formatted_date . "</td>
                                      <td>" . ($row["petType"] == 0 ? 'Dog' : 'Cat') . "</td>
                                      <td>" . $row["pname"] . "</td>
                                      <td>" . ($row["sex"] == 0 ? 'Male' : 'Female') . "</td>
                                      <td>" . $row["age"] . "</td>
                                      <td>" . ($row["Neutering"] == 0 ? 'Neutered' : 'Not Neutered') . "</td>
                                      <td>" . $row["color"] . "</td>
                                      <td>" . ($row["statusVac"] == 0 ? 'Vaccinated' : 'Unvaccinated') . "</td>
                                      <td>";
                                      $input_date = $row['lastVaccination'];
                                      $date_obj = new DateTime($input_date);
                                      $formatted_date = $date_obj->format("F j Y");
                                      echo $formatted_date . "</td>
                                      <td>";
                                      $input_date = $row['currentVac'];
                                      $date_obj = new DateTime($input_date);
                                      $formatted_date = $date_obj->format("F j Y");
                                      echo $formatted_date . "</td>                    <td>" . $row["barangay"] . "</td>
                                  </tr>";
                                }
                                echo "</tbody></table>";
                                // Pagination links
                                echo '<div class="d-flex justify-content-center mt-4">
                                      <ul class="pagination">';
                                for ($b = 1; $b <= $total_pages; $b++) {
                                  echo '<li class="page-item ' . (($b == $page) ? 'active' : '') . '">
                                          <a class="page-link" href="tabular.php?barangay_registries=' . $selected_barangay . '&page=' . $b . (isset($_GET['gender_filter']) ? '&gender_filter=' . $_GET['gender_filter'] : '') . '&sex_filter=' . (isset($_GET['sex_filter']) ? $_GET['sex_filter'] : '') . (isset($_GET['year_filter']) ? '&year_filter=' . $_GET['year_filter'] : '') . (isset($_GET['vaccination_filter']) ? '&vaccination_filter=' . $_GET['vaccination_filter'] : '') . '">' . $b . '</a>
                                        </li>';
                                }
                                echo '</ul></div>';
                                echo '<button onclick="RegistriesExport()" class="btn btn-sm btn-primary">Export</button>';

                                // Close statement
                                $stmt->close();

                                // Close database connection
                                $conn->close();
                                } else {
                                echo "<p>No barangay selected</p>";
                            }
                            ?>
                            
                            </div>
                            </div>
                  <script>
                      function RegistriesExport() {
                          // Fetch data from the table
                          const rows = document.querySelectorAll("table tbody tr");
                          const data = [];
                          rows.forEach(row => {
                              const rowData = [];
                              row.querySelectorAll("td").forEach(cell => {
                                  rowData.push(cell.textContent.trim());
                              });
                              data.push(rowData);
                          });

                          // Add headers to the data array
                          const headers = ["Owner's Name", "Date of Registry", "Species", "Pet's Name", "Sex", "Age", "Neutering", "Color", "Vaccination Status", "Last Vaccination", "Current Vaccination", "Address"];
                          data.unshift(headers);

                          // Convert the data to CSV format
                          const csvContent = data.map(row => row.join(',')).join('\n');

                          // Create a Blob containing the CSV data
                          const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });

                          // Create a link element to trigger the download
                          const link = document.createElement('a');
                          link.href = URL.createObjectURL(blob);
                          link.setAttribute('download', 'Registries.csv');
                          document.body.appendChild(link);

                          // Trigger the click event on the link to initiate the download
                          link.click();

                          // Remove the link element
                          document.body.removeChild(link);
                      }
                  </script>



                        <!-- Bites Tab -->
                        <div class="tab-pane fade" id="bites" role="tabpanel" aria-labelledby="bites-tab">
                          <form action="" method="GET" id="bitesForm">
                            <div class="form-group">
                              <label for="barangaySelectBites">Select Barangay:</label>
                              <select class="form-control" id="barangaySelectBites" name="barangay_bites" onchange="submitForm('bitesForm')">
                                <option value="0">Select Barangay</option>
                                <?php
                                // Database connection
                                $servername = "localhost";
                                $username = "root";
                                $password = "";
                                $dbname = "petstatvan";
                                $conn = new mysqli($servername, $username, $password, $dbname);
                                if ($conn->connect_error) {
                                  die("Connection failed: " . $conn->connect_error);
                                }
                                $sql = "SELECT * FROM barangay";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                  while($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["brgyID"] . "'>" . $row["barangay"] . "</option>";
                                  }
                                } else {
                                  echo "<option value>No barangays found</option>";
                                }
                                $conn->close();
                                ?>
                              </select>
                            </div>
                          </form>
                        <!-- Display bites data here -->
                        <div >
                        <?php
                      // Initialize an empty array to store data for export
                      $export_data = array();

                      if(isset($_GET['barangay_bites'])) {
                          $selected_barangay = $_GET['barangay_bites'];

                          // Database connection
                          $conn = new mysqli($servername, $username, $password, $dbname);

                          // Check connection
                          if ($conn->connect_error) {
                              die("Connection failed: " . $conn->connect_error);
                          }

                                // Pagination setup
                                $items_per_page = 7;
                                $page = isset($_GET['page_bite']) ? $_GET['page_bite'] : 1;
                                $start_index = ($page - 1) * $items_per_page;

                                // Query to count total bites in selected barangay
                                $count_query = "SELECT COUNT(*) as total FROM `case` WHERE caseStatus = 1 AND caseType = 0 AND brgyID = ?";
                                $stmt_count = $conn->prepare($count_query);
                                $stmt_count->bind_param("i", $selected_barangay);
                                $stmt_count->execute();
                                $result_count = $stmt_count->get_result();
                                $count_row = $result_count->fetch_assoc();
                                $total_bites = $count_row['total'];
                                $stmt_count->close();

                                // Calculate total pages
                                $total_pages = ceil($total_bites / $items_per_page);
                                // Ensure that total_pages is at least 1
                                $total_pages = max(1, $total_pages);

                                // Construct the main query
                                $sql = "SELECT c.*, p.*, r.*, b.*
                                        FROM `case` AS c
                                        INNER JOIN pet AS p ON c.petID = p.petID
                                        INNER JOIN resident AS r ON p.residentID = r.residentID
                                        INNER JOIN barangay AS b ON c.brgyID = b.brgyID
                                        WHERE c.caseStatus = 1 AND c.caseType = 0 AND c.brgyID = ?";

                                // Array to store filter conditions
                                $filter_conditions = array();
                                $types = "i";
                                $params = array($selected_barangay);

                                // Add filter conditions
                                if(isset($_GET['species_filter']) && $_GET['species_filter'] !== '') {
                                    $filter_conditions[] = "p.petType = ?";
                                    $params[] = $_GET['species_filter'];
                                    $types .= "i";
                                }
                                if(isset($_GET['vaccination_filter']) && $_GET['vaccination_filter'] !== '') {
                                    $filter_conditions[] = "p.statusVac = ?";
                                    $params[] = $_GET['vaccination_filter'];
                                    $types .= "i";
                                }
                                if(isset($_GET['body_part_filter']) && $_GET['body_part_filter'] !== '') {
                                    $filter_conditions[] = "c.bpartBitten = ?";
                                    $params[] = $_GET['body_part_filter'];
                                    $types .= "i";
                                }
                                if(isset($_GET['year_filter']) && $_GET['year_filter'] !== '') {
                                    $filter_conditions[] = "YEAR(c.date) = ?";
                                    $params[] = $_GET['year_filter'];
                                    $types .= "i";
                                }

                                // Add filter conditions to the main query
                                if (!empty($filter_conditions)) {
                                    $sql .= " AND " . implode(" AND ", $filter_conditions);
                                }

                                $sql .= " ORDER BY c.date DESC LIMIT ?, ?";
                                $stmt = $conn->prepare($sql);

                                // Bind parameters
                                $types .= "ii";
                                $params[] = $start_index;
                                $params[] = $items_per_page;
                                $stmt->bind_param($types, ...$params);

                                $stmt->execute();
                                $result = $stmt->get_result();


                                // Display select options for filtering
                            echo "<form action='tabular.php' method='GET' id='filterForm'>";
                            echo "<div class='filter-row'>";

                            // Species filter
                            echo "<div class='filter-item'>";
                            echo "<select class='form-control' id='speciesSelect' name='species_filter' onchange='document.getElementById(\"filterForm\").submit()'>";
                            echo "<option value='' ".(!isset($_GET['species_filter']) ? 'selected' : '').">Select Species</option>";
                            echo "<option value='0' ".(isset($_GET['species_filter']) && $_GET['species_filter'] == '0' ? 'selected' : '').">Dog</option>";
                            echo "<option value='1' ".(isset($_GET['species_filter']) && $_GET['species_filter'] == '1' ? 'selected' : '').">Cat</option>";
                            echo "</select>";
                            echo "</div>"; // End of species filter item

                            // Vaccination status filter
                            echo "<div class='filter-item'>";
                            echo "<select class='form-control' id='vaccinationSelect' name='vaccination_filter' onchange='document.getElementById(\"filterForm\").submit()'>";
                            echo "<option value='' ".(!isset($_GET['vaccination_filter']) ? 'selected' : '').">Select Vaccination Status</option>";
                            echo "<option value='0' ".(isset($_GET['vaccination_filter']) && $_GET['vaccination_filter'] == '0' ? 'selected' : '').">Vaccinated</option>";
                            echo "<option value='1' ".(isset($_GET['vaccination_filter']) && $_GET['vaccination_filter'] == '1' ? 'selected' : '').">Unvaccinated</option>";
                            echo "</select>";
                            echo "</div>"; // End of vaccination status filter item

                            // Body part bitten filter
                            echo "<div class='filter-item'>";
                            echo "<select class='form-control' id='bodyPartSelect' name='body_part_filter' onchange='document.getElementById(\"filterForm\").submit()'>";
                            echo "<option value='' ".(!isset($_GET['body_part_filter']) ? 'selected' : '').">Select Body Part Bitten</option>";
                            echo "<option value='0' ".(isset($_GET['body_part_filter']) && $_GET['body_part_filter'] == '0' ? 'selected' : '').">Head and Neck Area</option>";
                            echo "<option value='1' ".(isset($_GET['body_part_filter']) && $_GET['body_part_filter'] == '1' ? 'selected' : '').">Thorax Area</option>";
                            echo "<option value='2' ".(isset($_GET['body_part_filter']) && $_GET['body_part_filter'] == '2' ? 'selected' : '').">Abdomen Area</option>";
                            echo "<option value='3' ".(isset($_GET['body_part_filter']) && $_GET['body_part_filter'] == '3' ? 'selected' : '').">Upper Extremity Area</option>";
                            echo "<option value='4' ".(isset($_GET['body_part_filter']) && $_GET['body_part_filter'] == '4' ? 'selected' : '').">Lower Extremity Area</option>";
                            echo "</select>";
                            echo "</div>"; // End of body part bitten filter item

                            // Year filter
                            echo "<div class='filter-item'>";
                            echo "<select class='form-control' id='yearSelect' name='year_filter' onchange='document.getElementById(\"filterForm\").submit()'>";
                            echo "<option value='' ".(!isset($_GET['year_filter']) ? 'selected' : '').">Date Occured</option>";
                            for ($year = date("Y"); $year >= 2016; $year--) {
                                echo "<option value='".$year."' ".(isset($_GET['year_filter']) && $_GET['year_filter'] == $year ? 'selected' : '').">".$year."</option>";
                            }
                            echo "</select>";
                            echo "</div>"; // End of year filter item

                            echo "<input type='hidden' name='barangay_bites' value='".$selected_barangay."' />";
                            echo "</div>"; // End of filter row
                            echo "</form>";


                            // <?php
                            if ($result->num_rows > 0) {
                                // Add column titles to export data
                                $export_data[] = array(
                                    'Victim',
                                    'Species',
                                    "Pet's Name",
                                    "Owner's Name",
                                    'Date Occurred',
                                    'Address',
                                    'Vaccination Status',
                                    'Body Part Bitten',
                                    'Description'
                                );
                            
                                // Output the title
                                echo "<h1>Municipal Agriculture Office</h1>";
                            
                                // Output table
                                echo "<table class='table'>";
                                // Table headers
                                echo "<thead>
                                        <tr>
                                            <th>Victim's Name</th>
                                            <th>Species</th>
                                            <th>Pet's Name</th>
                                            <th>Owner's Name</th>
                                            <th>Date Occurred</th>
                                            <th>Address</th>
                                            <th>Vaccination Status</th>
                                            <th>Body Part Bitten</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>";
                                // Table body
                                echo "<tbody>";
                                while ($row = $result->fetch_assoc()) {
                                    // Add row data to export_data array
                                    $input_date = $row['date'];
                                    $date_obj = new DateTime($input_date);
                                    $formatted_date = $date_obj->format("F j Y");
                            
                                    $export_row = array(
                                        $row["victimsName"],
                                        ($row["petType"] == 0 ? 'Dog' : 'Cat'),
                                        $row["pname"],
                                        $row["name"],
                                        $formatted_date, 
                                        $row["barangay"],
                                        ($row["statusVac"] == 0 ? 'Vaccinated' : 'Unvaccinated'),
                                        isset($bodyParts[$row["bpartBitten"]]) ? $bodyParts[$row["bpartBitten"]] : "Unknown",
                                        $row["description"]
                                    );
                            
                                    $export_data[] = $export_row;
                            
                            
                                    // Output the table row
                                    echo "<tr>
                                            <td>" . $row["victimsName"] . "</td>
                                            <td>" . ($row["petType"] == 0 ? 'Dog' : 'Cat') . "</td>
                                            <td>" . $row["pname"] . "</td>
                                            <td>" . $row["name"] . "</td>
                                            <td>";
                                            $input_date = $row['date'];
                                            $date_obj = new DateTime($input_date);
                                            $formatted_date = $date_obj->format("F j Y");
                                            echo $formatted_date . "</td>
                                            <td>" . $row["barangay"] . "</td>
                                            <td>" . ($row["statusVac"] == 0 ? 'Vaccinated' : 'Unvaccinated') . "</td>
                                            <td>";
                                    $bpartBitten = $row["bpartBitten"];
                                    $bodyParts = [
                                        0 => "Head and Neck Area",
                                        1 => "Thorax Area",
                                        2 => "Abdomen Area",
                                        3 => "Upper Extremity Area",
                                        4 => "Lower Extremity Area"
                                    ];
                                    // Check if the numerical value exists in the $bodyParts array
                                    if (array_key_exists($bpartBitten, $bodyParts)) {
                                        echo $bodyParts[$bpartBitten];
                                    } else {
                                        echo "Unknown";
                                    }
                                    echo "</td>
                                            <td>" . $row["description"] . "</td>
                                        </tr>";
                                }
                                echo "</tbody></table>";
                            
                            
                                // Pagination links
                                echo '<div class="d-flex justify-content-center mt-4">
                                        <ul class="pagination">';
                                for ($b = 1; $b <= $total_pages; $b++) {
                                    echo '<li class="page-item ' . (($b == $page) ? 'active' : '') . '">
                                    <a class="page-link" href="tabular.php?barangay_bites=' . $selected_barangay . '&page_bite=' . $b;
                                    echo isset($_GET['species_filter']) ? '&species_filter=' . $_GET['species_filter'] : '';
                                    echo isset($_GET['vaccination_filter']) ? '&vaccination_filter=' . $_GET['vaccination_filter'] : '';
                                    echo isset($_GET['body_part_filter']) ? '&body_part_filter=' . $_GET['body_part_filter'] : '';
                                    echo isset($_GET['year_filter']) ? '&year_filter=' . $_GET['year_filter'] : '';
                                    echo '">' . $b . '</a>
                                    </li>';
                            
                                }
                                echo '</ul></div>';
                                echo '<button onclick="exportData()" class="btn btn-sm btn-primary">Export</button>';
                            } else {
                                echo "<p>No bites found in selected barangay</p>";
                            }
                            
                            // Close statement and database connection
                            $stmt->close();
                            $conn->close();
                            } else {
                                echo "<p>No barangay selected</p>";
                            }
                            ?>
                            
                            <script>
                                function exportData() {
                                    // Convert the data to CSV format
                                    const csvContent = <?php echo json_encode($export_data); ?>.map(row => row.join(',')).join('\n');
                            
                                    // Create a Blob containing the CSV data
                                    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                            
                                    // Create a link element to trigger the download
                                    const link = document.createElement('a');
                                    link.href = URL.createObjectURL(blob);
                                    link.setAttribute('download', 'Bites.csv');
                                    document.body.appendChild(link);
                            
                                    // Trigger the click event on the link to initiate the download
                                    link.click();
                            
                                    // Remove the link element
                                    document.body.removeChild(link);
                                }
                            </script>
                            
                        </div>
                        </div>

                        <!-- Death Tab -->
                        <div class="tab-pane fade" id="death" role="tabpanel" aria-labelledby="death-tab">
                          <form action="" method="GET" id="deathForm">
                            <div class="form-group">
                              <label for="barangaySelectDeath">Select Barangay:</label>
                              <select class="form-control" id="barangaySelectDeath" name="barangay_death" onchange="submitForm('deathForm')">
                                <option value="0">Select Barangay</option>
                                <?php
                                // Database connection
                                $servername = "localhost";
                                $username = "root";
                                $password = "";
                                $dbname = "petstatvan";
                                $conn = new mysqli($servername, $username, $password, $dbname);
                                if ($conn->connect_error) {
                                  die("Connection failed: " . $conn->connect_error);
                                }
                                $sql = "SELECT * FROM barangay";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                  while($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["brgyID"] . "'>" . $row["barangay"] . "</option>";
                                  }
                                } else {
                                  echo "<option value>No barangays found</option>";
                                }
                                $conn->close();
                                ?>
                              </select>
                            </div>
                          </form>
                          <!-- Display death data here -->
                          <div>
                          <?php
                      if(isset($_GET['barangay_death'])) {
                      $selected_barangay = $_GET['barangay_death'];

                      // Database connection
                      $conn = new mysqli($servername, $username, $password, $dbname);

                      // Check connection
                      if ($conn->connect_error) {
                          die("Connection failed: " . $conn->connect_error);
                      }

                      // Pagination setup
                      $items_per_page = 8;
                      $page = isset($_GET['page']) ? $_GET['page'] : 1;
                      $start_index = ($page - 1) * $items_per_page;

                      // Query to count total death records in selected barangay
                      $count_query = "SELECT COUNT(*) as total FROM `case` WHERE caseStatus = 1 AND caseType = 1 AND brgyID = ?";
                      $stmt_count = $conn->prepare($count_query);
                      $stmt_count->bind_param("i", $selected_barangay);
                      $stmt_count->execute();
                      $result_count = $stmt_count->get_result();
                      $count_row = $result_count->fetch_assoc();
                      $total_deaths = $count_row['total'];
                      $stmt_count->close();

                      // Calculate total pages
                      $total_pages = ceil($total_deaths / $items_per_page);

                      // Construct the base SQL query
                      $sql = "SELECT c.*, p.*, r.name, p.pname, b.barangay 
                              FROM `case` as c 
                              NATURAL JOIN pet as p 
                              NATURAL JOIN resident as r 
                              INNER JOIN barangay as b ON r.brgyID = b.brgyID 
                              WHERE c.caseStatus = 1 AND c.caseType = 1 AND c.brgyID = ?";

                      // Prepare an array to hold parameter types and values
                      $params = array("i", $selected_barangay);

                      // Add species filter to the query if provided
                      if(isset($_GET['species']) && ($_GET['species'] == '0' || $_GET['species'] == '1')) {
                          $sql .= " AND p.petType = ?";
                          $params[0] .= "i"; // Append parameter type
                          $params[] = $_GET['species']; // Append parameter value
                      }

                      // Add year filter to the query if provided
                      if(isset($_GET['year_filter']) && !empty($_GET['year_filter'])) {
                          $sql .= " AND YEAR(c.date) = ?";
                          $params[0] .= "s"; // Append parameter type
                          $params[] = $_GET['year_filter']; // Append parameter value
                      }

                      // Add pagination
                      $sql .= " ORDER BY c.date DESC LIMIT ?, ?";
                      $params[0] .= "ii"; // Append parameter types for pagination
                      $params[] = $start_index; // Append start index
                      $params[] = $items_per_page; // Append items per page

                      // Prepare and bind parameters
                      $stmt = $conn->prepare($sql);
                      $stmt->bind_param(...$params);
                      $stmt->execute();
                      $result = $stmt->get_result();

                      echo "<form action='tabular.php' method='GET' id='filterForm'>";
                      echo "<div class='filter-row'>";
                      echo "<div class='filter-item'>";
                      echo "<select class='form-control' id='speciesSelect' name='species' onchange='this.form.submit()'>";
                      echo "<option value='' ".(!isset($_GET['species']) ? 'selected' : '').">Select Species</option>";
                      echo "<option value='0' ".(isset($_GET['species']) && $_GET['species'] == '0' ? 'selected' : '').">Dog</option>";
                      echo "<option value='1' ".(isset($_GET['species']) && $_GET['species'] == '1' ? 'selected' : '').">Cat</option>";
                      echo "</select>";
                      echo "</div>"; // End of filter-item div

                      echo "<div class='filter-item'>";
                      echo "<select class='form-control' id='yearSelect' name='year_filter' onchange='this.form.submit()'>";
                      echo "<option value='' ".(!isset($_GET['year_filter']) ? 'selected' : '').">Select Year</option>";
                      for ($year = date("Y"); $year >= 2016; $year--) {
                          echo "<option value='".$year."' ".(isset($_GET['year_filter']) && $_GET['year_filter'] == $year ? 'selected' : '').">".$year."</option>";
                      }
                      echo "</select>";              
                      echo "</div>"; // End of filter-item div

                      echo "<input type='hidden' name='barangay_death' value='" . $selected_barangay . "'>";
                      echo "</div>"; // End of filter-row div
                      echo "</form>";
                      if ($result->num_rows > 0) {
                          echo "<table class='table'>";
                          echo "<thead>
                                  <tr>
                                      <th>Owner's Name</th>
                                      <th>Pet's Name</th>
                                      <th>Species</th>
                                      <th>Address</th>
                                      <th>Date Occurred</th>
                                      <th>Description</th>
                                  </tr>
                                </thead>";
                          echo "<tbody>";
                          while ($row = $result->fetch_assoc()) {
                              echo "<tr>
                                      <td>" . $row["name"] . "</td>
                                      <td>" . $row["pname"] . "</td>
                                      <td>" . ($row["petType"] == 0 ? 'Dog' : 'Cat') . "</td>
                                      <td>" . $row["barangay"] . "</td>
                                      <td>";
                                      $input_date = $row['date'];
                                      $date_obj = new DateTime($input_date);
                                      $formatted_date = $date_obj->format("F j Y");
                                      echo $formatted_date . "</td>
                                      <td>" . $row["description"] . "</td>;
                                  </tr>";
                          }
                          echo "</tbody></table>";
                      
                          // Pagination links
                          echo '<div class="d-flex justify-content-center mt-4">
                          <ul class="pagination">';
                          for ($b = 1; $b <= $total_pages; $b++) {
                              // Build the URL with existing filter parameters and the page number
                              $url = 'tabular.php?barangay_death=' . $selected_barangay . '&page=' . $b;
                              if(isset($_GET['species'])) {
                                  $url .= '&species=' . $_GET['species'];
                              }
                              if(isset($_GET['year_filter'])) {
                                  $url .= '&year_filter=' . $_GET['year_filter'];
                              }
                              echo '<li class="page-item ' . (($b == $page) ? 'active' : '') . '">
                                  <a class="page-link" href="' . $url . '">' . $b . '</a>
                                </li>';
                          }
                          echo '</ul></div>';
                          echo '<button onclick="DeathExport()" class="btn btn-sm btn-primary">Export</button>';
                      
                      } else {
                          echo "<p>No death records found in selected barangay</p>";
                      }
                      
                      // Close statement and database connection
                      $stmt->close();
                      $conn->close();
                      } else {
                          echo "<p>No barangay selected</p>";
                      }
                      ?>
                      
                      </div>
                      </div>
                      <script>
                      function DeathExport() {
                          // Fetch column titles from the table header
                          const columnTitles = Array.from(document.querySelectorAll("table thead th")).map(th => th.textContent.trim());
                      
                          // Fetch data from the table
                          const rows = document.querySelectorAll("table tbody tr");
                          const data = [];
                          rows.forEach(row => {
                              const rowData = [];
                              row.querySelectorAll("td").forEach(cell => {
                                  rowData.push(cell.textContent.trim());
                              });
                              data.push(rowData.join(","));
                          });
                      
                          // Prepend column titles to the data
                          data.unshift(columnTitles.join(","));
                      
                          // Create a Blob containing the CSV data
                          const csvContent = data.join("\n");
                          const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                      
                          // Create a link element to trigger the download
                          const link = document.createElement('a');
                          link.href = URL.createObjectURL(blob);
                          link.setAttribute('download', 'Death.csv');
                          document.body.appendChild(link);
                      
                          // Trigger the click event on the link to initiate the download
                          link.click();
                      
                          // Remove the link element
                          document.body.removeChild(link);
                      }
                      </script>
                      

                        <!-- Suspected Tab -->
                        <div class="tab-pane fade" id="suspected" role="tabpanel" aria-labelledby="suspected-tab">
                          <form action="" method="GET" id="suspectedForm">
                            <div class="form-group">
                              <label for="barangaySelectSuspected">Select Barangay:</label>
                              <select class="form-control" id="barangaySelectSuspected" name="barangay_suspected" onchange="submitForm('suspectedForm')">
                                <option value="0">Select Barangay</option>
                                <?php
                                // Database connection
                                $servername = "localhost";
                                $username = "root";
                                $password = "";
                                $dbname = "petstatvan";
                                $conn = new mysqli($servername, $username, $password, $dbname);
                                if ($conn->connect_error) {
                                  die("Connection failed: " . $conn->connect_error);
                                }
                                $sql = "SELECT * FROM barangay";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                  while($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["brgyID"] . "'>" . $row["barangay"] . "</option>";
                                  }
                                } else {
                                  echo "<option value>No barangays found</option>";
                                }
                                $conn->close();
                                ?>
                              </select>
                            </div>
                          </form>
                          <div >
                          <?php
                  if(isset($_GET['barangay_suspected'])) {
                      $selected_barangay = $_GET['barangay_suspected'];

                      // Database connection
                      $conn = new mysqli($servername, $username, $password, $dbname);

                      // Check connection
                      if ($conn->connect_error) {
                          die("Connection failed: " . $conn->connect_error);
                      }

                      // Pagination setup
                      $items_per_page = 8;
                      $page = isset($_GET['page']) ? $_GET['page'] : 1;
                      $start_index = ($page - 1) * $items_per_page;

                      // Construct the base SQL query
                      $sql = "SELECT c.*, p.*, r.*, b.* 
                              FROM pet AS p
                              INNER JOIN resident AS r ON p.residentID = r.residentID
                              INNER JOIN `case` AS c ON c.petID = p.petID
                              INNER JOIN barangay AS b ON c.brgyID = b.brgyID
                              WHERE c.caseStatus = 1 AND c.caseType = 2 AND c.brgyID = ?";

                      // Prepare an array to hold parameter types and values
                      $params = array("i", $selected_barangay);

                      // Add species filter to the query if provided
                      if(isset($_GET['species']) && ($_GET['species'] == '0' || $_GET['species'] == '1')) {
                          $sql .= " AND p.petType = ?";
                          $params[0] .= "i"; // Append parameter type
                          $params[] = $_GET['species']; // Append parameter value
                      }

                      // Add year filter to the query if provided
                      if(isset($_GET['year_filter']) && !empty($_GET['year_filter'])) {
                          $sql .= " AND YEAR(c.date) = ?";
                          $params[0] .= "s"; // Append parameter type
                          $params[] = $_GET['year_filter']; // Append parameter value
                      }

                      // Execute the SQL query
                      $stmt = $conn->prepare($sql);
                      $stmt->bind_param(...$params);
                      $stmt->execute();
                      $result = $stmt->get_result();

                      ?>
                      <form action="tabular.php" method="GET" id="filterForm">
                          <div class="filter-row">
                              <div class="filter-item">
                                  <select class="form-control" id="speciesSelect" name="species" onchange="this.form.submit()">
                                      <option value="" <?php echo (!isset($_GET['species']) ? 'selected' : ''); ?>>Select Species</option>
                                      <option value="0" <?php echo (isset($_GET['species']) && $_GET['species'] == '0' ? 'selected' : ''); ?>>Dog</option>
                                      <option value="1" <?php echo (isset($_GET['species']) && $_GET['species'] == '1' ? 'selected' : ''); ?>>Cat</option>
                                  </select>
                              </div> <!-- End of filter-item div -->

                              <div class="filter-item">
                                  <select class="form-control" id="yearSelect" name="year_filter" onchange="this.form.submit()">
                                      <option value="" <?php echo (!isset($_GET['year_filter']) ? 'selected' : ''); ?>>Select Year</option>
                                      <?php
                                      for ($year = date("Y"); $year >= 2016; $year--) {
                                          echo "<option value='".$year."' ".(isset($_GET['year_filter']) && $_GET['year_filter'] == $year ? 'selected' : '').">".$year."</option>";
                                      }
                                      ?>
                                  </select>
                              </div> <!-- End of filter-item div -->

                              <input type="hidden" name="barangay_suspected" value="<?php echo $selected_barangay; ?>">
                          </div> <!-- End of filter-row div -->
                      </form>
                      <?php

                      // Pagination
                      // <?php
                      if ($result->num_rows > 0) {
                          // Count total pages
                          $total_pages = ceil($result->num_rows / $items_per_page);
                      
                          // Output table
                          echo "<table class='table'>";
                          echo "<thead>
                                  <tr>
                                      <th>Owner's Name</th>
                                      <th>Pet's Name</th>
                                      <th>Species</th>
                                      <th>Address</th>
                                      <th>Date Spotted</th>
                                      <th>Description</th>
                                      <th>Rabies</th>
                                  </tr>
                              </thead>";
                          echo "<tbody>";
                      
                          // Move the pointer to the start index
                          $result->data_seek($start_index);
                      
                          // Fetch records for the current page
                          $count = 0;
                          $data = array(); // Array to hold the data for export
                          while ($count < $items_per_page && $row = $result->fetch_assoc()) {
                              echo '<tr>';
                              echo '<td>' . $row['name'] . '</td>';
                              echo '<td>' . $row['pname'] . '</td>';
                              echo '<td>' . ($row["petType"] == 0 ? 'Dog' : 'Cat') . '</td>';
                              echo '<td>' . $row['barangay'] . '</td>';
                              $input_date = $row['date'];
                              $date_obj = new DateTime($input_date);
                              $formatted_date = $date_obj->format("F j Y");
                              echo '<td>' . $formatted_date . '</td>';
                              echo '<td>' . $row['description'] . '</td>';
                              echo '<td>' . ($row['confirmedRabies'] == 0 ? 'No' : 'Yes') . '</td>';
                              echo '</tr>';
                              
                              // Add row data to the export array
                              $data[] = array(
                                  $row['name'],
                                  $row['pname'],
                                  ($row["petType"] == 0 ? 'Dog' : 'Cat'),
                                  $row['barangay'],
                                  $formatted_date,
                                  $row['description'],
                                  ($row['confirmedRabies'] == 0 ? 'No' : 'Yes')
                              );
                      
                              $count++;
                          }
                          echo "</tbody></table>";
                      
                          // Pagination links
                          echo '<div class="d-flex justify-content-center mt-4">
                          <ul class="pagination">';
                            for ($b = 1; $b <= $total_pages; $b++) {
                                // Build the URL with existing filter parameters and the page number
                                $url = 'tabular.php?barangay_suspected=' . $selected_barangay . '&page=' . $b;
                                if(isset($_GET['species'])) {
                                    $url .= '&species=' . $_GET['species'];
                                }
                                if(isset($_GET['year_filter'])) {
                                    $url .= '&year_filter=' . $_GET['year_filter'];
                                }
                                echo '<li class="page-item ' . (($b == $page) ? 'active' : '') . '">
                                        <a class="page-link" href="' . $url . '">' . $b . '</a>
                                      </li>';
                            }
                            echo '</ul></div>';
                            echo '<button onclick="SusExport()" class="btn btn-sm btn-primary">Export</button>';
                      
                      } else {
                          echo "<p>No suspected records found in selected barangay</p>";
                      }
                      
                      // Close statement and database connection
                      $stmt->close();
                      $conn->close();
                      } else {
                          echo "<p>No barangay selected</p>";
                      }
                      ?>
                      
                      
                      </div>
                      
                            </div>
                        </div>
                      <script>
                        function SusExport() {
                      // Fetch column titles from the table header
                      const columnTitles = Array.from(document.querySelectorAll("table thead th")).map(th => th.textContent.trim());

                      // Fetch data from the table body
                      const rows = Array.from(document.querySelectorAll("table tbody tr")).map(row => {
                          // Fetch text content from each cell in the row
                          return Array.from(row.querySelectorAll("td")).map(cell => cell.textContent.trim());
                      });

                      // Combine the column titles and rows into a single array for CSV export
                      const data = [columnTitles, ...rows];

                      // Convert the data to CSV format
                      const csvContent = data.map(row => row.join(',')).join('\n');

                      // Create a Blob containing the CSV data
                      const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });

                      // Create a link element to trigger the download
                      const link = document.createElement('a');
                      link.href = URL.createObjectURL(blob);
                      link.setAttribute('download', 'Suspected.csv');
                      document.body.appendChild(link);

                      // Trigger the click event on the link to initiate the download
                      link.click();

                      // Remove the link element
                      document.body.removeChild(link);
                  }

                      </script>
                      </div>

                    <!-- Bootstrap JS and jQuery (optional) -->
                    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

                    <script>
                      function submitForm(formId) {
                          document.getElementById(formId).submit();
                      }

                      // JavaScript to redirect to the appropriate tab and selected barangay after form submission
                      window.onload = function() {
                          // Check if there is a selected barangay for bites
                          <?php if(isset($_GET['barangay_bites'])) { ?>
                              // Redirect to the bites tab and selected barangay
                              document.getElementById('bites-tab').click();
                          <?php } ?>

                          // Check if there is a selected barangay for death
                          <?php if(isset($_GET['barangay_death'])) { ?>
                              // Redirect to the death tab and selected barangay
                              document.getElementById('death-tab').click();
                          <?php } ?>

                          // Check if there is a selected barangay for suspected cases
                          <?php if(isset($_GET['barangay_suspected'])) { ?>
                              // Redirect to the suspected tab and selected barangay
                              document.getElementById('suspected-tab').click();
                          <?php } ?>
                      }
                  </script>

                  </body>
                  </html>
