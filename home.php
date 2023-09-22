<?php
include('config.php');

session_start();

// Check if user is logged in, if not, redirect to login page
if (!isset($_SESSION["id"]) || empty($_SESSION["id"])) {
    header("location: index.php");
    exit;
}

// Get the user ID from the session
$user_id = $_SESSION["id"];

// Fetch user details from the database
$sql = "SELECT u.id, u.username, u.email, u.age, c.name AS category_name
        FROM users AS u
        LEFT JOIN categories AS c ON u.category_id = c.id
        WHERE u.id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $fetched_id, $username, $email, $age, $category_name);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Fetch fee voucher and payment status for the user
// Fetch fee vouchers for the user
$feeVoucherQuery = "SELECT VoucherID, Month, Year, DueDate, Amount, Status
                    FROM fee_vouchers
                    WHERE userID = ?";
$stmt = mysqli_prepare($conn, $feeVoucherQuery);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$feeVoucherResult = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome, <?php echo $username; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    
    <!-- Add your CSS styles here -->
</head>
<body>
<?php include('navbar.php'); ?>

<div class="container mt-5">
    <h2>Welcome, <?php echo $username; ?>!</h2>
    <p><strong>Email:</strong> <?php echo $email; ?></p>
    <p><strong>Age:</strong> <?php echo $age; ?></p>
    <p><strong>Category:</strong> <?php echo $category_name; ?></p>

    <h3>Fee Voucher and Payment Status:</h3>
    <table class="table">
        <thead>
            <tr>
                <th>VoucherID</th>
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
            while ($row = mysqli_fetch_assoc($feeVoucherResult)) {
                echo "<tr>";
                echo "<td>" . $row['VoucherID'] . "</td>";
                echo "<td>" . $row['Month'] . "</td>";
                echo "<td>" . $row['Year'] . "</td>";
                echo "<td>" . $row['DueDate'] . "</td>";
                echo "<td>" . $row['Amount'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "<td>";
                if ($row['Status'] == 'Unpaid') {
                    echo "<a href='generate_fee_voucher_pdf.php?voucher_id=" . $row['VoucherID'] . "' target='_blank'>Download Fee Voucher</a>";
                    echo "<form action='upload_fee_voucher.php' method='post' enctype='multipart/form-data'>";
                    echo "<input type='file' name='voucher_file'>";
                    echo "<input type='hidden' name='voucher_id' value='" . $row['VoucherID'] . "'>";
                    echo "<input type='submit' value='Upload Fee Voucher'>";
                    echo "</form>";
                } elseif ($row['Status'] == 'Paid') {
                    echo "<a href='generate_fee_voucher_pdf.php?voucher_id=" . $row['VoucherID'] . "' target='_blank'>Download Fee Voucher</a>";
                }
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Add Bootstrap JavaScript and your JavaScript scripts here -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
