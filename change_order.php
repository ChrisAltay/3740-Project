<?php
// Connecting to database
include "dbconfig.php"; 

// Fetch the parameters from the GET request
$new_qty = isset($_GET['new_qty']) ? intval($_GET['new_qty']) : 0;
$oid = isset($_GET['oid']) ? intval($_GET['oid']) : 0;
$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
$pid = isset($_GET['pid']) ? intval($_GET['pid']) : 0;

// First, check if the quantity is a positive integer
if($new_qty <= 0) {
    echo "The new order quantity must be integer and > 0";
    exit;
}

// Checks if the order belongs to the logged-in customer
$query = "SELECT * FROM Order_paredchr WHERE oid = $oid AND cid = $cid";
$result = mysqli_query($con, $query);                                                     

if(mysqli_num_rows($result) > 0) {
    // Checks product availability
    $Query = "SELECT quantity FROM CPS3740.Products WHERE P_id = $pid";
    $productResult = mysqli_query($con, $Query);
    $productRow = mysqli_fetch_assoc($productResult);
    if($new_qty > $productRow['quantity']) {
        echo "There is only {$productRow['quantity']} quantity available. Order failed!";
    } else {
        // Updates order quantity
        $updateQuery = "UPDATE Order_paredchr SET order_qty = $new_qty WHERE oid = $oid AND cid = $cid";
        if(mysqli_query($con, $updateQuery)) {
            echo "Successfully changed the order id: $oid!";
        } else {
            echo "Error updating the order.";
        }
    }
} else {
     // Will be displayed to user if order does not exist or belong to current loggeed in customer 
    echo "The order id $oid for customer id $cid does not exist, the order cannot be changed.";
}

mysqli_close($con);
?>
