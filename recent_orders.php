<?php
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.html");
    exit;
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'cozyq');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the latest booking from the database
$sql = "SELECT * FROM booking ORDER BY booking_id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $booking = $result->fetch_assoc();
    echo '<table class="table">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Room ID</th>
                    <th>Customer ID</th>
                    <th>Check-in Date</th>
                    <th>Check-out Date</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>' . $booking['booking_id'] . '</td>
                    <td>' . $booking['room_id'] . '</td>
                    <td>' . $booking['customer_id'] . '</td>
                    <td>' . $booking['check_in_date'] . '</td>
                    <td>' . $booking['check_out_date'] . '</td>
                    <td>' . $booking['total_price'] . '</td>
                </tr>
            </tbody>
          </table>';
} else {
    echo 'No orders found.';
}

// Close the connection
$conn->close();
?>
