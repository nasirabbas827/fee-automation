<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Initialize variables for form data
$selectedUserID = $month = $year = $dueDate = $amount = $status = "";
$successMessage = "";

// Query to retrieve usernames from the users table
$usernames_sql = "SELECT id, username FROM users";
$usernames_result = mysqli_query($conn, $usernames_sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $selectedUserID = $_POST["userID"];
    $month = $_POST["month"];
    $year = $_POST["year"];
    $dueDate = $_POST["dueDate"];
    $amount = $_POST["amount"];
    $status = $_POST["status"];

    // Insert fee voucher into the database
    $insert_sql = "INSERT INTO fee_vouchers (userID, month, year, dueDate, amount, status) 
                   VALUES ('$selectedUserID', '$month', '$year', '$dueDate', '$amount', '$status')";

    if (mysqli_query($conn, $insert_sql)) {
        $successMessage = "Fee voucher added successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Create Fee Voucher</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Include Bootstrap 4.5.2 CSS from CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>

<body>
    <?php include('admin_navbar.php'); ?>

    <div class="container mt-5 mb-5">
        <h2>Create Fee Voucher</h2>
        <form method="post">
            <div class="form-group">
                <label for="userID">User:</label>
                <select class="form-control" id="userID" name="userID" required>
                    <option value="" disabled selected>Select User</option>
                    <?php
                    while ($username_row = mysqli_fetch_assoc($usernames_result)) {
                        $selected = ($username_row['id'] == $selectedUserID) ? "selected" : "";
                        echo "<option value='" . $username_row['id'] . "' $selected>" . $username_row['username'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="month">Month:</label>
                <input type="text" class="form-control" id="month" name="month" required>
            </div>
            <div class="form-group">
                <label for="year">Year:</label>
                <input type="number" class="form-control" id="year" name="year" required>
            </div>
            <div class="form-group">
                <label for="dueDate">Due Date:</label>
                <input type="date" class="form-control" id="dueDate" name="dueDate" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                    <option value="Paid">Paid</option>
                    <option value="Unpaid">Unpaid</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create Fee Voucher</button>
            <a href="view_voucher.php" class="btn btn-secondary">View Fee Vouchers</a>
        </form>

        <?php
        if ($successMessage) {
            echo '<div class="alert alert-success mt-3" role="alert">' . $successMessage . '</div>';
        }
        ?>
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

