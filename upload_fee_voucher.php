<?php
include('config.php');

session_start();

// Check if user is logged in, if not, redirect to login page
if (!isset($_SESSION["id"]) || empty($_SESSION["id"])) {
    header("location: index.php");
    exit;
}

// Check if the voucher_id and voucher_file are set in the POST request
if (isset($_POST['voucher_id']) && isset($_FILES['voucher_file'])) {
    // Get the voucher ID and uploaded file details
    $voucherID = $_POST['voucher_id'];
    $uploadedFile = $_FILES['voucher_file'];

    // Check if the uploaded file is valid
    if ($uploadedFile['error'] === UPLOAD_ERR_OK) {
        // Define the directory where the uploaded files will be stored
        $uploadDir = "uploads/";

        // Create the directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Generate a unique file name for the uploaded file
        $uniqueFileName = uniqid() . '_' . basename($uploadedFile['name']);
        $uploadFilePath = $uploadDir . $uniqueFileName;

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($uploadedFile['tmp_name'], $uploadFilePath)) {
            // Insert the record into the uploaded_vouchers table
            $insertSql = "INSERT INTO uploaded_vouchers (UserID, FilePath) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $insertSql);
            mysqli_stmt_bind_param($stmt, "is", $_SESSION["id"], $uploadFilePath);
            
            // Execute the query
            if (mysqli_stmt_execute($stmt)) {
                // Fee voucher uploaded successfully
                header("location: home.php"); 
                exit();
            } else {
                echo "Error inserting record into uploaded_vouchers: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "File upload error: " . $uploadedFile['error'];
    }
} else {
    echo "Invalid request.";
}
?>
