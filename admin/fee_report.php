<?php
include('config.php');

session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Execute SQL queries to get the list of students who have submitted fees and who have not
$feeSubmittedStudents = array();
$feeNotSubmittedStudents = array();

$sql = "SELECT DISTINCT(userID) AS student_id
        FROM fee_vouchers
        WHERE Status = 'Paid'";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $feeSubmittedStudents[] = $row['student_id'];
}

$sql = "SELECT id
        FROM users
        WHERE id NOT IN (SELECT DISTINCT(userID) FROM fee_vouchers WHERE Status = 'Paid')";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $feeNotSubmittedStudents[] = $row['id'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Fee Submitted and Not Submitted Students</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('admin_navbar.php'); ?>

<div class="container mt-4">
    <h2>Fee Submitted and Not Submitted Students</h2>

    <h3>Fee Submitted Students:</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($feeSubmittedStudents as $studentId) {
                $studentInfoSql = "SELECT id, username
                                   FROM users
                                   WHERE id = $studentId";

                $studentInfoResult = mysqli_query($conn, $studentInfoSql);
                $studentInfoRow = mysqli_fetch_assoc($studentInfoResult);

                if ($studentInfoRow) {
                    echo "<tr>";
                    echo "<td>" . $studentInfoRow['id'] . "</td>";
                    echo "<td>" . $studentInfoRow['username'] . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>

    <h3>Fee Not Submitted Students:</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($feeNotSubmittedStudents as $studentId) {
                $studentInfoSql = "SELECT id, username
                                   FROM users
                                   WHERE id = $studentId";

                $studentInfoResult = mysqli_query($conn, $studentInfoSql);
                $studentInfoRow = mysqli_fetch_assoc($studentInfoResult);

                if ($studentInfoRow) {
                    echo "<tr>";
                    echo "<td>" . $studentInfoRow['id'] . "</td>";
                    echo "<td>" . $studentInfoRow['username'] . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Include SheetJS for Excel export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get a reference to the export button
        var exportButton = document.getElementById("exportExcel");

        exportButton.addEventListener("click", function() {
            // Create a new workbook
            var workbook = XLSX.utils.book_new();

            // Add a worksheet with the table data
            var wsData = [];
            var tables = document.querySelectorAll(".table");

            tables.forEach(function(table, index) {
                var wsName = index === 0 ? "FeeSubmitted" : "FeeNotSubmitted";
                var wsRows = table.querySelectorAll("tr");

                var wsRowsData = [];
                wsRows.forEach(function(row) {
                    var rowData = [];
                    row.querySelectorAll("td").forEach(function(cell) {
                        rowData.push(cell.textContent);
                    });
                    wsRowsData.push(rowData);
                });

                var ws = XLSX.utils.aoa_to_sheet(wsRowsData);

                // Set the worksheet name
                XLSX.utils.book_append_sheet(workbook, ws, wsName);
            });

            // Save the workbook as an Excel file
            XLSX.writeFile(workbook, "FeeReport.xlsx");
        });
    });
    </script>
</div>
</body>
</html>
