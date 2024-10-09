<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Shipping Record</title>
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
        label, input, select {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }
        input, select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .button:hover {
            background-color: #45a049;
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
    <h1>Add Shipping Record</h1>
    
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
        $stmt = $conn->prepare("INSERT INTO shippinganddelivery (OrderID, ShippingCost, DeliveryTime, CustomerLocation, OrderSize, Status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("idssss", $orderID, $shippingCost, $deliveryTime, $customerLocation, $orderSize, $status);

        // Set parameters and execute
        $orderID = $_POST["orderID"];
        $shippingCost = $_POST["shippingCost"];
        $deliveryTime = $_POST["deliveryTime"];
        $customerLocation = $_POST["customerLocation"];
        $orderSize = $_POST["orderSize"];
        $status = $_POST["status"];
        
        if ($stmt->execute()) {
            echo "<p>Shipping record added successfully!</p>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>

    <form action="add_shipping.php" method="post">
        <label for="orderID">Order ID:</label>
        <input type="number" id="orderID" name="orderID" required>

        <label for="shippingCost">Shipping Cost:</label>
        <input type="number" step="0.01" id="shippingCost" name="shippingCost" required>

        <label for="deliveryTime">Delivery Time:</label>
        <input type="date" id="deliveryTime" name="deliveryTime" required>

        <label for="customerLocation">Customer Location:</label>
        <input type="text" id="customerLocation" name="customerLocation" required>

        <label for="orderSize">Order Size:</label>
        <input type="text" id="orderSize" name="orderSize" required>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="Pending">Pending</option>
            <option value="Shipped">Shipped</option>
            <option value="Delivered">Delivered</option>
        </select>

        <button type="submit" class="button">Add Shipping</button>
    </form>

    <a href="shippinganddelivery.php" class="back-button">Back to Shipping List</a>
</body>
</html>
