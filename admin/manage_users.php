<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Query to retrieve all users with category names
$sql = "SELECT users.id, users.username, users.password, users.email, users.phone, users.age, categories.name AS category_name, users.status
        FROM users
        LEFT JOIN categories ON users.category_id = categories.id";
$result = mysqli_query($conn, $sql);

// Handle user deletion
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    $delete_sql = "DELETE FROM users WHERE id = $user_id";
    if (mysqli_query($conn, $delete_sql)) {
        // User deleted successfully
        header("location: manage_users.php");
        exit();
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Include Bootstrap 4.5.2 CSS from CDN -->
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include('admin_navbar.php'); ?>
    <h2>Students List</h2>
    <div class="container mt-5">
    <a class="float-right mb-3 btn btn-primary" href="add_users.php">Add Students</a>

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Age</th>
                    <th>Category Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['phone'] . "</td>";
                    echo "<td>" . $row['age'] . "</td>";
                    echo "<td>" . $row['category_name'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td>";
                    echo "<a class='btn btn-primary' href='edit_user.php?id=" . $row['id'] . "'>Edit</a>";
                    echo " ";
                    echo "<form method='post' action='manage_users.php'>";
                    echo "<input type='hidden' name='user_id' value='" . $row['id'] . "'>";
                    echo "<button class='mt-2 btn btn-danger' type='submit' name='delete_user'>Delete</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Include Bootstrap 4.5.2 JavaScript from CDN (Optional) -->
    <!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Include SheetJS for Excel export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
