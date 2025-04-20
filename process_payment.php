<?php
session_start();

// Step 1: Establish a connection to the database
$conn = new mysqli('localhost', 'root', '', 'dhakanest');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Retrieve the payment details from the AJAX request
$payment_type = $_POST['payment_type'];
$total_price = $_POST['total_price'];
$status = $_POST['status'];
$book_id = $_SESSION['book_id']; // Assuming you have stored the book_id in the session

// Step 3: Save the payment details to the database
$stmt = $conn->prepare("INSERT INTO payment (payment_type, total_price, status, book_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sdsi", $payment_type, $total_price, $status, $book_id);
$stmt->execute();
$payment_id = $stmt->insert_id;

// Step 4: Close the database connection
$stmt->close();
$conn->close();

echo "Payment details saved successfully.";
?>