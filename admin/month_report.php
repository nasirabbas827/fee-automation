<?php
// Connect to your database
session_start();
include('config.php');

// Execute the SQL query
$sql = "SELECT u.username AS student_name, u.id AS student_id, f.Month, f.Year, f.Amount, f.Status
        FROM fee_vouchers f
        INNER JOIN users u ON f.userID = u.id
        ORDER BY u.id, f.Year, f.Month";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Month Wise Fee Submissions</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('admin_navbar.php'); ?>


<div class="container mt-4 mb-5">
    <h2>Month Wise Fee Submissions for Each Student</h2>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Student ID</th>
                <th>Month</th>
                <th>Year</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['student_name'] . "</td>";
                echo "<td>" . $row['student_id'] . "</td>";
                echo "<td>" . $row['Month'] . "</td>";
                echo "<td>" . $row['Year'] . "</td>";
                echo "<td>$" . $row['Amount'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Include jQuery and DataTables for Excel export -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

    <script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('.table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'print'
            ]
        });
    });
    </script>
</div>

<!-- Include Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
