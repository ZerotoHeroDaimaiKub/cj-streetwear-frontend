<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
        }
        h1 {
            margin-top: 20px;
        }
        form {
            margin: 20px auto;
            padding: 20px;
            width: 300px;
            border: 1px solid #ddd;
            background-color: #fff;
            border-radius: 8px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .button-container {
            margin-top: 20px;
        }
        .button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }
        .button:hover {
            background-color: #45a049;
        }
        .back-button {
            display: block;
            margin-top: 10px;
            background-color: #666;
        }
    </style>
</head>
<body>
    <h1>Edit Employee</h1>

    <?php
    // Database connection parameters
    $servername = "127.0.0.1";
    $username = "root";
    $password = "Timeza.084"; // Replace with your actual password
    $dbname = "cj_streetwear";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if EmployeeID is set
    if (isset($_GET["EmployeeID"])) {
        $employeeID = $conn->real_escape_string($_GET["EmployeeID"]);
        
        // Fetch employee details
        $sql = "SELECT * FROM employee WHERE EmployeeID = '$employeeID'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "<p>Employee not found.</p>";
            echo "<a href='employee.php' class='button back-button'>Back to Employee List</a>";
            exit;
        }
    } else {
        echo "<p>No EmployeeID provided.</p>";
        echo "<a href='employee.php' class='button back-button'>Back to Employee List</a>";
        exit;
    }

    // Handle form submission to update employee details
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $conn->real_escape_string($_POST["name"]);
        $role = $conn->real_escape_string($_POST["role"]);
        $salary = $conn->real_escape_string($_POST["salary"]);
        $phone = $conn->real_escape_string($_POST["phone"]);

        $updateSql = "UPDATE employee SET Name = '$name', Role = '$role', Salary = '$salary', PhoneNumber = '$phone' WHERE EmployeeID = '$employeeID'";

        if ($conn->query($updateSql) === TRUE) {
            echo "<p>Employee updated successfully!</p>";
            echo "<a href='employee.php' class='button back-button'>Back to Employee List</a>";
        } else {
            echo "Error updating employee: " . $conn->error;
        }
        exit;
    }
    ?>

    <form method="post" action="">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['Name']); ?>" required><br>

        <label for="role">Role:</label><br>
        <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($row['Role']); ?>" required><br>

        <label for="salary">Salary:</label><br>
        <input type="number" id="salary" name="salary" value="<?php echo htmlspecialchars($row['Salary']); ?>" required><br>

        <label for="phone">Phone Number:</label><br>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($row['PhoneNumber']); ?>" required><br>

        <div class="button-container">
            <input type="submit" class="button" value="Update Employee">
        </div>
    </form>
    
    <a href="employee.php" class="button back-button">Back to Employee List</a>

    <?php $conn->close(); ?>
</body>
</html>
