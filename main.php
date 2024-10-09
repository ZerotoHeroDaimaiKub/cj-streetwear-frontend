<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Views</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f0f0f0;
        }
        h1 {
            margin-top: 20px;
        }
        .button-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
            max-width: 800px;
            margin: auto;
        }
        .button {
            padding: 15px 30px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            text-align: center;
            font-size: 18px;
            text-decoration: none;
            cursor: pointer;
            width: 160px;
            display: inline-block;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Manager Views</h1>
    <div class="button-container">
        <a href="customer.php" class="button">Customer</a>
        <a href="employee.php" class="button">Employee</a>
        <a href="collectionlist.php" class="button">Collection List</a>
        <a href="transaction.php" class="button">Transaction</a>
        <a href="receipt.php" class="button">Receipt</a>
        <a href="shippinganddelivery.php" class="button">Shipping & Delivery</a>
        <a href="promotion.php" class="button">Promotion</a>
        <a href="inventory.php" class="button">Inventory</a>
        <a href="order.php" class="button">Order</a>
    </div>
</body>
</html>
