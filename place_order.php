<?php
// Connecting to database
include "dbconfig.php";

if(isset($_GET['cid']) && isset($_GET['pid']) && isset($_GET['pid_order_qty'])) {
    $cid = $_GET['cid'];
    $pid = $_GET['pid'];
    $order_qty = $_GET['pid_order_qty'];

    // This Checks if the input quantity is positive
    if($order_qty <= 0) {
        echo "The order quantity must be > 0. The order has not been successfully placed.";
        exit();
    }

    // This Checks if the input is a numeric value
    if (!is_numeric($order_qty)) {
        echo "The order must be a number. The order has not been successfully placed.";
        exit();
    }

    // This Checks if the input quantity is an integer 
    if (is_float($order_qty + 0)) {
       echo "The order quantity must be an integer. The order has not been successfully placed.";
       exit();
    }

    // Sql that checks avaliable quantity in products table 
    $check_sql = "SELECT Quantity FROM CPS3740.Products WHERE P_id = '$pid'";
    $result = mysqli_query($con, $check_sql);
    $row = mysqli_fetch_assoc($result);
    $available_qty = $row['Quantity'];

    if($order_qty > $available_qty) {
        echo "There is only " . $available_qty . " quantity available. The order was not successfully placed.";
        exit();
    }

    // Sql to insert user order into order table
    $insert_sql = "INSERT INTO Order_paredchr (oid, order_datetime, order_qty, cid, pid) VALUES (NULL, NOW(), '$order_qty', '$cid', '$pid')";
    if(mysqli_query($con, $insert_sql)) {
        echo "Order placed successfully!";
    } else {
        echo "There was an error placing the order";
    }

} else {
    echo "Incomplete parameters.";
}

mysqli_close($con);
?>
