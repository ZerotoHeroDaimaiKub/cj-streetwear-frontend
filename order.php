<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
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
        .button-container {
            margin: 20px;
        }
        .button {
            padding: 10px 20px;
            margin: 5px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Order Management</h1>
    <h2>List of Orders</h2>
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

    // Query to fetch orders along with customer and collection details
    $sql = "SELECT o.OrderID, o.CustomerID, o.CollectionID, o.OrderDate, o.Status, c.Name AS CustomerName, cl.Name AS CollectionName
            FROM `order` o
            JOIN customer c ON o.CustomerID = c.CustomerID
            JOIN collectionlist cl ON o.CollectionID = cl.CollectionID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table><tr><th>Order ID</th><th>Customer Name</th><th>Collection Name</th><th>Order Date</th><th>Status</th><th>Actions</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["OrderID"]) . "</td>
                    <td>" . htmlspecialchars($row["CustomerName"]) . "</td>
                    <td>" . htmlspecialchars($row["CollectionName"]) . "</td>
                    <td>" . htmlspecialchars($row["OrderDate"]) . "</td>
                    <td>" . htmlspecialchars($row["Status"]) . "</td>
                    <td>
                        <a href='edit_order.php?OrderID=" . $row["OrderID"] . "' class='button'>Edit</a>
                        <a href='delete_order.php?OrderID=" . $row["OrderID"] . "' class='button'>Delete</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No orders found.</p>";
    }

    $conn->close();
    ?>

    <div class="button-container">
        <a href="add_order.php" class="button">Add</a>
        <a href="select_order.php" class="button">Select</a>
        <a href="main.php" class="button">Back to Main Page</a>
    </div>
</body>
</html>
