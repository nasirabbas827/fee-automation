<?php
include('config.php');
require('./fpdf/fpdf.php'); // Include the FPDF library

// Define a class that extends FPDF for creating fee voucher PDFs
class PDF extends FPDF {
    // Page header
    function Header() {
        // Add header content here (if needed)
    }

    // Page footer
    function Footer() {
        // Add footer content here (if needed)
    }
}

if (isset($_GET['voucher_id'])) {
    // Get the fee voucher data from the database based on the voucher ID
    $voucherID = $_GET['voucher_id'];

    // Check the connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch fee voucher data from the users and fee_vouchers tables
    $sql = "SELECT u.username, v.VoucherID, v.Month, v.Year, v.DueDate, v.Amount, v.Status
            FROM users AS u
            JOIN fee_vouchers AS v ON u.id = v.userID
            WHERE v.VoucherID = ?";
    
    // Prepare and execute the SQL query
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $voucherID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $username, $voucherID, $month, $year, $dueDate, $amount, $status);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Create a new PDF instance
    $pdf = new PDF();
    $pdf->AddPage();

    // Add fee voucher data to the PDF
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, 'Fee Voucher ID: ' . $voucherID, 0, 1);

    // Display the Username, VoucherID, Month, Year, DueDate, Amount, and Status
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, 'Username: ' . $username, 0, 1);
    $pdf->Cell(40, 10, 'VoucherID: ' . $voucherID, 0, 1);
    $pdf->Cell(40, 10, 'Month: ' . $month, 0, 1);
    $pdf->Cell(40, 10, 'Year: ' . $year, 0, 1);
    $pdf->Cell(40, 10, 'Due Date: ' . $dueDate, 0, 1);
    $pdf->Cell(40, 10, 'Amount: $' . $amount, 0, 1);
    $pdf->Cell(40, 10, 'Status: ' . $status, 0, 1);

    // Output the PDF (replace 'D' with 'I' to force download)
    $pdf->Output('D', 'Fee_Voucher_' . $voucherID . '.pdf');
} else {
    // Handle the case when voucher_id is not provided
    echo 'Invalid request.';
}
?>
