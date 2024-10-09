<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Promotion</title>
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
        }
        label, input, textarea {
            display: block;
            margin: 10px 0;
        }
        input[type="text"], textarea {
            width: 300px;
            padding: 8px;
        }
        input[type="date"] {
            padding: 5px;
        }
        .button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Add Promotion</h1>
    <form action="add_promotion.php" method="post">
        <label for="discount_code">Discount Code:</label>
        <input type="text" id="discount_code" name="discount_code" required>

        <label for="discount_details">Discount Details:</label>
        <textarea id="discount_details" name="discount_details" required></textarea>

        <label for="valid_until">Valid Until:</label>
        <input type="date" id="valid_until" name="valid_until" required>

        <input type="submit" class="button" value="Add Promotion">
    </form>

    <?php
    // Database connection parameters
    $servername = "127.0.0.1";
    $username = "root";
    $password = "Timeza.084"; // replace with your actual MySQL root password
    $dbname = "cj_streetwear";

    // Check if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $discountCode = $_POST["discount_code"];
        $discountDetails = $_POST["discount_details"];
        $validUntil = $_POST["valid_until"];

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert promotion into database
        $sql = "INSERT INTO discountandpromotion (DiscountCode, DiscountDetails, ValidUntil) 
                VALUES (?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $discountCode, $discountDetails, $validUntil);

        if ($stmt->execute()) {
            echo "<p>Promotion added successfully!</p>";
        } else {
            echo "<p>Error adding promotion: " . $conn->error . "</p>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>

    <div>
        <a href="promotion.php" class="button">Back to Promotions</a>
    </div>
</body>
</html>
