<?php
// Connecting to database
include "dbconfig.php";


if (isset($_GET['username'])) {
    $browser_username = $_GET['username'];
    $browser_password = $_GET['password'];
} else {
    die("Please go to login.html first\n");
}

// Query to grab all sections and data from the logged in customer in the Customers table
$sql = "SELECT id , login, password, name, DOB, street, city, state, zipcode, img as image_path, gender FROM CPS3740.Customers WHERE login='$browser_username'";
$result = mysqli_query($con, $sql);

if ($result) {
	if (mysqli_num_rows($result) > 0) {
		    $row = mysqli_fetch_array($result);
	        $user_password = $row['password']; 


		if ($browser_password == $user_password) {
            //Verify Password, then set cookie after successful login
            setcookie('id', $row['id'], time() + 3600, '/');
            $cid = $row['id']; 
			$user_name = $row['name']; 
			$DOB = $row['DOB'];
			$street = $row['street'];
			$city = $row['city'];
            $state = $row['state'];
			$zipcode = $row['zipcode'];
			$image_path = $row['image_path'];
			$gender = $row['gender'];
            
            // Calculates age based on date of birth
            $today = date("Y-m-d");
            $diff = date_diff(date_create($DOB), date_create($today));
            $age = $diff->format('%y');

            // Grabs IP address 
            $ip = $_SERVER['REMOTE_ADDR'];

            // Checks if the logged in user is from Kean Domain
            if (@preg_match('/^10\./', $ip) || @preg_match('/^131\.125\./', $ip)) {
                $domain_message = "You are from Kean University.";
            } else {
                $domain_message = "You are not from Kean University.";
            }
            
            // Outputs all ther logged in users info with a picture of the user. 
            echo "IP: $ip<br>";
            echo $domain_message . "<br>";
            echo "Welcome customer: $user_name<br>";
            echo "Gender: $gender<br>"; 
            echo "DOB: $DOB, age: $age<br>";
			echo "Address: $street, $city, $state, $zipcode<br>";
            echo "<img src='image.php?login=$browser_username' alt='User Image'><br>";

            echo '<br>';

            // Added 3 links for user to ( Logout, Order Product, View, Change and Update product)
            echo '<a href="javascript:void(0);" onclick="confirmLogout();">Logout</a><br>';
            echo '<a href="order_product.php?cid='. $row['id'] . '">Order Product</a><br>';
            echo '<a href="view_order.php?cid='. $row['id'] . '">View, change, cancel my order history</a>';

            echo '<br>';    
            
            ?>

            <!-- Javascript function for confirmation logout dialog box pop-up -->
            <!-- If user clicks ok, user is logged out and re directed to home screen -->
            <script type="text/javascript">
                function confirmLogout() {
                    if (confirm('Are you sure you want to logout?')) {
                        window.location = 'logout.php'; 
                    }
                }
            </script>

            <?php

            // Checks if cookie works, if so, will print current logged in users id
            if (isset($_COOKIE['id'])) {
                $id = $_COOKIE['id'];
                echo '<br>';

                echo " Customer ID: " . $id;
            }
            else{
                echo " Customer ID cookie is not set. ";
            }
                      

        } else {
            die(" User $browser_username is in the system, but wrong password! ");
        }
    } else {
        echo " <br>Login $browser_username doesn't exist in the database.\n ";
    }
} else {
    echo " Something is wrong with SQL: " . mysqli_error($con);
}
mysqli_free_result($result);
mysqli_close($con);
?>
