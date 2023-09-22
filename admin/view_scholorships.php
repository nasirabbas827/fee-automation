<?php
include('config.php');
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Function to get a list of scholarships
function getScholarships() {
    global $conn;
    $sql = "SELECT s.id, u.username AS student_name, s.amount, s.reason
            FROM scholarships s
            INNER JOIN users u ON s.student_id = u.id
            ORDER BY s.created_at DESC";

    $result = mysqli_query($conn, $sql);
    $scholarships = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $scholarships[] = $row;
    }

    return $scholarships;
}

// Handle delete scholarship
if (isset($_GET['delete'])) {
    $scholarshipId = $_GET['delete'];
    $deleteSql = "DELETE FROM scholarships WHERE id = $scholarshipId";
    mysqli_query($conn, $deleteSql);
    header("Location: view_scholorships.php");
    exit;
}

// Handle edit scholarship
if (isset($_POST['edit'])) {
    $scholarshipId = $_POST['edit'];
    $newAmount = $_POST['new_amount'];
    $newReason = $_POST['new_reason'];

    $editSql = "UPDATE scholarships SET amount = $newAmount, reason = '$newReason' WHERE id = $scholarshipId";
    mysqli_query($conn, $editSql);
    header("Location: view_scholorships.php");
    exit;
}

$scholarships = getScholarships();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Scholarships</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include('admin_navbar.php'); ?>

    <div class="container mt-4">
        <h2>Admin Scholarships</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Amount</th>
                    <th>Reason</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($scholarships as $scholarship) { ?>
                    <tr>
                        <td><?php echo $scholarship['student_name']; ?></td>
                        <td><?php echo $scholarship['amount']; ?></td>
                        <td><?php echo $scholarship['reason']; ?></td>
                        <td>
                            <a href="edit_scholarship.php?id=<?php echo $scholarship['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="?delete=<?php echo $scholarship['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this scholarship?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
