<?php
session_start();
require_once("class/resident.php");
require_once("class/barangay.php");

// Check if the user is logged in and has admin privileges (userType = 1)
if (!isset($_SESSION['user']) || $_SESSION['user']['userType'] != 1) {
    header("Location: login.php");
    exit();
}

$brgyID = isset($_SESSION['user']['brgyID']) ? $_SESSION['user']['brgyID'] : '';

$barangay = new Barangay();
$result = $barangay->getBrgyName($brgyID);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["accept"]) || isset($_POST["reject"])) {
        $userID = $_POST["userID"];
        $status = isset($_POST["accept"]) ? 1 : 2; // 1 for accepted, 2 for rejected

        $resident = new Resident();
        $result = $resident->updateUserStatus($userID, $status);

        if ($result === true) {
            // Successfully updated user status
            echo '<script>alert("User status updated successfully.");</script>';
        } else {
            // Failed to update user status
            echo "Failed to update user status: " . $result;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard 1</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #004643;
            color: #fffffe;
        }

        .a {
            color:#fffffe;
        }

        .container {
            margin-top: 30px;
        }

        .tab-content {
            background-color: #e8e4e6;
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

        .btn-view {
            background-color: #17a2b8;
            color: #ffffff;
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
            background-color: #f9bc60;
            color: #001e1d;
            border-color: #f9bc60;
        }

        .btn-manage:hover {
            background-color: #e16162;
            border-color: #e16162;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Manage Pets for Barangay: <?php echo $result ?></h1>
        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#newResidents" data-bs-toggle="tab">New Residents</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#validResidents" data-bs-toggle="tab">Valid Residents</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#rejectedResidents" data-bs-toggle="tab">Rejected Residents</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- New Residents -->
            <div class="tab-pane fade show active" id="newResidents">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>View Location</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resident = new Resident();
                        $users = $resident->getAllNewResidents($brgyID);

                        while ($row = $users->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['name'] . '</td>';
                            echo '<td>' . $row['email'] . '</td>';
                            echo '<td>
                                     <form method="post" action="proccess_viewResidentLocation.php">
                                        <input type="hidden" name="userID" value="' . $row['residentID'] . '">
                                        <button type="submit" name="accept" class="btn btn-view">View Location</button>
                                    </form>
                             </td>';
                            echo '<td>
                                    <form method="post" action="dashboard1.php">
                                        <input type="hidden" name="userID" value="' . $row['residentID'] . '">
                                        <button type="submit" name="accept" class="btn btn-accept">Accept</button>
                                        <button type="submit" name="reject" class="btn btn-reject">Reject</button>
                                    </form>
                                </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Valid Residents -->
            <div class="tab-pane fade" id="validResidents">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resident = new Resident();
                        $users = $resident->getAllValidResidents($brgyID);

                        while ($row = $users->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['name'] . '</td>';
                            echo '<td>' . $row['email'] . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Rejected Residents -->
            <div class="tab-pane fade" id="rejectedResidents">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resident = new Resident();
                        $users = $resident->getAllRejectedResidents($brgyID);

                        while ($row = $users->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['name'] . '</td>';
                            echo '<td>' . $row['email'] . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <a href="dashboard1pet.php" class="btn btn-manage">Manage Pet</a>
            <a href="dashboardBiteCases.php" class="btn btn-manage">Manage Bite Cases</a>
            <a href="dashboardDeathCases.php" class="btn btn-manage">Manage Death Cases</a>
            <a href="logout.php" class="btn btn-manage">Logout</a>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>