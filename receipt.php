<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f0f0f0;
        }
        h1 {
            margin-top: 20px;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 90%;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        .button-container {
            margin: 20px;
        }
        .button {
            padding: 10px 20px;
            margin: 5px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #45a049;
        }
        .edit-button {
            background-color: #FFA500;
        }
        .edit-button:hover {
            background-color: #FF8C00;
        }
    </style>
</head>
<body>
    <h1>Receipt Management</h1>
    <h2>List of Receipts</h2>
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

    // Query to fetch receipts
    $sql = "SELECT * FROM receipt";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table><tr><th>Receipt ID</th><th>Order ID</th><th>Customer ID</th><th>Collection ID</th><th>Details</th><th>Tax ID</th><th>Actions</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["ReceiptID"]) . "</td>
                    <td>" . htmlspecialchars($row["OrderID"]) . "</td>
                    <td>" . htmlspecialchars($row["CustomerID"]) . "</td>
                    <td>" . htmlspecialchars($row["CollectionID"]) . "</td>
                    <td>" . htmlspecialchars($row["Details"]) . "</td>
                    <td>" . htmlspecialchars($row["TaxID"]) . "</td>
                    <td><a href='edit_receipt.php?ReceiptID=" . $row["ReceiptID"] . "' class='button edit-button'>Edit</a></td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No receipts found.</p>";
    }

    $conn->close();
    ?>

    <div class="button-container">
        <a href="add_receipt.php" class="button">Add</a>
        <a href="delete_receipt.php" class="button">Delete</a>
        <a href="select_receipt.php" class="button">Select</a>
        <a href="main.php" class="button">Back to Main Page</a>
    </div>
</body>
</html>
