<?php
session_start();
require_once("class/cases.php");
require_once("class/barangay.php");

// Check if the user is logged in and has admin privileges (userType = 1)
if (!isset($_SESSION['user']) || $_SESSION['user']['userType'] != 1) {
    header("Location: login.php");
    exit();
}

$brgyID = isset($_SESSION['user']['brgyID']) ? $_SESSION['user']['brgyID'] : '';

$barangay = new Barangay();
$result1 = $barangay->getBrgyName($brgyID);

// Handle form submission1
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["verify"]) || isset($_POST["reject"])) {
        $caseID = $_POST["caseID"];
        $caseStatus = isset($_POST["verify"]) ? 1 : 2; // 1 for verified, 2 for not verified

        $case = new Cases();
        $result = $case->updateDeathCaseStatus($caseID, $caseStatus);

        if ($result === true) {
            // Successfully updated pet status
            echo '<script>alert("Bite Case status updated successfully.");</script>';
        } else {
            // Failed to update Bite Case status
            echo "Failed to update Bite Case status: " . $result;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Death Cases</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 30px;
        }

        .tab-content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .nav-link {
            color: #007bff;
        }

        .nav-link.active {
            color: #ffffff;
            background-color: #007bff;
        }

        .btn-accept {
            background-color: #28a745;
            color: #ffffff;
        }

        .btn-reject {
            background-color: #dc3545;
            color: #ffffff;
        }

        .btn-manage {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Manage Death Cases for Barangay: <?php echo $result1 ?></h1>
        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#newDeathCase" data-bs-toggle="tab">New Death Cases</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#validDeathCase" data-bs-toggle="tab">Valid Death Cases</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#rejectedDeathCase" data-bs-toggle="tab">Rejected Death Cases</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- New Bite Cases Tab -->
            <div class="tab-pane fade show active" id="newDeathCase">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pet Name</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $case = new Cases();
                        $cases = $case->getAllNewDeathCase($brgyID);

                        while ($row = $cases->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['pname'] . '</td>';
                            $input_date = $row['date'];

                            // Convert the input date to a DateTime object
                            $date_obj = new DateTime($input_date);

                            // Format the date as "Month Day, Year"
                            $formatted_date = $date_obj->format("F j, Y");

                            // Print the formatted date
                            echo '<td>' . $formatted_date . '</td>';
                            echo '<td>
                                    <form method="post" action="dashboardDeathCases.php">
                                        <input type="hidden" name="caseID" value="' . $row['caseID'] . '">
                                        <button type="submit" name="verify" class="btn btn-accept">Accept</button>
                                        <button type="submit" name="reject" class="btn btn-reject">Reject</button>
                                    </form>
                                </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- Valid Bite Cases Tab -->
            <div class="tab-pane fade" id="validDeathCase">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pet Name</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $case = new Cases();
                        $cases = $case->getAllValidDeathCase($brgyID);

                        while ($row = $cases->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['pname'] . '</td>';
                            // Input date as a string
                            $input_date = $row['date'];

                            // Convert the input date to a DateTime object
                            $date_obj = new DateTime($input_date);

                            // Format the date as "Month Day, Year"
                            $formatted_date = $date_obj->format("F j, Y");

                            // Print the formatted date
                            echo '<td>' . $formatted_date . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- Rejected Bite Cases Tab -->
            <div class="tab-pane fade" id="rejectedDeathCase">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pet Name</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $case = new Cases();
                        $cases = $case->getAllRejectedDeathCase($brgyID);

                        while ($row = $cases->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['pname'] . '</td>';
                            $input_date = $row['date'];

                            // Convert the input date to a DateTime object
                            $date_obj = new DateTime($input_date);

                            // Format the date as "Month Day, Year"
                            $formatted_date = $date_obj->format("F j, Y");

                            // Print the formatted date
                            echo '<td>' . $formatted_date . '</td>';
                            echo '</tr>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <a href="dashboard1.php" class="btn btn-primary btn-manage">Manage User</a>
        <a href="logout.php" class="btn btn-primary btn-manage">Logout</a>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
