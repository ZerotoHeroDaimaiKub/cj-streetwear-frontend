<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Collection</title>
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
        label, input, select, textarea {
            display: block;
            width: 100%;
            margin: 10px 0;
        }
        input[type="text"], input[type="number"], textarea {
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
    <h1>Add New Collection</h1>

    <form action="add_collection.php" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" step="0.01" required>

        <label for="size">Size:</label>
        <input type="text" name="size" id="size" required>

        <label for="color">Color:</label>
        <input type="text" name="color" id="color" required>

        <label for="stock">Stock Level:</label>
        <input type="number" name="stock" id="stock" required>

        <label for="image">Image URL:</label>
        <input type="text" name="image" id="image" required>

        <label for="listing_details">Listing Details:</label>
        <input type="text" name="listing_details" id="listing_details" required>

        <label for="description">Description:</label>
        <textarea name="description" id="description" rows="4" required></textarea>

        <input type="submit" value="Add Collection">
    </form>

    <a href="collectionlist.php" class="button">Back to Collection List</a>

    <?php
    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Database connection parameters
        $servername = "127.0.0.1";
        $username = "root";
        $password = "Timeza.084"; // Replace with your actual MySQL root password
        $dbname = "cj_streetwear";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO collectionlist (Name, Price, Size, Color, StockLevel, Images, ListingDetails, Description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdssisss", $name, $price, $size, $color, $stock, $image, $listing_details, $description);

        // Set parameters and execute
        $name = $_POST["name"];
        $price = $_POST["price"];
        $size = $_POST["size"];
        $color = $_POST["color"];
        $stock = $_POST["stock"];
        $image = $_POST["image"];
        $listing_details = $_POST["listing_details"];
        $description = $_POST["description"];
        
        if ($stmt->execute()) {
            echo "<p>New collection item added successfully!</p>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

        // Close connection
        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
