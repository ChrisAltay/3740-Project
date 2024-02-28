<?php
// Connecting to database
include "dbconfig.php"; 


$oid = isset($_GET['oid']) ? intval($_GET['oid']) : 0;
$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;

// query which chhecks if the order belongs to the logged in customer 
$query = "SELECT * FROM Order_paredchr WHERE oid = $oid AND cid = $cid";
$result = mysqli_query($con, $query);

if(mysqli_num_rows($result) > 0) {
    // If order does belong to customer, proceed with the order cancellation 
    $deleteQuery = "DELETE FROM Order_paredchr WHERE oid = $oid AND cid = $cid";
    if(mysqli_query($con, $deleteQuery)) {
        echo "Successfully deleted the order id: $oid!!";
    } else {
        echo "Error deleting the order.";
    }
} 

else {
    // Will be displayed to user if order does not exist or belong to current loggeed in customer 
    echo "The order id $oid for customer id $cid does not exist, the order cannot be canceled.";
}

mysqli_close($con);
?>
