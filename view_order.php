<?php
// Connecting to database
include "dbconfig.php";


// Get the customer ID from the URL query parameter
$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;

// Fetch orders from the database for the logged-in customer, ordered by the date and time they were placed
$sql = "SELECT o.oid, p.P_id, p.Name AS product_name, p.price, p.quantity AS available_qty, o.order_qty, p.V_id,
        DATE_FORMAT(o.order_datetime, '%Y-%m-%d %h:%i:%s %p') AS formatted_date
        FROM CPS3740.Products AS p
        JOIN Order_paredchr AS o ON o.pid = p.P_id
        WHERE o.cid = $cid
        ORDER BY o.order_datetime ASC"; // Use DESC for descending order

$result = $con->query($sql);

// Start HTML output
echo '<table border="1">
        <tr>
            <th>order id</th>
            <th>product name</th>
            <th>price</th>
            <th>available qty</th>
            <th>order qty</th>
            <th>vendor id</th>
            <th>date time</th>
            <th>actions</th>
        </tr>';

// Check if there are any results
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row["oid"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["product_name"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["price"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["available_qty"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["order_qty"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["V_id"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["formatted_date"]) . '</td>';
        echo '<td>';

        
        echo '<a href="cancel_order.php?cid=' . htmlspecialchars($cid) . '&oid=' . htmlspecialchars($row["oid"]) . '" style="margin-right: 10px;">Cancel order</a>'; 

        echo '<form action="https://obi2.kean.edu/~paredchr@kean.edu/CPS3740/change_order.php" method="get" style="display: inline;">';
        echo '<input type="text" name="new_qty" size="3" style="width: 50px;" required title="Please fill out this field">';
        echo '<input type="submit" value="Change quantity">';

        echo '<input type="hidden" name="oid" value="' . htmlspecialchars($row["oid"]) . '">';
        echo '<input type="hidden" name="cid" value="' . htmlspecialchars($cid) . '">';
        echo '<input type="hidden" name="pid" value="' . htmlspecialchars($row["P_id"]) . '">';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="5">No orders found</td></tr>';
}
echo '</table>';

$con->close();
?>
