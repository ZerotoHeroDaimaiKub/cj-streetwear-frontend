<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f0f0f0;
        }
        h1 {
            margin-top: 20px;
        }
        .button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Update Order History</h1>

    <?php
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

    // Fetch all customers with orders
    $customerQuery = "SELECT CustomerID FROM customer";
    $customerResult = $conn->query($customerQuery);

    if ($customerResult->num_rows > 0) {
        // Loop through each customer and update order history
        while ($customerRow = $customerResult->fetch_assoc()) {
            $customerID = $customerRow['CustomerID'];
            
            // Fetch orders related to the customer
            $orderQuery = "SELECT OrderID, Status FROM `order` WHERE CustomerID = ?";
            $stmt = $conn->prepare($orderQuery);
            $stmt->bind_param("i", $customerID);
            $stmt->execute();
            $orderResult = $stmt->get_result();

            // Construct order history text
            $orderHistory = [];
            while ($orderRow = $orderResult->fetch_assoc()) {
                $orderHistory[] = "Order " . $orderRow["OrderID"] . ": " . $orderRow["Status"];
            }

            // Join order history into a single string
            $orderHistoryText = implode(", ", $orderHistory);

            // Update customer’s order history
            $updateQuery = "UPDATE customer SET OrderHistory = ? WHERE CustomerID = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("si", $orderHistoryText, $customerID);
            $updateStmt->execute();

            $stmt->close();
            $updateStmt->close();
        }

        echo "<p>Order history updated for all customers with orders.</p>";
    } else {
        echo "<p>No customers found with orders.</p>";
    }

    $conn->close();
    ?>

    <br>
    <a href="customer.php" class="button">Back to Customer List</a>
</body>
</html>
