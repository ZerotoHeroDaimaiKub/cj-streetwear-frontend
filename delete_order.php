<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            margin-top: 50px;
            display: inline-block;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
        }
        .button-container {
            margin-top: 20px;
        }
        .button {
            padding: 10px 20px;
            margin: 5px;
            background-color: #d9534f;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
        }
        .button:hover {
            background-color: #c9302c;
        }
        .cancel-btn {
            background-color: #5bc0de;
        }
        .cancel-btn:hover {
            background-color: #31b0d5;
        }
    </style>
</head>
<body>
    <h1>Delete Order</h1>

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

    if (isset($_GET['OrderID'])) {
        $orderID = intval($_GET['OrderID']);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // If the deletion is confirmed, delete the order from the database
            $sql = "DELETE FROM `order` WHERE OrderID = $orderID";

            if ($conn->query($sql) === TRUE) {
                echo "<p>Order deleted successfully.</p>";
            } else {
                echo "<p>Error deleting order: " . $conn->error . "</p>";
            }
        } else {
            // Display confirmation message
            echo "<p>Are you sure you want to delete this order?</p>";
            echo "<div class='button-container'>
                    <form method='post' action=''>
                        <button type='submit' class='button'>Yes, Delete</button>
                        <a href='order.php' class='button cancel-btn'>Cancel</a>
                    </form>
                  </div>";
        }
    } else {
        echo "<p>No Order ID provided.</p>";
    }

    $conn->close();
    ?>

    <a href="order.php" class="button cancel-btn">Back to Order List</a>
</body>
</html>
