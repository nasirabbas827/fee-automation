<?php
include('config.php');

session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Initialize variables
$studentId = "";
$studentInfoRow = null;
$feeSubmissions = array();

// Check if a student ID is provided in the request
if (isset($_GET["student_id"])) {
    $studentId = intval($_GET["student_id"]);

    // Execute the SQL query to get the student's information
    $studentInfoSql = "SELECT id, username, email, phone, age, category_id, status
                       FROM users
                       WHERE id = $studentId";

    $studentInfoResult = mysqli_query($conn, $studentInfoSql);

    if ($studentInfoRow = mysqli_fetch_assoc($studentInfoResult)) {
        // Execute the SQL query to get the student's fee submissions
        $sql = "SELECT Month, Year, Amount, Status
                FROM fee_vouchers
                WHERE userID = $studentId
                ORDER BY Year, Month";

        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $feeSubmissions[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Wise Report</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('admin_navbar.php'); ?>

<div class="container mt-4">
    <h2>Student Wise Report</h2>

    <form method="GET" action="">
        <div class="form-group">
            <label for="student_id">Enter Student ID:</label>
            <input type="number" id="student_id" name="student_id" required class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
    <button id="exportExcel" class="float-right mt-5 btn btn-success">Export to Excel</button>

    <?php
    if (!empty($studentInfoRow)) {
        // Display student information
        echo "<h3>Student Information:</h3>";
        echo "<p><strong>Student ID:</strong> " . $studentInfoRow['id'] . "</p>";
        echo "<p><strong>Student Name:</strong> " . $studentInfoRow['username'] . "</p>";
        echo "<p><strong>Email:</strong> " . $studentInfoRow['email'] . "</p>";
        echo "<p><strong>Phone:</strong> " . $studentInfoRow['phone'] . "</p>";
        echo "<p><strong>Age:</strong> " . $studentInfoRow['age'] . "</p>";

        if (!empty($feeSubmissions)) {
            // Display fee submissions
            echo "<h3>Fee Submissions:</h3>";
            echo "<table class='table table-bordered'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Month</th>";
            echo "<th>Year</th>";
            echo "<th>Amount</th>";
            echo "<th>Status</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            foreach ($feeSubmissions as $row) {
                echo "<tr>";
                echo "<td>" . $row['Month'] . "</td>";
                echo "<td>" . $row['Year'] . "</td>";
                echo "<td>$" . $row['Amount'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>No fee submissions found for this student.</p>";
        }
    } else {
        echo "<p>Student not found.</p>";
    }
    ?>
</div>

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
        var table = document.querySelector(".table");
        var rows = table.querySelectorAll("tr");

        rows.forEach(function(row) {
            var rowData = [];
            row.querySelectorAll("td").forEach(function(cell) {
                rowData.push(cell.textContent);
            });
            wsData.push(rowData);
        });

        var ws = XLSX.utils.aoa_to_sheet(wsData);

        // Set the worksheet name
        XLSX.utils.book_append_sheet(workbook, ws, "StudentReport");

        // Save the workbook as an Excel file
        XLSX.writeFile(workbook, "StudentReport.xlsx");
    });
});
</script>
</body>
</html>

