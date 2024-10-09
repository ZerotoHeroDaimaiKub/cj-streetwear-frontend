<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Collection</title>
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
        input[type="text"], input[type="number"] {
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
    </style>
</head>
<body>
    <h1>Edit Collection</h1>

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

    // Handle form submission for update
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['CollectionID'])) {
        $collectionID = $_POST['CollectionID'];
        $name = $_POST['Name'];
        $price = $_POST['Price'];
        $size = $_POST['Size'];
        $color = $_POST['Color'];
        $stockLevel = $_POST['StockLevel'];
        $images = $_POST['Images'];
        $listingDetails = $_POST['ListingDetails'];
        $description = $_POST['Description'];

        $sql = "UPDATE collectionlist SET Name=?, Price=?, Size=?, Color=?, StockLevel=?, Images=?, ListingDetails=?, Description=? WHERE CollectionID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdssisssi", $name, $price, $size, $color, $stockLevel, $images, $listingDetails, $description, $collectionID);

        if ($stmt->execute()) {
            echo "<p>Collection updated successfully!</p>";
        } else {
            echo "<p>Error updating collection: " . $conn->error . "</p>";
        }
    } elseif (isset($_GET['CollectionID'])) {
        // Fetch collection details
        $collectionID = $_GET['CollectionID'];
        $sql = "SELECT * FROM collectionlist WHERE CollectionID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $collectionID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>

            <form action="edit_collection.php" method="post">
                <input type="hidden" name="CollectionID" value="<?php echo htmlspecialchars($row['CollectionID']); ?>">
                <label for="Name">Name:</label>
                <input type="text" name="Name" value="<?php echo htmlspecialchars($row['Name']); ?>" required>
                
                <label for="Price">Price:</label>
                <input type="number" name="Price" value="<?php echo htmlspecialchars($row['Price']); ?>" step="0.01" required>
                
                <label for="Size">Size:</label>
                <input type="text" name="Size" value="<?php echo htmlspecialchars($row['Size']); ?>" required>
                
                <label for="Color">Color:</label>
                <input type="text" name="Color" value="<?php echo htmlspecialchars($row['Color']); ?>" required>
                
                <label for="StockLevel">Stock Level:</label>
                <input type="number" name="StockLevel" value="<?php echo htmlspecialchars($row['StockLevel']); ?>" required>
                
                <label for="Images">Images URL:</label>
                <input type="text" name="Images" value="<?php echo htmlspecialchars($row['Images']); ?>" required>
                
                <label for="ListingDetails">Listing Details:</label>
                <input type="text" name="ListingDetails" value="<?php echo htmlspecialchars($row['ListingDetails']); ?>" required>
                
                <label for="Description">Description:</label>
                <input type="text" name="Description" value="<?php echo htmlspecialchars($row['Description']); ?>" required>
                
                <input type="submit" value="Update Collection">
            </form>

            <?php
        } else {
            echo "<p>No collection found with that ID.</p>";
        }
    } else {
        echo "<p>No CollectionID provided.</p>";
    }

    $conn->close();
    ?>

    <a href="collectionlist.php" class="button">Back to Collection List</a>
</body>
</html>
