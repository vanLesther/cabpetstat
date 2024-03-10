<?php
require_once('class/pet.php');
require_once('class/cases.php');

$errorMessage = "";

if (isset($_POST['cancel_reg'])) {
    if (isset($_POST['petID'])) {
        $pet = new Pet();   
        $petID = $_POST['petID'];

        // Call the function to cancel the pet registration
        $result = $pet->cancelReg($petID);

        if ($result === true) {
            echo '<script>alert("Pet registration has been canceled."); window.location.href = "./BAOpetdashboard.php?active-tab=1";</script>';
            exit();
        } else {
            $errorMessage = "Failed to cancel pet registration: " . $result;
        }
    } else {
        $errorMessage = "Missing POST data for canceling the pet registration.";
    }
} else if (isset($_POST['cancel_bite'])) {
    if (isset($_POST['caseID'])) {
        $cases = new Cases();
        $caseID = $_POST['caseID'];

        // Call the function to cancel the bite registration
        $result2 = $cases->cancelBite($caseID);

        if ($result2) {
            echo '<script>alert("Case has been canceled."); window.location.href = "./BAOpetdashboard.php?active-tab=2";</script>';
            exit();
        } else {
            $errorMessage = "Failed to cancel bite case";
        }
    } else {
        $errorMessage = "Missing POST data for canceling the bite case.";
    }
}  else if (isset($_POST['cancel_death'])) {
    if (isset($_POST['caseID'])) {
        $cases = new Cases();
        $caseID = $_POST['caseID'];

        // Call the function to cancel the bite registration
        $result2 = $cases->cancelBite($caseID);

        if ($result2) {
                echo '<script>alert("Case has been cancelled"); window.location.href = "./BAOpetdashboard.php?active-tab=3";</script>';
            } else {
                echo '<script>alert("Invalid user type"); window.location.href = "./BAOdashboard.php?active-tab=3";</script>';
            }
        }else {
            $errorMessage = "Missing POST data for canceling the bite case.";
        }
    } else if (isset($_POST['cancel_sus'])) {
        if (isset($_POST['caseID'])) {
            $cases = new Cases();
            $caseID = $_POST['caseID'];
    
            // Call the function to cancel the bite registration
            $result2 = $cases->cancelBite($caseID);
    
            if ($result2) {
                    echo '<script>alert("Case has been cancelled"); window.location.href = "./BAOdashboard.php?active-tab=4";</script>';
                } else {
                    echo '<script>alert("Invalid user type"); window.location.href = "./BAOdashboard.php?active-tab=4";</script>';
                }
            }
        } else {
            $errorMessage = "Missing POST data for canceling the bite case.";
        }

// Handle any other code or error messages if needed
?>
