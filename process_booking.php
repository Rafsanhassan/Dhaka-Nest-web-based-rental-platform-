<?php

session_start();
require_once 'DatabaseProxy.php';


interface PriceCalculator
{
    public function calculatePrice();
}

class BasePrice implements PriceCalculator
{
    protected $price_per_night;
    protected $total_days;

    public function __construct($price_per_night, $total_days)
    {
        $this->price_per_night = $price_per_night;
        $this->total_days = $total_days;
    }

    public function calculatePrice()
    {
        return $this->price_per_night * $this->total_days;
    }
}

class PremiumDiscount implements PriceCalculator
{
    protected $priceCalculator;

    public function __construct(PriceCalculator $priceCalculator)
    {
        $this->priceCalculator = $priceCalculator;
    }

    public function calculatePrice()
    {
        $price = $this->priceCalculator->calculatePrice();
        return $price * 0.7; // 30% discount
    }
}

class LoyalDiscount implements PriceCalculator
{
    protected $priceCalculator;

    public function __construct(PriceCalculator $priceCalculator)
    {
        $this->priceCalculator = $priceCalculator;
    }

    public function calculatePrice()
    {
        $price = $this->priceCalculator->calculatePrice();
        return $price * 0.5; // 50% discount
    }
}

// Step 1: Establish a connection to the database
$databaseProxy = new DatabaseProxy("localhost", "root", "", "dhakanest");

// Step 2: Retrieve the form data from the POST request
$room_id = $_POST['room_id'];
$location = $_POST['location'];
$check_in_date = $_POST['check_in_date'];
$check_out_date = $_POST['check_out_date'];
$customer_id = $_SESSION['customer_id'];

// Step 3: Calculate the total price and total days
$stmt = $databaseProxy->executeQuery("SELECT price FROM rooms WHERE room_id = ?", [$room_id]);
$result = $stmt->fetch_assoc();
if ($result) {
    $price_per_night = $result['price'];
    $datetime1 = new DateTime($check_in_date);
    $datetime2 = new DateTime($check_out_date);
    $interval = $datetime1->diff($datetime2);
    $total_days = $interval->days;
   // $total_price = $price_per_night * $total_days;

    // Get the customer type
    $stmt = $databaseProxy->executeQuery("SELECT customer_type FROM customer WHERE customer_id = ?", [$customer_id]);
    $result = $stmt->fetch_assoc();
    $customer_type = $result['customer_type'];

    // Calculate the total price with discount based on customer type
    $priceCalculator = new BasePrice($price_per_night, $total_days);
    if ($customer_type === 'Premium') {
        $priceCalculator = new PremiumDiscount($priceCalculator);
    } elseif ($customer_type === 'Loyal') {
        $priceCalculator = new LoyalDiscount($priceCalculator);
    }
    $total_price = $priceCalculator->calculatePrice();

    // Step 4: Save the booking details to the database
    $databaseProxy->executeUpdate("INSERT INTO booking (check_in_date, check_out_date, total_price, room_id, customer_id) VALUES (?, ?, ?, ?, ?)", [$check_in_date, $check_out_date, $total_price, $room_id, $customer_id]);
    $book_id = $databaseProxy->getLastInsertId();

    // Get the current order_count for the customer
    $stmt = $databaseProxy->executeQuery("SELECT order_count FROM customer WHERE customer_id = ?", [$customer_id]);
    $result = $stmt->fetch_assoc();
    $current_order_count = $result['order_count'];

    // Increment the order_count
    $new_order_count = $current_order_count + 1;

    // Update the order_count in the customer table
    $databaseProxy->executeUpdate("UPDATE customer SET order_count = ? WHERE customer_id = ?", [$new_order_count, $customer_id]);

    // Step 5: Store the book_id in the session
    $_SESSION['book_id'] = $book_id;



    // Step 6: Redirect to the payment page with total days and total price as query parameters
    header("Location: payment.php?total_days=$total_days&total_price=$total_price");
    //header("Location: home.php");
    exit();
} else {
    echo 'Error: Room not found.';
}

?>