<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        h1 {
            margin-top: 20px;
        }
        .container {
            margin-top: 50px;
        }
        .form-box {
            display: inline-block;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            display: block;
            width: 100%;
            box-sizing: border-box;
        }
        .button:hover {
            background-color: #45a049;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            color: #4CAF50;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Select Order</h1>
    <div class="container">
        <div class="form-box">
            <form action="view_order.php" method="get">
                <label for="orderID">Order ID:</label>
                <input type="text" id="orderID" name="OrderID" placeholder="Enter Order ID" required>
                <button type="submit" class="button">View Order Details</button>
            </form>
        </div>
        <a href="order.php" class="back-link">Back to Order List</a>
    </div>
</body>
</html>
