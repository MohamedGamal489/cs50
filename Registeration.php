        <?php
        // Database configuration for phpMyAdmin 'shohnty' database
        $servername = "localhost"; // Or the IP address of your MySQL server
        $username = "root"; // Change 'root' to your MySQL username
        $password = ""; // Change '' to your MySQL password if you have set one
        $dbname = "shohnty";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the drivers table exists, if not, create it
        $sql = "CREATE TABLE IF NOT EXISTS drivers (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            id_number INT(11) UNSIGNED UNIQUE NOT NULL,
            name VARCHAR(255) NOT NULL,
            phone_number VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL
            )";

        if ($conn->query($sql) === FALSE) {
            echo "Error creating table: " . $conn->error;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_number = $_POST['id_number'];
            $name = $_POST['name'];
            $phone_number = $_POST['phone_number'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Validate inputs
            if (empty($id_number) || empty($name) || empty($phone_number) || empty($password) || empty($confirm_password)) {
                $message = "All fields are required.";
            } elseif ($password != $confirm_password) {
                $message = "Passwords do not match.";
            } else {
                // Insert driver data into the database
                $sql = "INSERT INTO drivers (id_number, name, phone_number, password) VALUES ('$id_number', '$name', '$phone_number', '$password')";

                if ($conn->query($sql) === TRUE) {
                    $message = "Registration successful!";
                    echo '<script>window.open("car_info.php", "_blank");</script>';
                } else {
                    $message = "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }

        // Close the database connection
        $conn->close();
        ?>
        <!DOCTYPE html>
        <html>
<head>
    <title>Driver Registration </title>
</head>
<body>
    <div class="container">
        <h2>Driver Registration</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="id_number">ID Number:</label>
            <input type="text" id="id_number" name="id_number" required><br><br>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>

            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required><br><br>

            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>
<html>
<head>
    <title>Driver Registration </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: whitesmoke;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: navy;
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border-radius: 15px;
            border: 1px solid navy;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px 209px;
            background-color: navy;
            color: whitesmoke;
            border: none;
            border-radius: 15px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: royalblue;
        }
        .message {
            text-align: center;
            margin-top: 20px;
            color: royalblue;
        }
    </style>
</head>
