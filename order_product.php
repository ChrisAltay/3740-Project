<?php
// Connecting to database
include "dbconfig.php";

if(isset($_GET['cid'])){
    $customer_cid = $_GET['cid'];
}

// Fetch products from database
$sql = "SELECT P_id as pid, Name, Price, Quantity, V_id as vid FROM CPS3740.Products"; 
$result = mysqli_query($con, $sql);
?>

<!-- HTML Table for displaying products (Headers)-->
<table border="1">
    <thead>
        <tr>
            <th>pid</th>
            <th>Name</th>
            <th>Price</th>
            <th>Available QTY</th>
            <th>vid</th>
            <th style="width: 145px;">QTY to order</th>
        </tr>
    </thead>

<!-- Table data pulled from Products table in database -->
    <tbody>
        <?php
        while($row = mysqli_fetch_assoc($result)){
            echo "<tr>";
            echo "<td>" . $row['pid'] . "</td>"; 
            echo "<td>" . $row['Name'] . "</td>";
            echo "<td>" . $row['Price'] . "</td>";
            echo "<td>" . $row['Quantity'] . "</td>";
            echo "<td>" . $row['vid'] . "</td>"; 

            // Form to enter quantity of product ordered by customer
            echo "<form action='place_order.php' method='get'>";
            echo "<input type='hidden' name='cid' value='" . $customer_cid . "'>";
            echo "<td><input type='hidden' name='pid' value='" . $row['pid'] . "'>";
            echo "<input type='text' name='pid_order_qty' style='width: 50px;' required title='Please fill out this field'> <button type='submit'>Place Order</button></td>";
            echo "</form>";         
        }
        ?>
    </tbody>
</table>

<?php
mysqli_close($con);
?>
