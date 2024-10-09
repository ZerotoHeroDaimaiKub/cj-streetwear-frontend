<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            margin-top: 50px;
            display: inline-block;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: left;
        }
        h1 {
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        label {
            margin: 10px 0 5px;
        }
        input, select {
            padding: 8px;
            width: 100%;
            max-width: 300px;
            margin-bottom: 15px;
        }
        .submit-btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #45a049;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        .back-link:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Edit Order</h1>

    <?php
    // Database connection parameters
    $servername = "127.0.0.1";
    $username = "root";
    $password = "Timeza.084"; // replace with your actual MySQL root password
    $dbname = "cj_streetwear";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if OrderID is set and retrieve order details
    if (isset($_GET['OrderID'])) {
        $orderID = intval($_GET['OrderID']);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Update order details in the database
            $customerID = intval($_POST['CustomerID']);
            $collectionID = intval($_POST['CollectionID']);
            $orderDate = $conn->real_escape_string($_POST['OrderDate']);
            $status = $conn->real_escape_string($_POST['Status']);

            $sql = "UPDATE `order` SET CustomerID='$customerID', CollectionID='$collectionID', OrderDate='$orderDate', Status='$status' WHERE OrderID=$orderID";

            if ($conn->query($sql) === TRUE) {
                echo "<p>Order updated successfully!</p>";
            } else {
                echo "<p>Error updating order: " . $conn->error . "</p>";
            }
        }

        // Fetch current order details
        $sql = "SELECT * FROM `order` WHERE OrderID = $orderID";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $order = $result->fetch_assoc();
            ?>

            <div class="container">
                <form method="post" action="">
                    <label for="CustomerID">Customer ID:</label>
                    <input type="number" name="CustomerID" id="CustomerID" value="<?php echo htmlspecialchars($order['CustomerID']); ?>" required>

                    <label for="CollectionID">Collection ID:</label>
                    <input type="number" name="CollectionID" id="CollectionID" value="<?php echo htmlspecialchars($order['CollectionID']); ?>" required>

                    <label for="OrderDate">Order Date:</label>
                    <input type="date" name="OrderDate" id="OrderDate" value="<?php echo htmlspecialchars($order['OrderDate']); ?>" required>

                    <label for="Status">Status:</label>
                    <select name="Status" id="Status" required>
                        <option value="Pending" <?php if($order['Status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                        <option value="Shipped" <?php if($order['Status'] == 'Shipped') echo 'selected'; ?>>Shipped</option>
                        <option value="Delivered" <?php if($order['Status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                    </select>

                    <button type="submit" class="submit-btn">Update Order</button>
                </form>
            </div>

            <?php
        } else {
            echo "<p>Order not found.</p>";
        }
    } else {
        echo "<p>No Order ID provided.</p>";
    }

    $conn->close();
    ?>

    <a href="order.php" class="back-link">Back to Order List</a>
</body>
</html>
