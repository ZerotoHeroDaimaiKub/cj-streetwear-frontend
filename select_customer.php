<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Customer</title>
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
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            margin-top: 20px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
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
    <h1>Select Customer</h1>

    <form action="select_customer.php" method="POST">
        <label for="customer_id">Customer ID:</label>
        <input type="text" name="customer_id" required>
        <input type="submit" name="submit" value="View Customer">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Database connection parameters
        $servername = "127.0.0.1";
        $username = "root";
        $password = "Timeza.084"; // Use your actual password
        $dbname = "cj_streetwear";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind
        $stmt = $conn->prepare("SELECT * FROM customer WHERE CustomerID = ?");
        $stmt->bind_param("i", $customer_id);

        // Set parameters and execute
        $customer_id = $_POST['customer_id'];
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<table><tr><th>Customer ID</th><th>Name</th><th>Email</th><th>Password</th><th>Order History</th><th>Order Tracking</th><th>Location</th><th>Phone Number</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["CustomerID"]) . "</td>
                        <td>" . htmlspecialchars($row["Name"]) . "</td>
                        <td>" . htmlspecialchars($row["Email"]) . "</td>
                        <td>" . htmlspecialchars($row["Password"]) . "</td>
                        <td>" . htmlspecialchars($row["OrderHistory"]) . "</td>
                        <td>" . htmlspecialchars($row["OrderTracking"]) . "</td>
                        <td>" . htmlspecialchars($row["CustomerLocation"]) . "</td>
                        <td>" . htmlspecialchars($row["PhoneNumber"]) . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No customer found with ID $customer_id.</p>";
        }

        // Close the connection
        $stmt->close();
        $conn->close();
    }
    ?>

    <br>
    <a href="customer.php">Back to Customer List</a>
</body>
</html>
