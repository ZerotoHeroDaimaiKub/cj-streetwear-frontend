<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Inventory Item</title>
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
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            width: 300px;
            background-color: #fff;
            border-radius: 8px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .button {
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #45a049;
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
        .back-button {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <h1>Select Inventory Item</h1>

    <form action="select_inventory.php" method="post">
        <label for="inventoryID">Inventory ID:</label>
        <input type="number" id="inventoryID" name="inventoryID" required>

        <input type="submit" value="View Inventory Details" class="button">
    </form>

    <a href="inventory.php" class="back-button">Back to Inventory List</a>

    <?php
    // Check if form data has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        // Get form data
        $inventoryID = $conn->real_escape_string($_POST["inventoryID"]);

        // SQL to select inventory item by InventoryID
        $sql = "SELECT * FROM inventory WHERE InventoryID = '$inventoryID'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table><tr><th>Inventory ID</th><th>Collection ID</th><th>Employee ID</th><th>Stock Level</th><th>Status</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["InventoryID"]) . "</td>
                        <td>" . htmlspecialchars($row["CollectionID"]) . "</td>
                        <td>" . htmlspecialchars($row["EmployeeID"]) . "</td>
                        <td>" . htmlspecialchars($row["StockLevel"]) . "</td>
                        <td>" . htmlspecialchars($row["Status"]) . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No inventory item found with Inventory ID: $inventoryID.</p>";
        }

        // Close connection
        $conn->close();
    }
    ?>
</body>
</html>
