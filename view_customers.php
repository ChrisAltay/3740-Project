<?php
// Connecting to database
include 'dbconfig.php';

// Grabs data from Customers table in database
$query = "SELECT * FROM CPS3740.Customers";
$result = mysqli_query($con, $query);

// HTML Table for displaying current customers in database
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customers</title>
</head>

<!-- HTML Table for displaying Customer (Headers) -->
<body>
    <table border="1">
        <thead>
            <tr>
                <th>cid</th>
                <th>login</th>
                <th>password</th>
                <th>name</th>
                <th>dob</th>
                <th>gender</th>
                <th>street</th>
                <th>zipcode</th>
            </tr>
        </thead>

    <!-- Table data pulled from Customers table in database -->
        <tbody>
            <?php while ($customer = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $customer['id'] ?></td>
                    <td><?= $customer['login'] ?></td>
                    <td><?= $customer['password'] ?></td>
                    <td><?= $customer['name'] ?></td>
                    <td><?= $customer['DOB'] ?></td>
                    <td><?= $customer['gender'] ?></td>
                    <td><?= $customer['street'] ?></td>
                    <td><?= $customer['zipcode'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>

</html>
