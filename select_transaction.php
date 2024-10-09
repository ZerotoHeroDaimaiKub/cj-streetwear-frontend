<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Transaction</title>
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
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .button {
            padding: 10px 20px;
            margin: 10px;
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
    </style>
</head>
<body>
    <h1>Select Transaction</h1>
    <form action="" method="POST">
        <label for="TransactionID">Transaction ID:</label>
        <input type="text" id="TransactionID" name="TransactionID" required>
        <button type="submit" name="select" class="button">View Transaction</button>
    </form>
    
    <div>
        <a href="transaction.php" class="button">Back to Transaction List</a>
    </div>

    <?php
    if (isset($_POST['select'])) {
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

        // Get Transaction ID from form
        $transactionID = $_POST['TransactionID'];

        // Query to select the transaction
        $sql = "SELECT * FROM transaction WHERE TransactionID = '$transactionID'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table><tr><th>Transaction ID</th><th>Order ID</th><th>Payment Method</th><th>Payment Details</th><th>Timestamp</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["TransactionID"]) . "</td>
                        <td>" . htmlspecialchars($row["OrderID"]) . "</td>
                        <td>" . htmlspecialchars($row["PaymentMethod"]) . "</td>
                        <td>" . htmlspecialchars($row["PaymentDetails"]) . "</td>
                        <td>" . htmlspecialchars($row["Timestamp"]) . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No transaction found with ID $transactionID.</p>";
        }

        // Close connection
        $conn->close();
    }
    ?>
</body>
</html>
