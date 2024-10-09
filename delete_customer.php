<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Customer</title>
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
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
    <h1>Delete Customer</h1>

    <form action="delete_customer.php" method="POST">
        <label for="customer_id">Customer ID:</label>
        <input type="text" name="customer_id" required>

        <input type="submit" name="submit" value="Delete Customer">
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
        $stmt = $conn->prepare("DELETE FROM customer WHERE CustomerID = ?");
        $stmt->bind_param("i", $customer_id);

        // Set parameters and execute
        $customer_id = $_POST['customer_id'];

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "<p>Customer with ID $customer_id has been deleted successfully.</p>";
            } else {
                echo "<p>No customer found with ID $customer_id.</p>";
            }
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
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
