<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Order</title>
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
            width: 300px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"], input[type="date"], select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #45a049;
        }
        .button-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Add Order</h1>
    
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

    // Fetch customers and collections for the dropdowns
    $customers = $conn->query("SELECT CustomerID, Name FROM customer");
    $collections = $conn->query("SELECT CollectionID, Name FROM collectionlist");

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $customerID = $_POST["CustomerID"];
        $collectionID = $_POST["CollectionID"];
        $orderDate = $_POST["OrderDate"];
        $status = $_POST["Status"];

        $sql = "INSERT INTO `order` (CustomerID, CollectionID, OrderDate, Status)
                VALUES ('$customerID', '$collectionID', '$orderDate', '$status')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>New order added successfully!</p>";
        } else {
            echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }
    }

    $conn->close();
    ?>

    <form action="add_order.php" method="post">
        <label for="CustomerID">Customer:</label>
        <select name="CustomerID" id="CustomerID" required>
            <option value="">Select Customer</option>
            <?php
            // Re-establish connection to fetch dropdown options
            $conn = new mysqli($servername, $username, $password, $dbname);
            while ($row = $customers->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($row["CustomerID"]) . "'>" . htmlspecialchars($row["Name"]) . "</option>";
            }
            $conn->close();
            ?>
        </select>

        <label for="CollectionID">Collection:</label>
        <select name="CollectionID" id="CollectionID" required>
            <option value="">Select Collection</option>
            <?php
            // Re-establish connection to fetch dropdown options
            $conn = new mysqli($servername, $username, $password, $dbname);
            while ($row = $collections->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($row["CollectionID"]) . "'>" . htmlspecialchars($row["Name"]) . "</option>";
            }
            $conn->close();
            ?>
        </select>

        <label for="OrderDate">Order Date:</label>
        <input type="date" name="OrderDate" id="OrderDate" required>

        <label for="Status">Status:</label>
        <select name="Status" id="Status" required>
            <option value="Pending">Pending</option>
            <option value="Shipped">Shipped</option>
            <option value="Delivered">Delivered</option>
        </select>

        <div class="button-container">
            <input type="submit" value="Add Order" class="button">
        </div>

        <div>
        <a href="order.php" class="button">Back to Order</a>
    </div>
    </form>
</body>
</html>
