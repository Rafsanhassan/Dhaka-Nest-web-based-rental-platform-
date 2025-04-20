<?php
require_once 'DatabaseProxy.php'; // Include the DatabaseProxy class
session_start();

$userType = $_POST['user_type'];
$email = $_POST['email'];
$password = $_POST['password'];

$databaseProxy = new DatabaseProxy("localhost", "root", "", "dhakanest");

if ($userType === 'customer') {
    // Existing code to handle customer login
    $stmt = $databaseProxy->executeQuery("SELECT r.*, c.customer_id 
                                           FROM registration r 
                                           JOIN customer c ON r.reg_id = c.reg_id
                                           WHERE r.email = ?", [$email]);
    $stmt_result = $stmt->fetch_assoc();

    if ($stmt_result && $stmt_result['password'] === $password) {
        $_SESSION['customer_id'] = $stmt_result['customer_id'];
        $_SESSION['first_name'] = $stmt_result['first_name'];
        $_SESSION['date_of_birth'] = $stmt_result['date_of_birth'];
        $_SESSION['gender'] = $stmt_result['gender'];
        $_SESSION['email'] = $stmt_result['email'];
        $_SESSION['phone_no'] = $stmt_result['phone_no'];
        $_SESSION['address'] = $stmt_result['address'];
        $_SESSION['customer_type'] = $stmt_result['customer_type'];
        $_SESSION['order_count'] = $stmt_result['order_count'];
        header("Location: Home.php");
        exit;
    
    } else {
        echo "<h2>Invalid email or password</h2>";
    }

} elseif ($userType === 'admin') {
    // New code to handle admin login
    $stmt = $databaseProxy->executeQuery("SELECT * FROM admin WHERE email = ?", [$email]);
    $stmt_result = $stmt->fetch_assoc();

    if ($stmt_result && $stmt_result['password'] === $password) {
        $_SESSION['admin_id'] = $stmt_result['admin_id'];
        $_SESSION['first_name'] = $stmt_result['first_name'];
        $_SESSION['last_name'] = $stmt_result['last_name'];
        $_SESSION['email'] = $stmt_result['email'];
        $_SESSION['phone_no'] = $stmt_result['phone_no'];
        $_SESSION['password'] = $stmt_result['password'];
        header("Location: admin_dashboard.php");
        exit;
    } else {
        echo "<h2>Invalid email or password</h2>";
    }

} elseif ($userType === 'owner') {
    // New code to handle owner login
    $stmt = $databaseProxy->executeQuery("SELECT * FROM owner WHERE email = ?", [$email]);
    $stmt_result = $stmt->fetch_assoc();

    if ($stmt_result && $stmt_result['password'] === $password) {
        $_SESSION['owner_id'] = $stmt_result['owner_id'];
        $_SESSION['first_name'] = $stmt_result['first_name'];
        $_SESSION['last_name'] = $stmt_result['last_name'];
        $_SESSION['email'] = $stmt_result['email'];
        $_SESSION['phone_no'] = $stmt_result['phone_no'];
        $_SESSION['address'] = $stmt_result['address'];
        $_SESSION['date_of_birth'] = $stmt_result['date_of_birth'];
        $_SESSION['gender'] = $stmt_result['gender'];
        $_SESSION['password'] = $stmt_result['password'];
        header("Location: owner_dashboard.php");
        exit;
    } else {
        echo "<h2>Invalid email or password</h2>";
    }

} 

else {
    echo "<h2>Invalid user type</h2>";
}
