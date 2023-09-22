<?php
include('config.php');

// Define variables and initialize with empty values
$username = $password = $email = $phone = $age = $category = "";
$username_err = $password_err = $email_err = $phone_err = $age_err = $category_err = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // Check if username already exists in the database
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = trim($_POST["username"]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 1) {
            $username_err = "This username is already taken.";
        } else {
            $username = trim($_POST["username"]);
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email address.";
    } else {
        $email = trim($_POST["email"]);
        // Check if email already exists in the database
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        $param_email = $email;
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 1) {
            $email_err = "This email address is already taken.";
        }
    }

    // Validate phone number
    if (empty(trim($_POST["phone"]))) {
        $phone_err = "Please enter a phone number.";
    } else {
        $phone = trim($_POST["phone"]);
        // Check if phone number already exists in the database
        $sql = "SELECT id FROM users WHERE phone = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_phone);
        $param_phone = $phone;
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 1) {
            $phone_err = "This phone number is already taken.";
        }
    }

    // Validate age
    if (empty(trim($_POST["age"]))) {
        $age_err = "Please enter your age.";
    } elseif (!is_numeric($_POST["age"])) {
        $age_err = "Age must be a number.";
    } else {
        $age = trim($_POST["age"]);
        if ($age < 18) {
            $age_err = "You must be at least 18 years old to register.";
        }
    }

    // Validate category
    if (empty($_POST["category"])) {
        $category_err = "Please select a category.";
    } else {
        $category = $_POST["category"];
    }

    // If no errors, insert user into the database
    if (empty($username_err) && empty($password_err) && empty($email_err) && empty($phone_err) && empty($age_err) && empty($category_err)) {
        $sql = "INSERT INTO users (username, password, email, phone, age, category_id, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssis", $param_username, $param_password, $param_email, $param_phone, $param_age, $param_category);
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        $param_email = $email;
        $param_phone = $phone;
        $param_age = $age;
        $param_category = $category;
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        echo '<div class="alert alert-success" role="alert">User registered successfully.</div>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: aquamarine;
        }

    </style>
</head>
<body>
<?php
include('navbar.php');
?>
<div class="container mt-5">
    <h2 class="text-center">User Registration</h2>
    <p class="text-center">Please fill in your details to register.</p>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group">
            <label>Phone Number</label>
            <input type="number" name="phone" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone; ?>">
            <span class="invalid-feedback"><?php echo $phone_err; ?></span>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
            <span class="invalid-feedback"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <label>Age</label>
            <input type="number" name="age" class="form-control <?php echo (!empty($age_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $age; ?>">
            <span class="invalid-feedback"><?php echo $age_err; ?></span>
        </div>
        <div class="form-group">
            <label>Class Category</label>
            <select name="category" class="form-control <?php echo (!empty($category_err)) ? 'is-invalid' : ''; ?>">
                <option value="" selected disabled>Select a category</option>
                <?php
                // Fetch categories from the database and populate the dropdown
                $category_sql = "SELECT id, name FROM categories";
                $category_result = mysqli_query($conn, $category_sql);
                while ($row = mysqli_fetch_assoc($category_result)) {
                    $category_id = $row['id'];
                    $category_name = $row['name'];
                    echo "<option value='$category_id'>$category_name</option>";
                }
                ?>
            </select>
            <span class="invalid-feedback"><?php echo $category_err; ?></span>
        </div>
        <div class="form-group text-center">
            <input type="submit" class="btn btn-primary" value="Register">
        </div>
    </form>

    <p class="text-center">Already have an account? <a href="login.php">Login here</a></p>
</div>

<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
