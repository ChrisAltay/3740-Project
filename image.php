<?php
// Code Fetches Image from Customers table and displays it on login.php
include "dbconfig.php";

$login = $_GET['login'];
// Fetches data from Customers table in login
$sql = "SELECT img FROM CPS3740.Customers WHERE login = '$login'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
// How the image is to be displayd (jpeg)
header("Content-type: image/jpeg"); 
echo $row['img'];

mysqli_free_result($result);
mysqli_close($con);

?>