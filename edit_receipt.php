<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Receipt</title>
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
        input[type="text"], textarea {
            width: 200px;
            padding: 5px;
            margin: 5px 0;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .button {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #555;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Edit Receipt</h1>

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

    // Check if ReceiptID is provided in the URL
    if (isset($_GET["ReceiptID"])) {
        $receiptID = $conn->real_escape_string($_GET["ReceiptID"]);

        // Fetch existing receipt data
        $sql = "SELECT * FROM receipt WHERE ReceiptID = '$receiptID'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>

            <form action="edit_receipt.php" method="post">
                <input type="hidden" name="ReceiptID" value="<?php echo htmlspecialchars($row["ReceiptID"]); ?>">

                <label for="OrderID">Order ID:</label>
                <input type="text" id="OrderID" name="OrderID" value="<?php echo htmlspecialchars($row["OrderID"]); ?>"><br>

                <label for="CustomerID">Customer ID:</label>
                <input type="text" id="CustomerID" name="CustomerID" value="<?php echo htmlspecialchars($row["CustomerID"]); ?>"><br>

                <label for="CollectionID">Collection ID:</label>
                <input type="text" id="CollectionID" name="CollectionID" value="<?php echo htmlspecialchars($row["CollectionID"]); ?>"><br>

                <label for="Details">Details:</label>
                <textarea id="Details" name="Details"><?php echo htmlspecialchars($row["Details"]); ?></textarea><br>

                <label for="TaxID">Tax ID:</label>
                <input type="text" id="TaxID" name="TaxID" value="<?php echo htmlspecialchars($row["TaxID"]); ?>"><br>

                <input type="submit" value="Update Receipt">
            </form>

            <?php
        } else {
            echo "<p>No receipt found with ID: $receiptID</p>";
        }
    } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Process form submission to update receipt data
        $receiptID = $conn->real_escape_string($_POST["ReceiptID"]);
        $orderID = $conn->real_escape_string($_POST["OrderID"]);
        $customerID = $conn->real_escape_string($_POST["CustomerID"]);
        $collectionID = $conn->real_escape_string($_POST["CollectionID"]);
        $details = $conn->real_escape_string($_POST["Details"]);
        $taxID = $conn->real_escape_string($_POST["TaxID"]);

        // Update the receipt in the database
        $sql = "UPDATE receipt SET OrderID='$orderID', CustomerID='$customerID', CollectionID='$collectionID', Details='$details', TaxID='$taxID' WHERE ReceiptID='$receiptID'";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Receipt updated successfully!</p>";
        } else {
            echo "<p>Error updating receipt: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>No ReceiptID provided.</p>";
    }

    $conn->close();
    ?>

    <a href="receipt.php" class="button">Back to Receipt List</a>
</body>
</html>
