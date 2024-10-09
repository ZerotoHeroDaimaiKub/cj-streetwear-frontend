<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Employee</title>
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
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #45a049;
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
    <h1>Select Employee</h1>

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

        // Query to select employee details
        $sql = "SELECT * FROM employee WHERE EmployeeID = '$employeeID'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table><tr><th>Employee ID</th><th>Name</th><th>Role</th><th>Salary</th><th>Phone Number</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["EmployeeID"]) . "</td>
                        <td>" . htmlspecialchars($row["Name"]) . "</td>
                        <td>" . htmlspecialchars($row["Role"]) . "</td>
                        <td>" . htmlspecialchars($row["Salary"]) . "</td>
                        <td>" . htmlspecialchars($row["PhoneNumber"]) . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No employee found with the selected ID.</p>";
        }
    }

    // Fetch employees for the dropdown
    $sql = "SELECT EmployeeID, Name FROM employee";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<form method="post" action="select_employee.php">';
        echo '<label for="employeeID">Select Employee to View:</label>';
        echo '<select id="employeeID" name="employeeID" required>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . htmlspecialchars($row["EmployeeID"]) . '">' . htmlspecialchars($row["Name"]) . '</option>';
        }
        echo '</select>';
        echo '<input type="submit" value="View Employee" class="button">';
        echo '</form>';
    } else {
        echo "<p>No employees found to select.</p>";
    }

    $conn->close();
    ?>

    <a href="employee.php" class="back-button">Back to Employee List</a>
</body>
</html>
