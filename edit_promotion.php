<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Promotion</title>
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
        }
        label, input {
            display: block;
            margin: 10px 0;
        }
        input[type="text"], input[type="date"] {
            width: 300px;
            padding: 8px;
        }
        .button {
            padding: 10px 20px;
            margin: 5px;
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
    <h1>Edit Promotion</h1>

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

    // Check if PromotionID is provided
    if (isset($_GET['PromotionID'])) {
        $promotionID = $_GET['PromotionID'];

        // Fetch the promotion details
        $sql = "SELECT * FROM discountandpromotion WHERE PromotionID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $promotionID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $promotion = $result->fetch_assoc();
            ?>

            <!-- Edit Form -->
            <form action="edit_promotion.php" method="post">
                <input type="hidden" name="PromotionID" value="<?php echo htmlspecialchars($promotion['PromotionID']); ?>">
                <label for="DiscountCode">Discount Code:</label>
                <input type="text" id="DiscountCode" name="DiscountCode" value="<?php echo htmlspecialchars($promotion['DiscountCode']); ?>" required>

                <label for="DiscountDetails">Discount Details:</label>
                <input type="text" id="DiscountDetails" name="DiscountDetails" value="<?php echo htmlspecialchars($promotion['DiscountDetails']); ?>" required>

                <label for="ValidUntil">Valid Until:</label>
                <input type="date" id="ValidUntil" name="ValidUntil" value="<?php echo htmlspecialchars($promotion['ValidUntil']); ?>" required>

                <input type="submit" class="button" value="Update Promotion">
            </form>

            <?php
        } else {
            echo "<p>Promotion not found.</p>";
        }

        $stmt->close();
    }

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $promotionID = $_POST["PromotionID"];
        $discountCode = $_POST["DiscountCode"];
        $discountDetails = $_POST["DiscountDetails"];
        $validUntil = $_POST["ValidUntil"];

        // Update promotion details
        $sql = "UPDATE discountandpromotion SET DiscountCode = ?, DiscountDetails = ?, ValidUntil = ? WHERE PromotionID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $discountCode, $discountDetails, $validUntil, $promotionID);

        if ($stmt->execute()) {
            echo "<p>Promotion updated successfully.</p>";
        } else {
            echo "<p>Error updating promotion: " . $conn->error . "</p>";
        }

        $stmt->close();
    }

    $conn->close();
    ?>

    <div>
        <a href="promotion.php" class="button">Back to Promotions</a>
    </div>
</body>
</html>
