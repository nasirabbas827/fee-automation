<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Initialize variables for form data
$voucherID = $userID = $month = $year = $dueDate = $amount = $status = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $voucherID = $_POST["voucherID"];
    $userID = $_POST["userID"];
    $month = $_POST["month"];
    $year = $_POST["year"];
    $dueDate = $_POST["dueDate"];
    $amount = $_POST["amount"];
    $status = $_POST["status"];

    // Update fee voucher in the database
    $update_sql = "UPDATE fee_vouchers 
                   SET userID='$userID', Month='$month', Year='$year', DueDate='$dueDate', Amount='$amount', Status='$status'
                   WHERE VoucherID='$voucherID'";

    if (mysqli_query($conn, $update_sql)) {
        $successMessage = "Fee voucher updated successfully.";
    } else {
        echo "Error updating fee voucher: " . mysqli_error($conn);
    }
} else {
    // Retrieve fee voucher details
    if (isset($_GET["id"])) {
        $voucherID = $_GET["id"];
        $query = "SELECT * FROM fee_vouchers WHERE VoucherID = '$voucherID'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $userID = $row["userID"];
            $month = $row["Month"];
            $year = $row["Year"];
            $dueDate = $row["DueDate"];
            $amount = $row["Amount"];
            $status = $row["Status"];
        } else {
            echo "Fee voucher not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Fee Voucher</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Include Bootstrap 4.5.2 CSS from CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>

<body>
    <?php include('admin_navbar.php'); ?>

    <div class="container mt-5 mb-5">
        <h2>Edit Fee Voucher</h2>
        <form method="post">
            <input type="hidden" name="voucherID" value="<?php echo $voucherID; ?>">
            <div class="form-group">
                <label for="userID">User:</label>
                <select class="form-control" id="userID" name="userID" required>
                    <?php
                    // Query to retrieve usernames from the users table
                    $usernames_sql = "SELECT id, username FROM users";
                    $usernames_result = mysqli_query($conn, $usernames_sql);

                    while ($username_row = mysqli_fetch_assoc($usernames_result)) {
                        $selected = ($username_row['id'] == $userID) ? "selected" : "";
                        echo "<option value='" . $username_row['id'] . "' $selected>" . $username_row['username'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="month">Month:</label>
                <input type="text" class="form-control" id="month" name="month" value="<?php echo $month; ?>" required>
            </div>
            <div class="form-group">
                <label for="year">Year:</label>
                <input type="number" class="form-control" id="year" name="year" value="<?php echo $year; ?>" required>
            </div>
            <div class="form-group">
                <label for="dueDate">Due Date:</label>
                <input type="date" class="form-control" id="dueDate" name="dueDate" value="<?php echo $dueDate; ?>" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" class="form-control" id="amount" name="amount" value="<?php echo $amount; ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Paid" <?php if ($status == "Paid") echo "selected"; ?>>Paid</option>
                    <option value="Unpaid" <?php if ($status == "Unpaid") echo "selected"; ?>>Unpaid</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Fee Voucher</button>
        </form>

        <?php
        if ($successMessage) {
            echo '<div class="alert alert-success mt-3" role="alert">' . $successMessage . '</div>';
        }
        ?>
    </div>

    <!-- Include Bootstrap 4.5.2 JavaScript from CDN (Optional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

