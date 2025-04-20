<?php
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.html");
    exit;
}

// Include the necessary classes
require_once 'DatabaseProxy.php';
require_once 'DatabaseFacade.php';

// Create an instance of the DatabaseProxy
$databaseProxy = new DatabaseProxy('localhost', 'root', '', 'dhakanest');

// Create an instance of the DatabaseFacade
$databaseFacade = new DatabaseFacade($databaseProxy);

$tab = isset($_GET['tab']) ? $_GET['tab'] : 'recent-orders';

if ($tab === 'recent-orders') {
    $latestBooking = $databaseFacade->getRecentOrder();
} elseif ($tab === 'booking-details') {
    $bookings = $databaseFacade->getBookingDetails();
} elseif ($tab === 'customer') {
    $customers = $databaseFacade->getCustomers();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-dark">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link <?php echo $tab === 'booking-details' ? 'active' : ''; ?>" href="?tab=booking-details">Booking Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $tab === 'recent-orders' ? 'active' : ''; ?>" href="?tab=recent-orders">Recent Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $tab === 'customer' ? 'active' : ''; ?>" href="?tab=customer">Customers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </nav>
        <div class="mt-4">
            <h2>Welcome, <?php echo $_SESSION['first_name']; ?>!</h2>
            <p>DhakaNest: Affordable room and flat rentals</p>
        </div>
        <div class="card">
            <div class="card-header">
                <?php
                if ($tab === 'recent-orders') {
                    echo 'Recent Order';
                } elseif ($tab === 'booking-details') {
                    echo 'Booking Details';
                } elseif ($tab === 'customer') {
                    echo 'Customers';
                } else {
                    echo 'Invalid Tab';
                }
                ?>
            </div>
            <div class="card-body">
                <?php if ($tab === 'recent-orders'): ?>
                    <?php if (!empty($latestBooking)): ?>
                        <table class="table">
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
                                    <td><?php echo $latestBooking['book_id']; ?></td>
                                    <td><?php echo $latestBooking['room_id']; ?></td>
                                    <td><?php echo $latestBooking['customer_id']; ?></td>
                                    <td><?php echo $latestBooking['check_in_date']; ?></td>
                                    <td><?php echo $latestBooking['check_out_date']; ?></td>
                                    <td><?php echo $latestBooking['total_price']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No recent orders found.</p>
                    <?php endif; ?>
                <?php elseif ($tab === 'booking-details'): ?>
                    <?php if (!empty($bookings)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="w-10">Booking ID</th>
                                        <th class="w-10">Room ID</th>
                                        <th class="w-10">Customer ID</th>
                                        <th class="w-20">Customer Name</th>
                                        <th class="w-15">Phone</th>
                                        <th class="w-15">Location</th>
                                        <th class="w-10">Check-in Date</th>
                                        <th class="w-10">Check-out Date</th>
                                        <th class="w-10">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bookings as $booking): ?>
                                        <tr>
                                            <td><?php echo $booking['book_id']; ?></td>
                                            <td><?php echo $booking['room_id']; ?></td>
                                            <td><?php echo $booking['customer_id']; ?></td>
                                            <td><?php echo $booking['first_name'] . ' ' . $booking['last_name']; ?></td>
                                            <td><?php echo $booking['phone_no']; ?></td>
                                            <td><?php echo $booking['location']; ?></td>
                                            <td><?php echo $booking['check_in_date']; ?></td>
                                            <td><?php echo $booking['check_out_date']; ?></td>
                                            <td><?php echo $booking['total_price']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p>No bookings found.</p>
                    <?php endif; ?>
                <?php elseif ($tab === 'customer'): ?>
    <?php if (!empty($customers)): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Customer ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Order Count</th>
                        <th>Customer Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?php echo $customer['customer_id']; ?></td>
                            <td><?php echo $customer['first_name']; ?></td>
                            <td><?php echo $customer['last_name']; ?></td>
                            <td><?php echo $customer['order_count']; ?></td>
                            <td><?php echo $customer['customer_type']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>No customers found.</p>
    <?php endif; ?>
<?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
