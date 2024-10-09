<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Promotion</title>
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
        label, input {
            display: block;
            margin: 10px 0;
        }
        input[type="number"] {
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
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>Select Promotion</h1>
    <form action="select_promotion.php" method="post">
        <label for="promotion_id">Promotion ID:</label>
        <input type="number" id="promotion_id" name="promotion_id" required>
        <input type="submit" class="button" value="View Promotion">
    </form>

    <?php
    // Database connection parameters
    $servername = "127.0.0.1";
    $username = "root";
    $password = "Timeza.084"; // replace with your actual MySQL root password
    $dbname = "cj_streetwear";

    // Check if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the promotion ID from the form
        $promotionID = $_POST["promotion_id"];

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query to fetch the specific promotion
        $sql = "SELECT * FROM discountandpromotion WHERE PromotionID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $promotionID);
        $stmt->execute();
        $result = $stmt->get_result();

        // Display the result in a table format
        if ($result->num_rows > 0) {
            echo "<table><tr><th>Promotion ID</th><th>Discount Code</th><th>Discount Details</th><th>Valid Until</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["PromotionID"]) . "</td>
                        <td>" . htmlspecialchars($row["DiscountCode"]) . "</td>
                        <td>" . htmlspecialchars($row["DiscountDetails"]) . "</td>
                        <td>" . htmlspecialchars($row["ValidUntil"]) . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No promotion found with the given ID.</p>";
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
