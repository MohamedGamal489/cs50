<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shohnty";

// Create a connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $targetDir = "images/";

    // Handle driver's license image upload
    $driverLicenseFile = $targetDir . "driver_license_" . basename($_FILES["driverLicenseImage"]["name"]);
    if (move_uploaded_file($_FILES["driverLicenseImage"]["tmp_name"], $driverLicenseFile)) {
        echo "<p><strong>Driver's License Image:</strong> <a href='$driverLicenseFile' target='_blank'>View Image</a></p>";
    } else {
        echo "Failed to upload driver's license image.";
    }

    // Handle car license image upload
    $carLicenseFile = $targetDir . "car_license_" . basename($_FILES["carLicenseImage"]["name"]);
    if (move_uploaded_file($_FILES["carLicenseImage"]["tmp_name"], $carLicenseFile)) {
        echo "<p><strong>Car License Image:</strong> <a href='$carLicenseFile' target='_blank'>View Image</a></p>";

        // Insert file paths into the 'drivers' table
        $sql = "INSERT INTO drivers (driver_license, car_license) VALUES ('$driverLicenseFile', '$carLicenseFile')";
        if ($connection->query($sql) === TRUE) {
            echo "Images uploaded successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    } else {
        echo "Failed to upload car license image.";
    }
}

// Close the database connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> License Images</title>
<form action="#" method="POST" enctype="multipart/form-data">
        <h2> Licenses Images</h2>

        <label for="driverLicenseImage">Upload Driver's License Image:</label>
        <input type="file" id="driverLicenseImage" name="driverLicenseImage" accept="image/*" required>

        <label for="carLicenseImage">Upload Car License Image:</label>
        <input type="file" id="carLicenseImage" name="carLicenseImage" accept="image/*" required>

        <input type="submit" value="Upload">
    </form>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        padding: 20px;
    }
    form {
        max-width: 600px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
        text-align: center;
    }
    label {
        display: block;
        margin-bottom: 5px;
    }
    input[type="file"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        box-sizing: border-box;
        border: 1px solid black;
        border-radius: 4px;
    }
    input[type="submit"] {
        background-color:black;
        color: #fff;
        border: solid none;
        padding: 10px 280px;
        cursor: pointer;
        border-radius: 40px;
    }
    input[type="submit"]:hover {
        background-color:black;
    }
</style>
</head>
