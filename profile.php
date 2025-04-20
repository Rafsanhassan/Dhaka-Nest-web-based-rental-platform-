<?php
session_start(); // Start the session

// Check if user is not logged in, redirect them to the login page
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit;
}

// Retrieve user details from session
$customerId = $_SESSION['customer_id'];
$name = $_SESSION['first_name'];
$dateOfBirth = $_SESSION['date_of_birth'];
$gender = $_SESSION['gender'];
$email = $_SESSION['email'];
$phoneNo = $_SESSION['phone_no'];
$address = $_SESSION['address'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'dhakanest');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve order count from the database
$sql = "SELECT order_count FROM customer WHERE customer_id = $customerId";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$order_count = $row['order_count'];

//Applying Decorator Design Pattern
// Determine customer type based on order count
if ($order_count < 3) {
    $customerType = 'Basic';
} elseif ($order_count >= 3 && $order_count < 5) {
    $customerType = 'Premium';
} else {
    $customerType = 'Loyal';
}

// Update customer type in the database
$sql = "UPDATE customer SET customer_type = '$customerType' WHERE customer_id = $customerId";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo " ";
} else {
    echo "Error updating customer type: " . mysqli_error($conn);
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="profile.css">
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <h1>Profile</h1>
        </div>
        <div class="profile-body">
            <div class="profile-info">
                <label>Customer ID:</label>
                <span><?php echo $customerId; ?></span>
            </div>
            <div class="profile-info">
                <label>Name:</label>
                <span><?php echo $name; ?></span>
            </div>
            <div class="profile-info">
                <label>Date of Birth:</label>
                <span><?php echo $dateOfBirth; ?></span>
            </div>
            <div class="profile-info">
                <label>Gender:</label>
                <span class="gender"><?php echo $gender; ?></span>
            </div>
            <div class="profile-info">
                <label>Email:</label>
                <span class="address"><?php echo $email; ?></span>
            </div>
            <div class="profile-info">
                <label>Phone no:</label>
                <span><?php echo $phoneNo; ?></span>
            </div>
            <div class="profile-info">
                <label>Order Count:</label>
                <span><?php echo $order_count; ?></span>
            </div>
            <div class="profile-info">
                <label>Customer Type:</label>
                <span><?php echo $customerType; ?></span>
            </div>
            <div class="profile-info">
                <label>Address:</label>
                <span><?php echo $address; ?></span>
            </div>
        </div>
    </div>
    <footer class="custom-footer">
        <h5>Find us on</h5>
        <div class="social-icons">
            <a href="https://www.facebook.com" target="_blank" rel="noopener noreferrer"><i class="fa fa-facebook-f"></i></a>
            <a href="https://www.instagram.com" target="_blank" rel="noopener noreferrer"><i class="fa fa-instagram"></i></a>
            <a href="https://twitter.com" target="_blank" rel="noopener noreferrer"><i class="fa fa-twitter"></i></a>
            <a href="https://www.linkedin.com/company" target="_blank" rel="noopener noreferrer"><i class="fa fa-linkedin"></i></a>
        </div>
        <div class="rights">
            <p>&copy; 2024 dhakanest. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>