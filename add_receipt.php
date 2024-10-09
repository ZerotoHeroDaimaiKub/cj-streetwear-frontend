<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Receipt</title>
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
            display: inline-block;
            margin-top: 20px;
            text-align: left;
        }
        label {
            display: inline-block;
            width: 120px;
            text-align: right;
            margin-right: 10px;
        }
        input[type="text"] {
            width: 200px;
            padding: 5px;
            margin: 5px 0;
        }
        .button {
            padding: 10px 20px;
            margin-top: 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Add New Receipt</h1>

    <?php
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

        // Retrieve and sanitize form inputs
        $orderID = $conn->real_escape_string($_POST["OrderID"]);
        $customerID = $conn->real_escape_string($_POST["CustomerID"]);
        $collectionID = $conn->real_escape_string($_POST["CollectionID"]);
        $details = $conn->real_escape_string($_POST["Details"]);
        $taxID = $conn->real_escape_string($_POST["TaxID"]);

        // Insert query
        $sql = "INSERT INTO receipt (OrderID, CustomerID, CollectionID, Details, TaxID) 
                VALUES ('$orderID', '$customerID', '$collectionID', '$details', '$taxID')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>New receipt added successfully!</p>";
        } else {
            echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }

        $conn->close();
    }
    ?>

    <form action="add_receipt.php" method="post">
        <label for="OrderID">Order ID:</label>
        <input type="text" id="OrderID" name="OrderID" required><br>
        
        <label for="CustomerID">Customer ID:</label>
        <input type="text" id="CustomerID" name="CustomerID" required><br>
        
        <label for="CollectionID">Collection ID:</label>
        <input type="text" id="CollectionID" name="CollectionID" required><br>
        
        <label for="Details">Details:</label>
        <input type="text" id="Details" name="Details"><br>
        
        <label for="TaxID">Tax ID:</label>
        <input type="text" id="TaxID" name="TaxID"><br>
        
        <input type="submit" class="button" value="Add Receipt">
    </form>

    <br><a href="receipt.php" class="button">Back to Receipt List</a>
</body>
</html>
