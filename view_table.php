<?php
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

// Get table name from the query parameter
$table = $_GET['table'] ?? '';

// List of valid tables to prevent SQL injection
$valid_tables = [
    'customer', 'employee', 'collectionlist', 'transaction', 
    'receipt', 'shippinganddelivery', 'discountandpromotion', 
    'inventory', 'order'
];

// Validate the table name
if (!in_array($table, $valid_tables)) {
    die("Invalid table specified.");
}

// Query to get data from the specified table, wrapping table name in backticks
$sql = "SELECT * FROM `$table`";
$result = $conn->query($sql);

// Display the table name as a heading
echo "<h2>Viewing Table: " . htmlspecialchars($table) . "</h2>";

if ($result->num_rows > 0) {
    // Start the HTML table
    echo "<table border='1'><tr>";

    // Print table headers
    while ($field = $result->fetch_field()) {
        echo "<th>" . htmlspecialchars($field->name) . "</th>";
    }
    echo "</tr>";

    // Print table rows
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . htmlspecialchars($value) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    // No records found message
    echo "<p>No records found in the " . htmlspecialchars($table) . " table.</p>";
}

// Close the connection
$conn->close();
?>
