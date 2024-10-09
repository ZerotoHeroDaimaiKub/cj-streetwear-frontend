<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Receipt</title>
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
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <h1>Delete Receipt</h1>

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

        // Delete query
        $sql = "DELETE FROM receipt WHERE ReceiptID = '$receiptID'";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Receipt deleted successfully!</p>";
        } else {
            echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }

        $conn->close();
    }
    ?>

    <form action="delete_receipt.php" method="post">
        <label for="ReceiptID">Receipt ID:</label>
        <input type="text" id="ReceiptID" name="ReceiptID" required><br>
        
        <input type="submit" class="button" value="Delete Receipt">
    </form>

    <br><a href="receipt.php" class="button" style="background-color: #4CAF50;">Back to Receipt List</a>
</body>
</html>
