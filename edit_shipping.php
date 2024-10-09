<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Shipping Record</title>
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
            width: 100%;
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
    <h1>Edit Shipping Record</h1>

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

    if (isset($_GET['ShippingID'])) {
        $shippingID = intval($_GET['ShippingID']);

        // Fetch current shipping record details
        $sql = "SELECT * FROM shippinganddelivery WHERE ShippingID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $shippingID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "<p>No shipping record found with Shipping ID: $shippingID</p>";
            exit();
        }
    } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Update the shipping record
        $shippingID = intval($_POST['ShippingID']);
        $orderID = $_POST['OrderID'];
        $shippingCost = $_POST['ShippingCost'];
        $deliveryTime = $_POST['DeliveryTime'];
        $customerLocation = $_POST['CustomerLocation'];
        $orderSize = $_POST['OrderSize'];
        $status = $_POST['Status'];

        $sql = "UPDATE shippinganddelivery SET OrderID = ?, ShippingCost = ?, DeliveryTime = ?, CustomerLocation = ?, OrderSize = ?, Status = ? WHERE ShippingID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("idssssi", $orderID, $shippingCost, $deliveryTime, $customerLocation, $orderSize, $status, $shippingID);

        if ($stmt->execute()) {
            echo "<p>Shipping record updated successfully!</p>";
        } else {
            echo "<p>Error updating record: " . $stmt->error . "</p>";
        }
    } else {
        echo "<p>No Shipping ID provided.</p>";
        exit();
    }
    ?>

    <form action="edit_shipping.php" method="post">
        <input type="hidden" name="ShippingID" value="<?php echo htmlspecialchars($row['ShippingID']); ?>">

        <label for="OrderID">Order ID:</label>
        <input type="number" id="OrderID" name="OrderID" value="<?php echo htmlspecialchars($row['OrderID']); ?>" required>

        <label for="ShippingCost">Shipping Cost:</label>
        <input type="number" step="0.01" id="ShippingCost" name="ShippingCost" value="<?php echo htmlspecialchars($row['ShippingCost']); ?>" required>

        <label for="DeliveryTime">Delivery Time:</label>
        <input type="date" id="DeliveryTime" name="DeliveryTime" value="<?php echo htmlspecialchars($row['DeliveryTime']); ?>" required>

        <label for="CustomerLocation">Customer Location:</label>
        <input type="text" id="CustomerLocation" name="CustomerLocation" value="<?php echo htmlspecialchars($row['CustomerLocation']); ?>" required>

        <label for="OrderSize">Order Size:</label>
        <input type="text" id="OrderSize" name="OrderSize" value="<?php echo htmlspecialchars($row['OrderSize']); ?>" required>

        <label for="Status">Status:</label>
        <select id="Status" name="Status" required>
            <option value="Pending" <?php if ($row['Status'] == 'Pending') echo 'selected'; ?>>Pending</option>
            <option value="Shipped" <?php if ($row['Status'] == 'Shipped') echo 'selected'; ?>>Shipped</option>
            <option value="Delivered" <?php if ($row['Status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
        </select>

        <button type="submit" class="button">Update Shipping</button>
    </form>

    <a href="shippinganddelivery.php" class="back-button">Back to Shipping List</a>

    <?php $stmt->close(); $conn->close(); ?>
</body>
</html>
