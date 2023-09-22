<?php
include('config.php');
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Check if the scholarship ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: admin_scholarships.php");
    exit;
}

$scholarshipId = $_GET['id'];

// Function to get scholarship details
function getScholarshipDetails($scholarshipId) {
    global $conn;
    $sql = "SELECT s.id, u.username AS student_name, s.amount, s.reason
            FROM scholarships s
            INNER JOIN users u ON s.student_id = u.id
            WHERE s.id = $scholarshipId";

    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

// Handle form submission for scholarship edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newAmount = $_POST['new_amount'];
    $newReason = $_POST['new_reason'];

    $editSql = "UPDATE scholarships SET amount = $newAmount, reason = '$newReason' WHERE id = $scholarshipId";
    mysqli_query($conn, $editSql);
    header("Location: view_scholorships.php");
    exit;
}

$scholarshipDetails = getScholarshipDetails($scholarshipId);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Scholarship</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include('admin_navbar.php'); ?>

    <div class="container mt-4">
        <h2>Edit Scholarship</h2>

        <form method="POST" action="">
            <div class="form-group">
                <label for="new_amount">Amount:</label>
                <input type="number" id="new_amount" name="new_amount" class="form-control" value="<?php echo $scholarshipDetails['amount']; ?>" required>
            </div>
            <div class="form-group">
                <label for="new_reason">Reason:</label>
                <textarea id="new_reason" name="new_reason" class="form-control" required><?php echo $scholarshipDetails['reason']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
