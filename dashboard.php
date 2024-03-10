<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Get the user's information from the session
$user = $_SESSION['user'];

// Include the Pet class
require_once("class/pet.php");
$pet = new Pet();

// Get all pets belonging to the user
$pets = $pet->getPetsByResidentID($user['residentID']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Pet Dashboard</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="viewPet.php">View Pets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Welcome, <?php echo isset($user['name']) ? $user['name'] : ''; ?>!</h1>
        <p>Email: <?php echo isset($user['email']) ? $user['email'] : ''; ?></p>
    </div>

    <div class="container mt-4">
        <h2>Add Pet</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPetModal">Add Pet</button>
    </div>

    <div class="container mt-4">
        <h2>My Pets</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Sex</th>
                    <th>Color</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pets as $pet) { ?>
                    <tr>
                        <td><?php echo $pet['pname']; ?></td>
                        <td><?php echo ($pet['petType'] == 0) ? 'Dog' : 'Cat'; ?></td>
                        <td><?php echo ($pet['sex'] == 0) ? 'Male' : 'Female'; ?></td>
                        <td><?php echo $pet['color']; ?></td>
                        <td>
                            <?php if ($pet['status'] == 0) { ?>
                                <i class="bi bi-x-circle text-danger"></i> Not Verified
                            <?php } else { ?>
                                <i class="bi bi-check-circle text-success"></i> Verified
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Add Pet Modal -->
    <div class="modal fade" id="addPetModal" tabindex="-1" aria-labelledby="addPetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPetModalLabel">Add Pet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addPetForm" action="process_addPet.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="petType" class="form-label">Pet Type:</label>
                            <select class="form-select" name="petType" id="petType" required>
                                <option value="">Select Pet Type</option>
                                <option value="0">Dog</option>
                                <option value="1">Cat</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="sex" class="form-label">Sex:</label>
                            <select class="form-select" name="sex" id="sex" required>
                                <option value="">Select Sex</option>
                                <option value="0">Male</option>
                                <option value="1">Female</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="color" class="form-label">Color:</label>
                            <input type="text" class="form-control" name="color" id="color" required>
                        </div>
                        <input type="hidden" name="residentID" id="residentID" value="<?php echo $user['residentID']; ?>">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addPetButton">Add Pet</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <h2>Add Bite Case</h2>
        <a href="addBiteCase.php" class="btn btn-primary">Add Bite Cases</a>
    </div>

    <div class="container mt-4">
        <h2>Add Bite Case</h2>
        <a href="addBiteCase.php" class="btn btn-primary">Add Bite Cases</a>
    </div>

    <script>
        $(document).ready(function() {
            // Add Pet button click event
            $('#addPetButton').click(function() {
                // Submit the form using AJAX
                $.ajax({
                    url: 'process_addPet.php',
                    type: 'POST',
                    data: $('#addPetForm').serialize(),
                    success: function(response) {
                        // Handle the response
                        if (response.success) {
                            // Refresh the pet list
                            location.reload();
                        } else {
                            // Display an error message
                            alert('Failed to add pet: ' + response.message);
                        }
                    },
                    error: function() {
                        // Display an error message
                        alert('An error occurred while processing the request.');
                    }
                });
            });
        });
    </script>
</body>
</html>
