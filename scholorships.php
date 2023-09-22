<?php
include('config.php');

session_start();

// Check if user is logged in, if not, redirect to login page
if (!isset($_SESSION["id"]) || empty($_SESSION["id"])) {
    header("location: index.php");
    exit;
}

// Get the logged-in user's ID
$userID = $_SESSION["id"];

// Query to retrieve scholarships for the logged-in user
$sql = "SELECT * FROM scholarships WHERE student_id = $userID";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Scholarships</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php
include('navbar.php');
?>
    <div class="container mt-5">
        <h2>My Scholarships</h2>

        <?php
        // Check if there are scholarships for the user
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table table-bordered'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Scholarship ID</th>";
            echo "<th>Amount</th>";
            echo "<th>Reason</th>";
            echo "<th>Date Awarded</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>$" . $row['amount'] . "</td>";
                echo "<td>" . $row['reason'] . "</td>";
                echo "<td>" . $row['created_at'] . "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>No scholarships found for you.</p>";
        }
        ?>

    </div>

    <!-- Include Bootstrap JS and jQuery (Optional) -->
   <script src="https://code.jquery.com/jquery-3.5.1.js"></script> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
