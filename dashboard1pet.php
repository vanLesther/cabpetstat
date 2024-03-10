<?php
session_start();
require_once("class/pet.php");
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
    if (isset($_POST["verify"]) || isset($_POST["reject"])) {
        $petID = $_POST["petID"];
        $status = isset($_POST["verify"]) ? 1 : 2; // 1 for verified, 2 for not verified

        $pet = new Pet();
        $result = $pet->updatePetStatus($petID, $status);

        if ($result === true) {
            // Successfully updated pet status
            echo '<script>alert("Pet status updated successfully.");</script>';
        } else {
            // Failed to update pet status
            echo "Failed to update pet status: " . $result;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard 2</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 30px;
        }

        .card {
            margin-top: 20px;
        }

        .card-header {
            background-color: #007bff;
            color: white;
        }

        .nav-link {
            color: #007bff;
        }

        .nav-link.active {
            color: #ffffff;
            background-color: #007bff;
        }

        .tab-content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .btn-accept {
            background-color: #28a745;
            color: #ffffff;
        }

        .btn-reject {
            background-color: #dc3545;
            color: #ffffff;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Manage Pets for Barangay: <?php echo $result ?></h1>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#newPets" data-bs-toggle="tab">New Pets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#validPets" data-bs-toggle="tab">Valid Pets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#rejectedPets" data-bs-toggle="tab">Rejected Pets</a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- New Pets -->
            <div class="tab-pane fade show active" id="newPets">
                <div class="card">
                    <div class="card-header">
                        New Pets
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Resident Name</th>
                                    <th>Pet Name</th>
                                    <th>Type</th>
                                    <th>Sex</th>
                                    <th>Color</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $pet = new Pet();
                                $pets = $pet->getAllNewPets($brgyID);

                                while ($row = $pets->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $row['name'] . '</td>';
                                    echo '<td>' . $row['pname'] . '</td>';
                                    echo '<td>' . ($row['petType'] == 0 ? 'Dog' : 'Cat') . '</td>';
                                    echo '<td>' . ($row['sex'] == 0 ? 'Male' : 'Female') . '</td>';
                                    echo '<td>' . $row['color'] . '</td>';
                                    echo '<td>
                                            <form method="post" action="dashboard1pet.php">
                                                <input type="hidden" name="petID" value="' . $row['petID'] . '">
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
                </div>
            </div>

            <!-- Valid Pets -->
            <div class="tab-pane fade" id="validPets">
                <div class="card">
                    <div class="card-header">
                        Valid Pets
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Resident Name</th>
                                    <th>Pet Name</th>
                                    <th>Type</th>
                                    <th>Sex</th>
                                    <th>Color</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $pet = new Pet();
                                $pets = $pet->getAllValidPets($brgyID);

                                while ($row = $pets->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $row['name'] . '</td>';
                                    echo '<td>' . $row['pname'] . '</td>';
                                    echo '<td>' . ($row['petType'] == 0 ? 'Dog' : 'Cat') . '</td>';
                                    echo '<td>' . ($row['sex'] == 0 ? 'Male' : 'Female') . '</td>';
                                    echo '<td>' . $row['color'] . '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Rejected Pets -->
            <div class="tab-pane fade" id="rejectedPets">
                <div class="card">
                    <div class="card-header">
                        Rejected Pets
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Resident Name</th>
                                    <th>Pet Name</th>
                                    <th>Type</th>
                                    <th>Sex</th>
                                    <th>Color</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $pet = new Pet();
                                $pets = $pet->getAllRejectedPets($brgyID);

                                while ($row = $pets->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $row['name'] . '</td>';
                                    echo '<td>' . $row['pname'] . '</td>';
                                    echo '<td>' . ($row['petType'] == 0 ? 'Dog' : 'Cat') . '</td>';
                                    echo '<td>' . ($row['sex'] == 0 ? 'Male' : 'Female') . '</td>';
                                    echo '<td>' . $row['color'] . '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <a href="dashboard1.php" class="btn btn-primary mt-3">Manage User</a>
        <a href="logout.php" class="btn btn-primary mt-3">Logout</a>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
