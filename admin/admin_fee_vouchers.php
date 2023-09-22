<?php
include('config.php');

session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Fetch all fee vouchers
$sql = "SELECT * FROM fee_vouchers";
$result = mysqli_query($conn, $sql);

// Handle status update
if (isset($_POST['update_status'])) {
    $voucher_id = $_POST['voucher_id'];

    // Update the status and amount of the fee voucher
    $update_sql = "UPDATE fee_vouchers SET Status = 'Paid', Amount = 0 WHERE VoucherID = ?";
    $stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($stmt, "i", $voucher_id);

    if (mysqli_stmt_execute($stmt)) {
        // Status updated successfully
        header("Location: admin_fee_vouchers.php");
        exit();
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

// Handle voucher download
if (isset($_GET['download_voucher'])) {
    $voucher_id = $_GET['voucher_id'];

    // Fetch voucher file path based on voucher ID
    $file_sql = "SELECT FilePath FROM uploaded_vouchers WHERE VoucherID = ?";
    $stmt = mysqli_prepare($conn, $file_sql);
    mysqli_stmt_bind_param($stmt, "i", $voucher_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $file_path);

    if (mysqli_stmt_fetch($stmt)) {
        // Generate a download link for the voucher file
        $file_location = "../" . $file_path; // Adjust the file location path as needed
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file_location) . '"');
        readfile($file_location);
        exit();
    }
    mysqli_stmt_close($stmt);
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

<div class="container mt-5">
    <h2>Fee Vouchers</h2>
    <table class="table">
        <thead>
            <tr>
                <th>VoucherID</th>
                <th>User ID</th>
                <th>Username</th>
                <th>Month</th>
                <th>Year</th>
                <th>Due Date</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['VoucherID'] . "</td>";
                echo "<td>" . $row['userID'] . "</td>";
                // Retrieve the username based on userID
                $username_sql = "SELECT username FROM users WHERE id=" . $row['userID'];
                $username_result = mysqli_query($conn, $username_sql);
                $username_row = mysqli_fetch_assoc($username_result);
                $username = $username_row['username'];
                echo "<td>" . $username . "</td>";
                echo "<td>" . $row['Month'] . "</td>";
                echo "<td>" . $row['Year'] . "</td>";
                echo "<td>" . $row['DueDate'] . "</td>";
                echo "<td>$" . $row['Amount'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "<td>";
                if ($row['Status'] === 'Unpaid') {
                    echo "<form method='post' action='admin_fee_vouchers.php'>";
                    echo "<input type='hidden' name='voucher_id' value='" . $row['VoucherID'] . "'>";
                    echo "<button type='submit' name='update_status' class='btn btn-primary'>Update Status</button>";
                    echo "</form>";
                }
                echo "<a href='admin_fee_vouchers.php?download_voucher=true&voucher_id=" . $row['VoucherID'] . "' class='btn btn-success'>Download Voucher</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Include Bootstrap 4.5.2 JavaScript from CDN (Optional) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Include SheetJS for Excel export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>

</body>
</html>

