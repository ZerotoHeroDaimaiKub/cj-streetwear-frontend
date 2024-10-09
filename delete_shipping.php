<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Shipping Record</title>
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
            margin: 0 auto;
            width: 300px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label, input {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }
        input {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .button {
            background-color: #d9534f;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .button:hover {
            background-color: #c9302c;
        }
        .back-button {
            margin-top: 20px;
            display: inline-block;
            text-decoration: none;
            background-color: #888;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .back-button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <h1>Delete Shipping Record</h1>

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

        // Prepare and bind
        $stmt = $conn->prepare("DELETE FROM shippinganddelivery WHERE ShippingID = ?");
        $stmt->bind_param("i", $shippingID);

        // Set parameters and execute
        $shippingID = $_POST["shippingID"];
        
        if ($stmt->execute()) {
            echo "<p>Shipping record deleted successfully!</p>";
        } else {
            echo "<p>Error deleting record: " . $stmt->error . "</p>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>

    <form action="delete_shipping.php" method="post">
        <label for="shippingID">Shipping ID:</label>
        <input type="number" id="shippingID" name="shippingID" required>
        <button type="submit" class="button">Delete Shipping</button>
    </form>

    <a href="shippinganddelivery.php" class="back-button">Back to Shipping List</a>
</body>
</html>
