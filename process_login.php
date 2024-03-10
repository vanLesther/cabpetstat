<?php
session_start();

require_once("class/resident.php");
require_once("class/admin.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $resident = new Resident();
    $user = $resident->loginResident($email, $password);

    if ($user !== false) {
        $_SESSION['user'] = $user; 
        switch ($user['userType']) {
            case 0:
                // resident login
                header("Location: ./dashboard.php?active-tab=1");
                exit();
            case 1:
                // BAO login
                header("Location: dashboardBAO.php");
                exit();
            case 2:
                header("Location: dashboard2.php");
                exit();
            default:
                echo "Invalid userType: " . $user['userType'];
                exit();
        }
    } 
    $admin = new Admin();
    $admin = $admin->adminLogin($email, $password);

    if ($admin !== false) {
        $_SESSION['admin'] = $admin; 
        switch ($admin['userType']) {
            case 0:
                header("Location: dashboardMAO.php");
                exit();
            default:
                echo "Invalid userType: " . $admin['userType'];
                exit();
        }
    } else {
        echo '<script>alert("Incorrect email or password!"); window.location.href = "login.php?error=invalid";</script>';
        exit();
    }
}
?>
