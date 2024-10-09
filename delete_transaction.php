<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Transaction</title>
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
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #ff3333;
        }
    </style>
</head>
<body>
    <h1>Delete Transaction</h1>
    <form action="" method="POST">
        <label for="TransactionID">Transaction ID:</label>
        <input type="text" id="TransactionID" name="TransactionID" required>
        <button type="submit" name="delete" class="button">Delete Transaction</button>
    </form>
    
    <div>
        <a href="transaction.php" class="button">Back to Transaction List</a>
    </div>

    <?php
    if (isset($_POST['delete'])) {
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

        // Delete transaction from database
        $sql = "DELETE FROM transaction WHERE TransactionID = '$transactionID'";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Transaction deleted successfully.</p>";
        } else {
            echo "<p>Error deleting transaction: " . $conn->error . "</p>";
        }

        // Close connection
        $conn->close();
    }
    ?>
</body>
</html>
