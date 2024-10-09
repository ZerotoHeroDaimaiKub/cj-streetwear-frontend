<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Receipt</title>
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
    <h1>Select Receipt</h1>

    <form action="select_receipt.php" method="post">
        <label for="ReceiptID">Receipt ID:</label>
        <input type="text" id="ReceiptID" name="ReceiptID" required><br>
        <input type="submit" class="button" value="Select Receipt">
    </form>

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

        // Retrieve and sanitize ReceiptID
        $receiptID = $conn->real_escape_string($_POST["ReceiptID"]);

        // Select query
        $sql = "SELECT * FROM receipt WHERE ReceiptID = '$receiptID'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table><tr><th>Receipt ID</th><th>Order ID</th><th>Customer ID</th><th>Collection ID</th><th>Details</th><th>Tax ID</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["ReceiptID"]) . "</td>
                        <td>" . htmlspecialchars($row["OrderID"]) . "</td>
                        <td>" . htmlspecialchars($row["CustomerID"]) . "</td>
                        <td>" . htmlspecialchars($row["CollectionID"]) . "</td>
                        <td>" . htmlspecialchars($row["Details"]) . "</td>
                        <td>" . htmlspecialchars($row["TaxID"]) . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No receipt found with ID: $receiptID</p>";
        }

        $conn->close();
    }
    ?>

    <br><a href="receipt.php" class="button" style="background-color: #4CAF50;">Back to Receipt List</a>
</body>
</html>
