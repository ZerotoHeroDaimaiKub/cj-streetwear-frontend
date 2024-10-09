<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping and Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f0f0f0;
        }
        h1 {
            margin-top: 20px;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        form {
            margin: 20px;
        }
        .button {
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .button:hover {
            background-color: #45a049;
        }
        .back-button {
            margin-top: 20px;
            display: inline-block;
            text-decoration: none;
            background-color: #888;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .back-button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <h1>View Shipping and Order Details</h1>

    <form action="select_shipping.php" method="get">
        <label for="ShippingID">Shipping ID:</label>
        <input type="number" id="ShippingID" name="ShippingID" required>
        <button type="submit" class="button">View Details</button>
    </form>

    <?php
    if (isset($_GET['ShippingID'])) {
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

        $shippingID = intval($_GET['ShippingID']);

        // Query to fetch shipping details based on ShippingID
        $sqlShipping = "SELECT * FROM shippinganddelivery WHERE ShippingID = ?";
        $stmtShipping = $conn->prepare($sqlShipping);
        $stmtShipping->bind_param("i", $shippingID);
        $stmtShipping->execute();
        $resultShipping = $stmtShipping->get_result();

        if ($resultShipping->num_rows > 0) {
            echo "<h2>Shipping Details</h2>";
            echo "<table><tr><th>Shipping ID</th><th>Order ID</th><th>Shipping Cost</th><th>Delivery Time</th><th>Customer Location</th><th>Order Size</th><th>Status</th></tr>";
            $shippingRow = $resultShipping->fetch_assoc();
            echo "<tr>
                    <td>" . htmlspecialchars($shippingRow["ShippingID"]) . "</td>
                    <td>" . htmlspecialchars($shippingRow["OrderID"]) . "</td>
                    <td>" . htmlspecialchars($shippingRow["ShippingCost"]) . "</td>
                    <td>" . htmlspecialchars($shippingRow["DeliveryTime"]) . "</td>
                    <td>" . htmlspecialchars($shippingRow["CustomerLocation"]) . "</td>
                    <td>" . htmlspecialchars($shippingRow["OrderSize"]) . "</td>
                    <td>" . htmlspecialchars($shippingRow["Status"]) . "</td>
                  </tr>";
            echo "</table>";

            // Fetch order details based on OrderID from the shipping record
            $orderID = $shippingRow["OrderID"];
            $sqlOrder = "SELECT * FROM `order` WHERE OrderID = ?";
            $stmtOrder = $conn->prepare($sqlOrder);
            $stmtOrder->bind_param("i", $orderID);
            $stmtOrder->execute();
            $resultOrder = $stmtOrder->get_result();

            if ($resultOrder->num_rows > 0) {
                echo "<h2>Order Details</h2>";
                echo "<table><tr><th>Order ID</th><th>Customer ID</th><th>Collection ID</th><th>Order Date</th><th>Status</th></tr>";
                $orderRow = $resultOrder->fetch_assoc();
                echo "<tr>
                        <td>" . htmlspecialchars($orderRow["OrderID"]) . "</td>
                        <td>" . htmlspecialchars($orderRow["CustomerID"]) . "</td>
                        <td>" . htmlspecialchars($orderRow["CollectionID"]) . "</td>
                        <td>" . htmlspecialchars($orderRow["OrderDate"]) . "</td>
                        <td>" . htmlspecialchars($orderRow["Status"]) . "</td>
                      </tr>";
                echo "</table>";
            } else {
                echo "<p>No order details found for this Order ID.</p>";
            }
        } else {
            echo "<p>No shipping details found for this Shipping ID.</p>";
        }

        $stmtShipping->close();
        $stmtOrder->close();
        $conn->close();
    }
    ?>

    <a href="shippinganddelivery.php" class="back-button">Back to Shipping List</a>
</body>
</html>
