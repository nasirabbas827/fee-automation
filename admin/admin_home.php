<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('admin_navbar.php'); ?>

<div class="container mt-4">
    <h2>Admin Dashboard</h2>
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text">
                        <?php
                        // Retrieve total users count from the database and display it here
                        $sqlTotalUsers = "SELECT COUNT(*) AS total_users FROM users";
                        $resultTotalUsers = mysqli_query($conn, $sqlTotalUsers);
                        $rowTotalUsers = mysqli_fetch_assoc($resultTotalUsers);
                        echo $rowTotalUsers['total_users'];
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Classes</h5>
                    <p class="card-text">
                        <?php
                        // Retrieve total categories count from the database and display it here
                        $sqlTotalCategories = "SELECT COUNT(*) AS total_categories FROM categories";
                        $resultTotalCategories = mysqli_query($conn, $sqlTotalCategories);
                        $rowTotalCategories = mysqli_fetch_assoc($resultTotalCategories);
                        echo $rowTotalCategories['total_categories'];
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Fee Vouchers</h5>
                    <p class="card-text">
                        <?php
                        // Retrieve total fee vouchers count from the database and display it here
                        $sqlTotalVouchers = "SELECT COUNT(*) AS total_vouchers FROM fee_vouchers";
                        $resultTotalVouchers = mysqli_query($conn, $sqlTotalVouchers);
                        $rowTotalVouchers = mysqli_fetch_assoc($resultTotalVouchers);
                        echo $rowTotalVouchers['total_vouchers'];
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Unpaid Students</h5>
                    <p class="card-text">
                        <?php
                        // Retrieve total unpaid students count from the database and display it here
                        $sqlTotalUnpaidStudents = "SELECT COUNT(*) AS total_unpaid_students FROM fee_vouchers WHERE status = 'unpaid'";
                        $resultTotalUnpaidStudents = mysqli_query($conn, $sqlTotalUnpaidStudents);
                        $rowTotalUnpaidStudents = mysqli_fetch_assoc($resultTotalUnpaidStudents);
                        echo $rowTotalUnpaidStudents['total_unpaid_students'];
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Paid Students</h5>
                    <p class="card-text">
                        <?php
                        // Retrieve total paid students count from the database and display it here
                        $sqlTotalPaidStudents = "SELECT COUNT(*) AS total_paid_students FROM fee_vouchers WHERE status = 'paid'";
                        $resultTotalPaidStudents = mysqli_query($conn, $sqlTotalPaidStudents);
                        $rowTotalPaidStudents = mysqli_fetch_assoc($resultTotalPaidStudents);
                        echo $rowTotalPaidStudents['total_paid_students'];
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

