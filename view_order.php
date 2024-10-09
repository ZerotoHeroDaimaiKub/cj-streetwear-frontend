<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        h1 {
            margin-top: 20px;
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
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
    <h1>Order Details</h1>

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

    // Check if OrderID is set in the URL
    if (isset($_GET['OrderID'])) {
        $orderID = intval($_GET['OrderID']);

        // Query to fetch order details
        $sql = "SELECT * FROM `order` WHERE OrderID = $orderID";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Display order details
            echo "<div class='container'><table>";
            echo "<tr><th>Order ID</th><th>Customer ID</th><th>Collection ID</th><th>Order Date</th><th>Status</th></tr>";
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["OrderID"]) . "</td>
                        <td>" . htmlspecialchars($row["CustomerID"]) . "</td>
                        <td>" . htmlspecialchars($row["CollectionID"]) . "</td>
                        <td>" . htmlspecialchars($row["OrderDate"]) . "</td>
                        <td>" . htmlspecialchars($row["Status"]) . "</td>
                      </tr>";
            }
            echo "</table></div>";
        } else {
            echo "<p>No order found for ID $orderID.</p>";
        }
    } else {
        echo "<p>No Order ID provided.</p>";
    }

    $conn->close();
    ?>

    <a href="order.php" class="back-link">Back to Order List</a>
</body>
</html>
