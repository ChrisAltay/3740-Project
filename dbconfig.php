<?php 

// All database connection info
$hostname = "imc.kean.edu";
$username = "paredchr";
$password = "1189919";
$dbname = "CPS3740_2023F";

$con = mysqli_connect($hostname, $username, $password, $dbname) 
or die("<br>Cannot connect to DB:$dbname on $hostname\n");

?>