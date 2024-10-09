<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaction</title>
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
        input[type="text"], input[type="datetime-local"] {
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
    </style>
</head>
<body>
    <h1>Edit Transaction</h1>

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

    // Check if TransactionID is provided
    if (isset($_GET['TransactionID'])) {
        $transactionID = $_GET['TransactionID'];

        // Fetch transaction data for the given TransactionID
        $sql = "SELECT * FROM transaction WHERE TransactionID = '$transactionID'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Display the form with the current transaction details
            $row = $result->fetch_assoc();
            $orderID = $row["OrderID"];
            $paymentMethod = $row["PaymentMethod"];
            $paymentDetails = $row["PaymentDetails"];
            $timestamp = $row["Timestamp"];
        } else {
            echo "<p>No transaction found with ID $transactionID.</p>";
            exit();
        }
    } else {
        echo "<p>No TransactionID provided.</p>";
        exit();
    }

    // Update the transaction data if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $orderID = $_POST["OrderID"];
        $paymentMethod = $_POST["PaymentMethod"];
        $paymentDetails = $_POST["PaymentDetails"];
        $timestamp = $_POST["Timestamp"];

        // Update query
        $sql = "UPDATE transaction SET 
                    OrderID = '$orderID', 
                    PaymentMethod = '$paymentMethod', 
                    PaymentDetails = '$paymentDetails', 
                    Timestamp = '$timestamp' 
                WHERE TransactionID = '$transactionID'";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Transaction updated successfully.</p>";
        } else {
            echo "<p>Error updating transaction: " . $conn->error . "</p>";
        }
    }

    $conn->close();
    ?>

    <!-- Edit Transaction Form -->
    <form method="POST" action="">
        <label for="OrderID">Order ID:</label>
        <input type="text" id="OrderID" name="OrderID" value="<?php echo htmlspecialchars($orderID); ?>" required>

        <label for="PaymentMethod">Payment Method:</label>
        <input type="text" id="PaymentMethod" name="PaymentMethod" value="<?php echo htmlspecialchars($paymentMethod); ?>" required>

        <label for="PaymentDetails">Payment Details:</label>
        <input type="text" id="PaymentDetails" name="PaymentDetails" value="<?php echo htmlspecialchars($paymentDetails); ?>" required>

        <label for="Timestamp">Timestamp:</label>
        <input type="datetime-local" id="Timestamp" name="Timestamp" value="<?php echo htmlspecialchars($timestamp); ?>" required>

        <button type="submit" class="button">Update Transaction</button>
    </form>

    <div>
        <a href="transaction.php" class="button">Back to Transaction List</a>
    </div>
</body>
</html>
