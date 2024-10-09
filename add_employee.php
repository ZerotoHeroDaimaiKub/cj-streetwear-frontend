<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Employee</title>
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
        input[type="text"], input[type="number"] {
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
    <h1>Add New Employee</h1>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        // Retrieve form data
        $name = $conn->real_escape_string($_POST["name"]);
        $role = $conn->real_escape_string($_POST["role"]);
        $salary = $conn->real_escape_string($_POST["salary"]);
        $phone = $conn->real_escape_string($_POST["phone"]);

        // Insert query
        $sql = "INSERT INTO employee (Name, Role, Salary, PhoneNumber) VALUES ('$name', '$role', '$salary', '$phone')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>New employee added successfully!</p>";
        } else {
            echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }

        $conn->close();
    }
    ?>

    <form method="post" action="add_employee.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="role">Role:</label>
        <input type="text" id="role" name="role" required>

        <label for="salary">Salary:</label>
        <input type="number" id="salary" name="salary" step="0.01" required>

        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" required>

        <input type="submit" value="Add Employee" class="button">
    </form>

    <a href="employee.php" class="back-button">Back to Employee List</a>
</body>
</html>
