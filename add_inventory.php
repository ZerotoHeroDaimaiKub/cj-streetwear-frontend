<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Inventory Item</title>
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
        input[type="text"], input[type="number"] {
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
    <h1>Add Inventory Item</h1>

    <form action="add_inventory.php" method="post">
        <label for="collectionID">Collection ID:</label>
        <input type="number" id="collectionID" name="collectionID" required>

        <label for="employeeID">Employee ID:</label>
        <input type="number" id="employeeID" name="employeeID" required>

        <label for="stockLevel">Stock Level:</label>
        <input type="number" id="stockLevel" name="stockLevel" required>

        <label for="status">Status:</label>
        <input type="text" id="status" name="status" required>

        <input type="submit" value="Add Inventory" class="button">
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
        $collectionID = $conn->real_escape_string($_POST["collectionID"]);
        $employeeID = $conn->real_escape_string($_POST["employeeID"]);
        $stockLevel = $conn->real_escape_string($_POST["stockLevel"]);
        $status = $conn->real_escape_string($_POST["status"]);

        // SQL to insert new inventory item
        $sql = "INSERT INTO inventory (CollectionID, EmployeeID, StockLevel, Status)
                VALUES ('$collectionID', '$employeeID', '$stockLevel', '$status')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>New inventory item added successfully!</p>";
        } else {
            echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }

        // Close connection
        $conn->close();
    }
    ?>
</body>
</html>
