<?php
// Database connection settings
$servername = "localhost"; // Change this to your servername
$username = "root"; // Change this to your username
$password = ""; // Change this to your password
$dbname = "shohnty"; // Change this to your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted and the required fields are set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["car_number"]) && isset($_POST["car_type"]) && isset($_POST["additions"])) {
    // Get form data
    $car_number = $_POST["car_number"];
    $car_type = $_POST["car_type"];
    $car_additions = $_POST["additions"];

    // SQL query to insert car number and car type into 'packages' table
    $sql_packages = "INSERT INTO packages (car_number, car_type) VALUES (?, ?)";
    $stmt_packages = mysqli_prepare($conn, $sql_packages);
    mysqli_stmt_bind_param($stmt_packages, "ss", $car_number, $car_type);

    // Execute the packages query
    if (mysqli_stmt_execute($stmt_packages)) {
        echo "Car number and car type added to packages table successfully.";

        // Get the last inserted car_id
        $car_id = mysqli_insert_id($conn);

        // Insert car additions into 'additions' table
        foreach ($car_additions as $addition) {
            // Check if the car addition already exists
            $sql_check = "SELECT * FROM additions WHERE car_id = ? AND car_additions = ?";
            $stmt_check = mysqli_prepare($conn, $sql_check);
            mysqli_stmt_bind_param($stmt_check, "is", $car_id, $addition);
            mysqli_stmt_execute($stmt_check);
            $result = mysqli_stmt_get_result($stmt_check);

            if (mysqli_num_rows($result) == 0) {
                $sql_addition = "INSERT INTO additions (car_id, car_additions) VALUES (?, ?)";
                $stmt_addition = mysqli_prepare($conn, $sql_addition);
                mysqli_stmt_bind_param($stmt_addition, "is", $car_id, $addition);
                if (!mysqli_stmt_execute($stmt_addition)) {
                    echo "Error: " . mysqli_error($conn);
                }
            }
        }

        echo "Car additions added to additions table successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Close database connection
mysqli_close($conn);
?>



<!DOCTYPE html>
<html>
<head>
    <title>Car Information</title>
    <!-- Your CSS styles -->
</head>
<body>

<div class="container">
    <h2>Car Information</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="car_number">Car Number:</label>
            <input type="text" id="car_number" name="car_number" required>
        </div>
        <div class="form-group">
            <label for="car_type">Car Type:</label>
            <select id="car_type" name="car_type" required>
                <option value="">Select Car Type</option>
                <option value="ربع نقل">ربع نقل</option>
                <option value="جامبو">جامبو</option>
                <option value="نقل كبير">نقل كبير</option>
                <option value="سوزوكي">سوزوكي</option>
                <option value="مقطورة كبيرة">مقطورة كبيرة</option>
                <option value="قلاب">قلاب</option>
                <option value="جرار">جرار</option>
            </select>
        </div>
        <div class="form-group">
            <label>Additions:</label><br>
            <label><input type="checkbox" name="additions[]" value="زوي"> زوي</label><br>
            <label><input type="checkbox" name="additions[]" value="كساتن"> كساتن</label><br>
            <label><input type="checkbox" name="additions[]" value="بوم"> بوم</label><br>
            <label><input type="checkbox" name="additions[]" value="شرايط"> شرايط</label><br>
            <label><input type="checkbox" name="additions[]" value="سلب"> سلب</label><br>
            <label><input type="checkbox" name="additions[]" value="مشمع"> مشمع</label><br>
            <label><input type="checkbox" name="additions[]" value="جنازير"> جنازير</label><br>
            <label><input type="checkbox" name="additions[]" value="سيلات"> سيلات</label><br>
            <label><input type="checkbox" name="additions[]" value="كاميرا"> كاميرا</label><br>
            <label><input type="checkbox" name="additions[]" value="انذار رجوع للخلف"> انذار رجوع للخلف</label><br>
        </div>
        <input type="submit" name="submit" value="Submit">
    </form>
</div>

</body>
</html>
