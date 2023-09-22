<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Query to retrieve all fee vouchers with user's username
$sql = "SELECT fee_vouchers.*, users.username
        FROM fee_vouchers
        INNER JOIN users ON fee_vouchers.userID = users.id";
$result = mysqli_query($conn, $sql);

// Handle fee voucher deletion
if (isset($_POST['delete_voucher'])) {
    $voucher_id = $_POST['voucher_id'];
    $delete_sql = "DELETE FROM fee_vouchers WHERE VoucherID = $voucher_id";
    if (mysqli_query($conn, $delete_sql)) {
        // Fee voucher deleted successfully
        header("location: view_voucher.php");
        exit();
    } else {
        echo "Error deleting fee voucher: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Fee Vouchers</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Include Bootstrap 4.5.2 CSS from CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>

<body>
    <?php include('admin_navbar.php'); ?>

    <div class="container mt-5 mb-5">
        <h2>Fee Vouchers</h2>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Voucher ID</th>
                    <th>User</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Due Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['VoucherID'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['Month'] . "</td>";
                    echo "<td>" . $row['Year'] . "</td>";
                    echo "<td>" . $row['DueDate'] . "</td>";
                    echo "<td>" . $row['Amount'] . "</td>";
                    echo "<td>" . $row['Status'] . "</td>";
                    echo "<td>";
                    echo "<a class='btn btn-primary' href='edit_voucher.php?id=" . $row['VoucherID'] . "'>Edit</a>";
                    echo " ";
                    echo "<form method='post' action='admin_fee_vouchers.php'>";
                    echo "<input type='hidden' name='voucher_id' value='" . $row['VoucherID'] . "'>";
                    echo "<button class='mt-2 btn btn-danger' type='submit' name='delete_voucher'>Delete</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Include Bootstrap 4.5.2 JavaScript from CDN (Optional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
