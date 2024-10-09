<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Employee</title>
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
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #fff;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .button {
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #d32f2f;
        }
        .back-button {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #555;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .back-button:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <h1>Delete Employee</h1>

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

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $employeeID = $conn->real_escape_string($_POST["employeeID"]);

        // Delete query
        $sql = "DELETE FROM employee WHERE EmployeeID = '$employeeID'";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Employee deleted successfully.</p>";
        } else {
            echo "<p>Error deleting employee: " . $conn->error . "</p>";
        }
    }

    // Fetch employees for the dropdown
    $sql = "SELECT EmployeeID, Name FROM employee";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<form method="post" action="delete_employee.php">';
        echo '<label for="employeeID">Select Employee to Delete:</label>';
        echo '<select id="employeeID" name="employeeID" required>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . htmlspecialchars($row["EmployeeID"]) . '">' . htmlspecialchars($row["Name"]) . '</option>';
        }
        echo '</select>';
        echo '<input type="submit" value="Delete Employee" class="button">';
        echo '</form>';
    } else {
        echo "<p>No employees found to delete.</p>";
    }

    $conn->close();
    ?>

    <a href="employee.php" class="back-button">Back to Employee List</a>
</body>
</html>
