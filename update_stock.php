<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Stock Levels</title>
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
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Update Stock Levels for Delivered Orders</h1>
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

    // SQL query to find delivered items and update their stock levels
    $sql = "SELECT sd.OrderID, cl.CollectionID, cl.Name 
            FROM shippinganddelivery sd
            JOIN `order` o ON sd.OrderID = o.OrderID
            JOIN collectionlist cl ON o.CollectionID = cl.CollectionID
            WHERE sd.Status = 'Delivered'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $collectionID = $row['CollectionID'];

            // Decrement the stock level for the item in the inventory table
            $updateSql = "UPDATE inventory SET StockLevel = StockLevel - 1 WHERE CollectionID = '$collectionID' AND StockLevel > 0";

            if ($conn->query($updateSql) === TRUE) {
                echo "<p>Stock level updated for item: " . htmlspecialchars($row['Name']) . " (Collection ID: " . htmlspecialchars($collectionID) . ").</p>";
            } else {
                echo "<p>Error updating stock level for item: " . htmlspecialchars($row['Name']) . ". " . $conn->error . "</p>";
            }
        }
    } else {
        echo "<p>No items with 'Delivered' status found.</p>";
    }

    $conn->close();
    ?>

    <a href="main.php" class="button">Back to Main Page</a>
</body>
</html>
