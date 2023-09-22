<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Check if the user ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: manage_users.php");
    exit;
}

// Get the user ID from the URL
$user_id = $_GET['id'];

// Query to retrieve user details with category name
$sql = "SELECT users.id, users.username, users.password, users.email, users.phone, users.age, users.category_id, users.status, categories.name AS category_name
        FROM users
        LEFT JOIN categories ON users.category_id = categories.id
        WHERE users.id = $user_id";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Error: " . mysqli_error($conn);
    exit;
}

// Initialize variables to store user details
$username = $email = $phone = $age = $category_id = $status = "";

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $username = $row['username'];
    $email = $row['email'];
    $phone = $row['phone'];
    $age = $row['age'];
    $category_id = $row['category_id'];
    $status = $row['status'];
}

// Handle user update
if (isset($_POST['update_user'])) {
    $new_username = $_POST['new_username'];
    $new_email = $_POST['new_email'];
    $new_phone = $_POST['new_phone'];
    $new_age = $_POST['new_age'];
    $new_category_id = $_POST['new_category_id'];
    $new_status = $_POST['new_status'];

    // Update user details in the database
    $update_sql = "UPDATE users SET username = '$new_username', email = '$new_email', phone = '$new_phone', age = '$new_age', category_id = '$new_category_id', status = '$new_status' WHERE id = $user_id";
    
    if (mysqli_query($conn, $update_sql)) {
        header("Location: manage_users.php");
        exit();
    } else {
        echo "Error updating user: " . mysqli_error($conn);
    }
}

// Query to retrieve categories for dropdown
$categories_sql = "SELECT id, name FROM categories";
$categories_result = mysqli_query($conn, $categories_sql);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit User</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Include Bootstrap 4.5.2 CSS from CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include('admin_navbar.php'); ?>

    <div class="container mt-5 mb-5">
        <h2>Edit User</h2>
        <form method="post">
            <div class="form-group">
                <label for="new_username">Username:</label>
                <input type="text" class="form-control" id="new_username" name="new_username" value="<?php echo $username; ?>">
            </div>
            <div class="form-group">
                <label for="new_email">Email:</label>
                <input type="email" class="form-control" id="new_email" name="new_email" value="<?php echo $email; ?>">
            </div>
            <div class="form-group">
                <label for="new_phone">Phone:</label>
                <input type="text" class="form-control" id="new_phone" name="new_phone" value="<?php echo $phone; ?>">
            </div>
            <div class="form-group">
                <label for="new_age">Age:</label>
                <input type="text" class="form-control" id="new_age" name="new_age" value="<?php echo $age; ?>">
            </div>
            <div class="form-group">
                <label for="new_category_id">Category:</label>
                <select class="form-control" id="new_category_id" name="new_category_id">
                    <?php
                    while ($category_row = mysqli_fetch_assoc($categories_result)) {
                        $selected = ($category_row['id'] == $category_id) ? "selected" : "";
                        echo "<option value='" . $category_row['id'] . "' $selected>" . $category_row['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="new_status">Status:</label>
                <select class="form-control" id="new_status" name="new_status">
                    <option value="Pending" <?php if ($status == 'Pending') echo 'selected="selected"'; ?>>Pending</option>
                    <option value="Approved" <?php if ($status == 'Approved') echo 'selected="selected"'; ?>>Approved</option>
                </select>
            </div>
            <button type="submit" class="mt-2 btn btn-primary" name="update_user">Update User</button>
        </form>
    </div>

    <!-- Include Bootstrap 4.5.2 JavaScript from CDN (Optional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
