<?php
    $servername = "localhost";
    $username = "root"; // Change 'root' to your actual MySQL username
    $password = ""; // Change '' to your actual MySQL password if you have set one
    $dbname = "shohnty";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["phone"]) && isset($_POST["password"])) {
        $phone = $_POST["phone"];
        $password = $_POST["password"];

        $query = "SELECT * FROM drivers WHERE phone_number = '$phone' AND password = '$password'";
        $result = mysqli_query($conn, $query);

        
        } else {
            // User not found, show error message or redirect to login page with error message
            echo "Invalid phone number or password.";
        }
    } else {
        echo "Phone number or password not set.";
    }


mysqli_close($conn);
?>

<div class="container">
    <div class="card">
        <h1>Login</h1>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
          <label for="phone">Phone Number:</label><br>
          <input type="text" id="phone" name="phone" required><br>
          <label for="password">Password:</label><br>
          <input type="password" id="password" name="password" required><br><br>
          <input type="submit" value="Login">
        </form>
    </div>
</div>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Form</title>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #fff;
    color: navy;
}

.container {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding-top: 20px; /* Adjust this value to move the form higher or lower */
}

.card {
    width: 350px;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

form {
    text-align: center;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid navy;
    border-radius: 15px;
    background-color: #fff;
    color: navy;
}

input[type="submit"] {
    width: 100%;
    padding: 10px 160px;
    background-color: navy;
    color: #fff;
    border: none;
    border-radius: 15px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #001f3f;
}

.error {
    color: #ff0000;
    text-align: center;
    margin-top: 10px;
}
</style>
</head>
<body>