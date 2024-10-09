<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Transaction</title>
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
        input[type="text"], input[type="datetime-local"], select {
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
    <h1>Add New Transaction</h1>
    <form action="" method="POST">
        <label for="OrderID">Order ID:</label>
        <input type="text" id="OrderID" name="OrderID" required>
        
        <label for="PaymentMethod">Payment Method:</label>
        <select id="PaymentMethod" name="PaymentMethod" required>
            <option value="Credit Card">Credit Card</option>
            <option value="PayPal">PayPal</option>
            <option value="Bank Transfer">Bank Transfer</option>
        </select>
        
        <label for="PaymentDetails">Payment Details:</label>
        <input type="text" id="PaymentDetails" name="PaymentDetails" required>
        
        <label for="Timestamp">Timestamp:</label>
        <input type="datetime-local" id="Timestamp" name="Timestamp" required>
        
        <button type="submit" name="submit" class="button">Add Transaction</button>
    </form>

    <div>
        <a href="transaction.php" class="button">Back to Transaction List</a>
    </div>

    <?php
    if (isset($_POST['submit'])) {
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
        $orderID = $_POST['OrderID'];
        $paymentMethod = $_POST['PaymentMethod'];
        $paymentDetails = $_POST['PaymentDetails'];
        $timestamp = $_POST['Timestamp'];

        // Insert data into transaction table
        $sql = "INSERT INTO transaction (OrderID, PaymentMethod, PaymentDetails, Timestamp)
                VALUES ('$orderID', '$paymentMethod', '$paymentDetails', '$timestamp')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Transaction added successfully.</p>";
        } else {
            echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }

        // Close connection
        $conn->close();
    }
    ?>
</body>
</html>
