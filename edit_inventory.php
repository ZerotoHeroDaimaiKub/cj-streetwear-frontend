<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Inventory Item</title>
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
        input[type="number"], input[type="text"] {
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
        .back-button {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <h1>Edit Inventory Item</h1>

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

    if (isset($_GET["InventoryID"])) {
        $inventoryID = $conn->real_escape_string($_GET["InventoryID"]);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $collectionID = $conn->real_escape_string($_POST["CollectionID"]);
            $employeeID = $conn->real_escape_string($_POST["EmployeeID"]);
            $stockLevel = $conn->real_escape_string($_POST["StockLevel"]);
            $status = $conn->real_escape_string($_POST["Status"]);

            $sql = "UPDATE inventory SET 
                        CollectionID = '$collectionID', 
                        EmployeeID = '$employeeID', 
                        StockLevel = '$stockLevel', 
                        Status = '$status' 
                    WHERE InventoryID = '$inventoryID'";

            if ($conn->query($sql) === TRUE) {
                echo "<p>Inventory item updated successfully.</p>";
            } else {
                echo "<p>Error updating inventory item: " . $conn->error . "</p>";
            }
        }

        $sql = "SELECT * FROM inventory WHERE InventoryID = '$inventoryID'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>

            <form action="edit_inventory.php?InventoryID=<?php echo $inventoryID; ?>" method="post">
                <label for="CollectionID">Collection ID:</label>
                <input type="number" id="CollectionID" name="CollectionID" value="<?php echo htmlspecialchars($row['CollectionID']); ?>" required>

                <label for="EmployeeID">Employee ID:</label>
                <input type="number" id="EmployeeID" name="EmployeeID" value="<?php echo htmlspecialchars($row['EmployeeID']); ?>" required>

                <label for="StockLevel">Stock Level:</label>
                <input type="number" id="StockLevel" name="StockLevel" value="<?php echo htmlspecialchars($row['StockLevel']); ?>" required>

                <label for="Status">Status:</label>
                <input type="text" id="Status" name="Status" value="<?php echo htmlspecialchars($row['Status']); ?>" required>

                <input type="submit" value="Update Inventory" class="button">
            </form>

            <?php
        } else {
            echo "<p>No inventory item found with Inventory ID: $inventoryID</p>";
        }
    } else {
        echo "<p>No Inventory ID provided.</p>";
    }

    $conn->close();
    ?>

    <a href="inventory.php" class="back-button">Back to Inventory List</a>
</body>
</html>
