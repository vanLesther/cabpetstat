<?php
include_once ('class/db_connect.php');
// Check if the export button is clicked
if (isset($_POST['export'])) {
    // Database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch all data or filtered data based on the selected filters
    $export_query = "SELECT p.*, r.*, v.*, b.*, p.petID
        FROM resident AS r
        NATURAL JOIN pet AS p
        LEFT JOIN (
            SELECT petID, MAX(lastVaccination) AS maxlastVaccination, lastVaccination
            FROM vaccination
            GROUP BY petID
        ) AS v ON p.petID = v.petID
        LEFT JOIN barangay AS b ON r.brgyID = b.brgyID
        WHERE p.status = 1";

    // Add filter conditions if any
    if (isset($_GET['gender_filter']) && ($_GET['gender_filter'] == '0' || $_GET['gender_filter'] == '1')) {
        $export_query .= " AND p.petType = '" . $_GET['gender_filter'] . "'";
    }

    if (isset($_GET['sex_filter']) && ($_GET['sex_filter'] == '0' || $_GET['sex_filter'] == '1')) {
        $export_query .= " AND p.sex = '" . $_GET['sex_filter'] . "'";
    }

    if (isset($_GET['year_filter']) && !empty($_GET['year_filter'])) {
        $export_query .= " AND YEAR(p.regDate) = '" . $_GET['year_filter'] . "'";
    }

    if (isset($_GET['vaccination_filter']) && ($_GET['vaccination_filter'] == '0' || $_GET['vaccination_filter'] == '1')) {
        $export_query .= " AND v.maxlastVaccination IS " . ($_GET['vaccination_filter'] == '0' ? "NOT NULL" : "NULL");
    }

    $export_query .= " ORDER BY p.petID DESC";

    // Execute query
    $export_result = $conn->query($export_query);

    // Check if there are results
    if ($export_result->num_rows > 0) {
        // Create a file pointer
        $file = fopen('pet_data.csv', 'w');

        // Add CSV headers
        fputcsv($file, array('Owner\'s Name', 'Date of Registry', 'Species', 'Name of Pet', 'Sex', 'Age', 'Neutering', 'Color', 'Vaccination Status', 'Last Vaccination', 'Latest Vaccination', 'Address'));

        // Add data to CSV
        while ($row = $export_result->fetch_assoc()) {
            fputcsv($file, array(
                $row["name"],
                date('F j, Y', strtotime($row["regDate"])),
                ($row["petType"] == 0 ? 'Dog' : 'Cat'),
                $row["pname"],
                ($row["sex"] == 0 ? 'Male' : 'Female'),
                $row["age"],
                ($row["Neutering"] == 0 ? 'Neutered' : 'Not Neutered'),
                $row["color"],
                ($row["statusVac"] == 0 ? 'Vaccinated' : 'Unvaccinated'),
                (!empty($row["lastVaccination"]) ? date('F j, Y', strtotime($row["lastVaccination"])) : ""),
                (!empty($row["currentVac"]) ? date('F j, Y', strtotime($row["currentVac"])) : ""),
                $row["barangay"]
            ));
        }

        // Close the file pointer
        fclose($file);

        // Prompt the user to download the CSV file
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename=pet_data.csv');
        readfile('pet_data.csv');

        // Exit script after file download
        exit;
    } else {
        echo "No data to export.";
    }

    // Close database connection
    $conn->close();
}
?>