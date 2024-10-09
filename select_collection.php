<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Collection</title>
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
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label, input {
            display: block;
            width: 100%;
            margin: 10px 0;
        }
        input[type="number"] {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .button {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #555;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
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
    <h1>Select Collection</h1>

    <form action="select_collection.php" method="post">
        <label for="collectionID">Collection ID:</label>
        <input type="number" name="collectionID" id="collectionID" required>
        
        <input type="submit" value="View Collection">
    </form>

    <a href="collectionlist.php" class="button">Back to Collection List</a>

    <?php
    // Handle form submission
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
        $stmt = $conn->prepare("SELECT * FROM collectionlist WHERE CollectionID = ?");
        $stmt->bind_param("i", $collectionID);

        // Set parameters and execute
        $collectionID = $_POST["collectionID"];
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<table><tr><th>Collection ID</th><th>Name</th><th>Price</th><th>Size</th><th>Color</th><th>Stock Level</th><th>Images</th><th>Listing Details</th><th>Description</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["CollectionID"]) . "</td>
                        <td>" . htmlspecialchars($row["Name"]) . "</td>
                        <td>" . htmlspecialchars($row["Price"]) . "</td>
                        <td>" . htmlspecialchars($row["Size"]) . "</td>
                        <td>" . htmlspecialchars($row["Color"]) . "</td>
                        <td>" . htmlspecialchars($row["StockLevel"]) . "</td>
                        <td><a href='" . htmlspecialchars($row["Images"]) . "' target='_blank'>View Image</a></td>
                        <td>" . htmlspecialchars($row["ListingDetails"]) . "</td>
                        <td>" . htmlspecialchars($row["Description"]) . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No collection found with ID $collectionID.</p>";
        }

        // Close connection
        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
