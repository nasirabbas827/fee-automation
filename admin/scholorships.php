<?php
include('config.php');

session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Define variables to store user inputs
$studentId = $scholarshipAmount = $reason = $successMessage = $errorMessage = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize user inputs
    $studentId = mysqli_real_escape_string($conn, $_POST["student_id"]);
    $scholarshipAmount = mysqli_real_escape_string($conn, $_POST["scholarship_amount"]);
    $reason = mysqli_real_escape_string($conn, $_POST["reason"]);

    // Perform database insertion
    $insertQuery = "INSERT INTO scholarships (student_id, amount, reason) VALUES ('$studentId', '$scholarshipAmount', '$reason')";

    if (mysqli_query($conn, $insertQuery)) {
        $successMessage = "Scholarship added successfully!";
    } else {
        $errorMessage = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Scholarships</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('admin_navbar.php'); ?>

<div class="container mt-4">
    <h2>Manage Scholarships</h2>
    <?php
    if (!empty($successMessage)) {
        echo '<div class="alert alert-success">' . $successMessage . '</div>';
    }
    if (!empty($errorMessage)) {
        echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
    }
    ?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-group">
            <label for="student_id">Select Student:</label>
            <select class="form-control" id="student_id" name="student_id" required>
                <!-- Populate this select dropdown with student names or IDs from the database -->
                <?php
                // Fetch student data from the database and populate the dropdown
                $studentQuery = "SELECT id, username FROM users";
                $studentResult = mysqli_query($conn, $studentQuery);

                while ($row = mysqli_fetch_assoc($studentResult)) {
                    echo '<option value="' . $row['id'] . '">' . $row['username'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="scholarship_amount">Scholarship Amount:</label>
            <input type="text" class="form-control" id="scholarship_amount" name="scholarship_amount" required>
        </div>
        <div class="form-group">
            <label for="reason">Reason for Scholarship:</label>
            <textarea class="form-control" id="reason" name="reason" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Scholarship</button>
        <a class="btn btn-success" href="view_scholorships.php">View Scholorhsips</a>
    </form>
</div>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
