<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f0f0f0;
        }
        h1 {
            margin-top: 20px;
        }
        form {
            display: inline-block;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            margin-top: 20px;
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Edit Customer</h1>

    <?php
    // Initialize variables
    $customer_id = $name = $email = $password = $order_history = $order_tracking = $location = $phone_number = "";
    $customer_found = false;

    // Database connection parameters
    $servername = "127.0.0.1";
    $username = "root";
    $password = "Timeza.084"; // Replace with your actual MySQL root password
    $dbname = "cj_streetwear";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if we are in update mode or fetch mode
        if (isset($_POST["fetch"])) {
            // Fetch customer details
            $customer_id = $_POST['customer_id'];
            $sql = "SELECT * FROM customer WHERE CustomerID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $customer_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $customer_found = true;
                $row = $result->fetch_assoc();
                $name = $row["Name"];
                $email = $row["Email"];
                $password = $row["Password"];
                $order_history = $row["OrderHistory"];
                $order_tracking = $row["OrderTracking"];
                $location = $row["CustomerLocation"];
                $phone_number = $row["PhoneNumber"];
            } else {
                echo "<p>No customer found with ID $customer_id.</p>";
            }
            $stmt->close();
        } elseif (isset($_POST["update"])) {
            // Update customer details
            $customer_id = $_POST['customer_id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $order_history = $_POST['order_history'];
            $order_tracking = $_POST['order_tracking'];
            $location = $_POST['location'];
            $phone_number = $_POST['phone_number'];

            $sql = "UPDATE customer SET Name=?, Email=?, Password=?, OrderHistory=?, OrderTracking=?, CustomerLocation=?, PhoneNumber=? WHERE CustomerID=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssi", $name, $email, $password, $order_history, $order_tracking, $location, $phone_number, $customer_id);

            if ($stmt->execute()) {
                echo "<p>Customer updated successfully.</p>";
            } else {
                echo "<p>Error updating customer: " . $stmt->error . "</p>";
            }
            $stmt->close();
        }
    }

    $conn->close();
    ?>

    <!-- Form to fetch customer details -->
    <form action="edit_customer.php" method="POST">
        <label for="customer_id">Customer ID:</label>
        <input type="text" name="customer_id" required value="<?php echo htmlspecialchars($customer_id); ?>">
        <input type="submit" name="fetch" value="Fetch Customer">
    </form>

    <?php if ($customer_found): ?>
    <!-- Form to edit customer details -->
    <form action="edit_customer.php" method="POST">
        <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($customer_id); ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        
        <label for="password">Password:</label>
        <input type="text" name="password" value="<?php echo htmlspecialchars($password); ?>" required>
        
        <label for="order_history">Order History:</label>
        <input type="text" name="order_history" value="<?php echo htmlspecialchars($order_history); ?>" required>
        
        <label for="order_tracking">Order Tracking:</label>
        <input type="text" name="order_tracking" value="<?php echo htmlspecialchars($order_tracking); ?>" required>
        
        <label for="location">Location:</label>
        <input type="text" name="location" value="<?php echo htmlspecialchars($location); ?>" required>
        
        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" required>
        
        <input type="submit" name="update" value="Update Customer">
    </form>
    <?php endif; ?>

    <br>
    <a href="customer.php">Back to Customer List</a>
</body>
</html>
