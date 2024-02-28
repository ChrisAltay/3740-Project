<?php 
// Connecting to database
include "dbconfig.php";

//Grabs search keyword inputted and fetches product
$searchKeyword = $_GET['myproduct'] ?? ''; 
echo "<h4>The results of your search keyword '{$searchKeyword}':</h4>";

//Allows user to insert a random string ex. ipod, chair etc.
$query = "";

if ($searchKeyword == '*') { // Displayes all current products in the database  
    $query = "SELECT * FROM CPS3740.Products";
} 

elseif (in_array(strtolower($searchKeyword), ['ipod', 'chair', 'table', 'bell'])) {
    // Using 'strtolower' to make the comparison case-insensitive
    $query = "SELECT * FROM CPS3740.Products WHERE Name LIKE '%$searchKeyword%'";
} 

else {
    echo "Please enter a valid search keyword.";
    exit;
}

$result = mysqli_query($con, $query);

// Structure of products table
if(mysqli_num_rows($result) > 0) {
    echo "<table border='1'>";
    echo "<thead><tr><th>pid</th><th>Name</th><th>Price</th><th>QTY</th><th>vid</th></tr></thead>";
    echo "<tbody>";

    while($product = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$product['P_Id']}</td>";
        echo "<td>{$product['Name']}</td>";
        echo "<td>{$product['Price']}</td>";
        echo "<td>{$product['Quantity']}</td>";
        echo "<td>{$product['V_Id']}</td>";
        echo "</tr>";
}
    echo "</tbody>";
    echo "</table>";
} 
else {
    echo "No products found in the database."; 
}

mysqli_close($con);
?>


