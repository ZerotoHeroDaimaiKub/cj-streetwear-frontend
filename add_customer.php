<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
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
        input[type="text"], input[type="email"], input[type="password"] {
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
    <h1>Add New Customer</h1>

    <form action="add_customer.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <label for="order_history">Order History:</label>
        <input type="text" name="order_history" required>

        <label for="order_tracking">Order Tracking:</label>
        <input type="text" name="order_tracking" required>

        <label for="customer_location">Location:</label>
        <input type="text" name="customer_location" required>

        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" required>

        <input type="submit" name="submit" value="Add Customer">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Database connection parameters
        $servername = "127.0.0.1";
        $username = "root";
        $password = "Timeza.084"; // Use your actual password
        $dbname = "cj_streetwear";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO customer (Name, Email, Password, OrderHistory, OrderTracking, CustomerLocation, PhoneNumber) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $name, $email, $password_input, $order_history, $order_tracking, $customer_location, $phone_number);

        // Set parameters and execute
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password_input = $_POST['password'];
        $order_history = $_POST['order_history'];
        $order_tracking = $_POST['order_tracking'];
        $customer_location = $_POST['customer_location'];
        $phone_number = $_POST['phone_number'];

        if ($stmt->execute()) {
            echo "<p>New customer added successfully!</p>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

        // Close the connection
        $stmt->close();
        $conn->close();
    }
    ?>

    <br>
    <a href="customer.php">Back to Customer List</a>
</body>
</html>
