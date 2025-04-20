<?php
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.html");
    exit;
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'dhakanest');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the latest booking from the database
$sql = "SELECT * FROM booking ORDER BY booking_id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $booking = $result->fetch_assoc();
    $customer_id = $booking['customer_id'];
    $room_id = $booking['room_id'];

    // Fetch customer information
    $customer_sql = "SELECT first_name, email, phone FROM customer WHERE customer_id = ?";
    $stmt = $conn->prepare($customer_sql);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $customer_result = $stmt->get_result();
    $customer = $customer_result->fetch_assoc();

    // Fetch room location
    $room_sql = "SELECT location FROM rooms WHERE room_id = ?";
    $stmt = $conn->prepare($room_sql);
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $room_result = $stmt->get_result();
    $room = $room_result->fetch_assoc();

    echo '<h3>Customer Information</h3>
          <p><strong>Name:</strong> ' . $customer['first_name'] . '</p>
          <p><strong>Email:</strong> ' . $customer['email'] . '</p>
          <p><strong>Phone:</strong> ' . $customer['phone'] . '</p>
          <h3>Room Information</h3>
          <p><strong>Location:</strong> ' . $room['location'] . '</p>';
} else {
    echo 'No booking details found.';
}

// Close the connection
$conn->close();
?>
