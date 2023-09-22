<?php
include('config.php');

if (isset($_POST['voucherID'])) {
    $voucherID = $_POST['voucherID'];
    $sql = "SELECT Amount FROM fee_vouchers WHERE VoucherID = '$voucherID'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        echo $row['Amount'];
    } else {
        echo '0'; // Default to 0 if voucher not found or other error
    }
} else {
    echo '0'; // Default to 0 if voucherID not provided
}
?>
