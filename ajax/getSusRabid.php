<?php
include_once "../class/cases.php";
include_once "../class/pet.php";
include_once "../class/resident.php";
include_once "../class/barangay.php";
$cases = null;

if (isset($_POST['brgyid'])) {
    $brgyID = $_POST['brgyid'];
    $case = new Cases();

    $rabid = $case->getRabidByBrgy($brgyID);
    if ($case) {
        foreach ($rabid as $rabids) {
            echo '<tr>';
            echo '<td>' . $rabids['name'] . '</td>';
            echo '<td>' . $rabids['pname'] . '</td>';
            $input_date = $rabids['date'];

            $date_obj = new DateTime($input_date);

            $formatted_date = $date_obj->format("F j, Y");

            echo '<td>' . $rabids['barangay'] . '</td>';
            echo '<td>' . $formatted_date . '</td>';
            echo '<td>' . $rabids['description'] . '</td>';
            echo '<td>' . ($rabids['confirmedRabies'] == 0 ? 'No' : 'Yes') . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="3">No rabid reports found for the selected barangay.</td></tr>';
    }
}
?>
 <script>  
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
                    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });

                    // Create a link element to trigger the download
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.setAttribute('download', 'Rabids.csv');
                    document.body.appendChild(link);

                    // Trigger the click event on the link to initiate the download
                    link.click();

                    // Remove the link element after a delay to ensure the download has started
                    setTimeout(function () {
                        document.body.removeChild(link);
                    }, 1000); // You can adjust the delay as needed
                }

                        $("#rabidYrSrchBtn").click(function () {
                            var searchValue = $("#rabidYrSrch").val().toLowerCase();
                            var rows = $("#valid-s tr");

                            rows.show(); // Show all rows

                            if (searchValue.trim() !== "") {
                                // Filter rows based on the regDate column
                                var matchingRows = rows.filter(function () {
                                    return $(this).find('td:eq(10)').text().toLowerCase().indexOf(searchValue) > -1;
                                });

                                if (matchingRows.length > 0) {
                                    rows.hide(); // Hide all rows
                                    matchingRows.show(); // Show matching rows
                                } else {
                                    // Hide all rows and display "No matching results found" message
                                    rows.hide();
                                    $("#valid-s").append('<tr><td colspan="11">No matching results found.</td></tr>');
                                }
                            }
                        });

                    </script>