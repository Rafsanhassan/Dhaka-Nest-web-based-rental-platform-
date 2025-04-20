<?php
session_start();

// Check if the user is logged in as an owner
if (!isset($_SESSION['owner_id'])) {
    header("Location: login.html");
    exit;
}

// Include the BookingObserver class
require_once 'BookingObserver.php';
// Mock DatabaseProxy class
class MockDatabaseProxy
{
    public function executeQuery($query)
    {
        // Mock implementation or return a fake result
        return new MockResult();
    }
}

// Mock Result class
class MockResult
{
    public function fetch_assoc()
    {
        // Mock implementation or return a fake associative array
        return [];
    }

    public function num_rows()
    {
        return 0;
    }
}

// Create an instance of the MockDatabaseProxy
$mockDatabaseProxy = new MockDatabaseProxy();

// Create an instance of the BookingObserver with the mock database proxy
$bookingObserver = new BookingObserver($mockDatabaseProxy);




// Subscribe an observer function
$bookingObserver->subscribe(function ($data) {
    echo '<div class="alert alert-success">New booking: ' . $data . '</div>';
});

// Database connection
$conn = new mysqli('localhost', 'root', '', 'dhakanest');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tab = isset($_GET['tab']) ? $_GET['tab'] : 'My-Profile';

if ($tab === 'My-Profile') {
    // Fetch the owner's profile information
    $owner_id = $_SESSION['owner_id'];
    $sql = "SELECT * FROM owner WHERE owner_id = $owner_id";
    $result = $conn->query($sql);
    $my_profile = $result->fetch_assoc();
} elseif ($tab === 'Rooms') {
    // Fetch rooms owned by the logged-in owner
    $owner_id = $_SESSION['owner_id'];
    $sql = "SELECT room_id, location, floor_number, bedrooms, drawing_rooms, dining_rooms, verandas, bathrooms, kitchens, address, price
            FROM rooms
            WHERE owner_id = $owner_id";
    $result = $conn->query($sql);
    $rooms = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rooms[] = $row;
        }
    }
}

class RoomBuilder {
    private $room_id;
    private $owner_id;
    private $location;
    private $floor_number;
    private $bedrooms;
    private $drawing_rooms;
    private $dining_rooms;
    private $verandas;
    private $bathrooms;
    private $kitchens;
    private $address;

    public function setRoomId($room_id) {
        $this->room_id = $room_id;
        return $this;
    }

    public function setOwnerId($owner_id) {
        $this->owner_id = $owner_id;
        return $this;
    }

    public function setLocation($location) {
        $this->location = $location;
        return $this;
    }

    public function setFloorNumber($floor_number) {
        $this->floor_number = $floor_number;
        return $this;
    }

    public function setBedrooms($bedrooms) {
        $this->bedrooms = $bedrooms;
        return $this;
    }

    public function setDrawingRooms($drawing_rooms) {
        $this->drawing_rooms = $drawing_rooms;
        return $this;
    }

    public function setDiningRooms($dining_rooms) {
        $this->dining_rooms = $dining_rooms;
        return $this;
    }

    public function setVerandas($verandas) {
        $this->verandas = $verandas;
        return $this;
    }

    public function setBathrooms($bathrooms) {
        $this->bathrooms = $bathrooms;
        return $this;
    }

    public function setKitchens($kitchens) {
        $this->kitchens = $kitchens;
        return $this;
    }

    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

    public function build() {
        return new Room(
            null, // Assuming room_id will be assigned by the database
            $this->owner_id,
            $this->location,
            $this->floor_number,
            $this->bedrooms,
            $this->drawing_rooms,
            $this->dining_rooms,
            $this->verandas,
            $this->bathrooms,
            $this->kitchens,
            $this->address,
            0 // Assuming initial price is 0
        );
    }
    
}

class Room {
    private $room_id;
    private $owner_id;
    private $location;
    private $floor_number;
    private $bedrooms;
    private $drawing_rooms;
    private $dining_rooms;
    private $verandas;
    private $bathrooms;
    private $kitchens;
    private $address;
    private $price;

    public function __construct($room_id, $owner_id, $location, $floor_number, $bedrooms, $drawing_rooms, $dining_rooms, $verandas, $bathrooms, $kitchens, $address, $price) {
        $this->room_id = $room_id;
        $this->owner_id = $owner_id;
        $this->location = $location;
        $this->floor_number = $floor_number;
        $this->bedrooms = $bedrooms;
        $this->drawing_rooms = $drawing_rooms;
        $this->dining_rooms = $dining_rooms;
        $this->verandas = $verandas;
        $this->bathrooms = $bathrooms;
        $this->kitchens = $kitchens;
        $this->address = $address;
        $this->price = $price;
    }

    public function getRoomId() {
        return $this->room_id;
    }

    public function getOwnerId() {
        return $this->owner_id;
    }

    public function getLocation() {
        return $this->location;
    }

    public function getFloorNumber() {
        return $this->floor_number;
    }

    public function getBedrooms() {
        return $this->bedrooms;
    }

    public function getDrawingRooms() {
        return $this->drawing_rooms;
    }

    public function getDiningRooms() {
        return $this->dining_rooms;
    }

    public function getVerandas() {
        return $this->verandas;
    }

    public function getBathrooms() {
        return $this->bathrooms;
    }

    public function getKitchens() {
        return $this->kitchens;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getTotalPrice() {
        return $this->price;
    }
}

$owner_id = $_SESSION['owner_id'];

$location = '';
$floor_number = 0;
$bedrooms = 0;
$drawing_rooms = 0;
$dining_rooms = 0;
$verandas = 0;
$bathrooms = 0;
$kitchens = 0;
$address = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $location = isset($_POST['location']) ? $_POST['location'] : '';
    $floor_number = isset($_POST['floor_number']) ? intval($_POST['floor_number']) : 0;
    $bedrooms = isset($_POST['bedrooms']) ? intval($_POST['bedrooms']) : 0;
    $drawing_rooms = isset($_POST['drawing_rooms']) ? intval($_POST['drawing_rooms']) : 0;
    $dining_rooms = isset($_POST['dining_rooms']) ? intval($_POST['dining_rooms']) : 0;
    $verandas = isset($_POST['verandas']) ? intval($_POST['verandas']) : 0;
    $bathrooms = isset($_POST['bathrooms']) ? intval($_POST['bathrooms']) : 0;
    $kitchens = isset($_POST['kitchens']) ? intval($_POST['kitchens']) : 0;
    $address = isset($_POST['address']) ? $_POST['address'] : '';

    if (!empty($location) && $floor_number !== 0 && $bedrooms !== 0 && $drawing_rooms !== 0 && $dining_rooms !== 0 && $verandas !== 0 && $bathrooms !== 0 && $kitchens !== 0 && !empty($address)) {
        // Create a new RoomBuilder instance
        $roomBuilder = new RoomBuilder();
        $roomBuilder->setOwnerId($_SESSION['owner_id'])
            ->setLocation($location)
            ->setFloorNumber($floor_number)
            ->setBedrooms($bedrooms)
            ->setDrawingRooms($drawing_rooms)
            ->setDiningRooms($dining_rooms)
            ->setVerandas($verandas)
            ->setBathrooms($bathrooms)
            ->setKitchens($kitchens)
            ->setAddress($address);
        $room = $roomBuilder->build();

        // Calculate total price
        $price = calculateTotalPrice($bedrooms, $drawing_rooms, $dining_rooms, $verandas, $bathrooms, $kitchens);

        // Insert the room into the database
        $sql = "INSERT INTO rooms (owner_id, location, floor_number, bedrooms, drawing_rooms, dining_rooms, verandas, bathrooms, kitchens, address, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("issiiiiissd", $room->getOwnerId(), $room->getLocation(), $room->getFloorNumber(), $room->getBedrooms(), $room->getDrawingRooms(), $room->getDiningRooms(), $room->getVerandas(), $room->getBathrooms(), $room->getKitchens(), $room->getAddress(), $price);
            $stmt->execute();

            // Check for duplicate entry error
            if ($stmt->errno === 1062) {
                echo "Room already exists.";
            } else {
                // Redirect to the Rooms tab after successful insertion
                header("Location: owner_dashboard.php?tab=Rooms");
                exit;
            }
        } else {
            echo "Error: " . $conn->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Please fill in all the required fields.";
    }
}

$conn->close();

// Function to calculate total price
function calculateTotalPrice($bedrooms, $drawing_rooms, $dining_rooms, $verandas, $bathrooms, $kitchens) {
    // Perform your calculation here, for example:
    $price_per_room = 1000; // Example price per room
    $total_rooms = $bedrooms + $drawing_rooms + $dining_rooms + $verandas + $bathrooms + $kitchens;
    return $price_per_room * $total_rooms;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Owner Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-dark">
            <a class="navbar-brand" href="#">Owner Dashboard</a>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link <?php echo $tab === 'My-Profile' ? 'active' : ''; ?>" href="?tab=My-Profile">My-Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $tab === 'Rooms' ? 'active' : ''; ?>" href="?tab=Rooms">Rooms</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </nav>
        <div class="mt-4">
            <h2>Welcome, <?php echo $_SESSION['first_name']; ?>!</h2>
            <p>This is the Owner dashboard. You can manage users, products, orders, and settings from here.</p>
        </div>
        <div class="card">
            <div class="card-header">
                <?php
                if ($tab === 'My-Profile') {
                    echo 'My-Profile';
                } elseif ($tab === 'Rooms') {
                    echo 'Rooms';
                } else {
                    echo 'Invalid Tab';
                }
                ?>
            </div>
            <div class="card-body">
                <?php if ($tab === 'My-Profile'): ?>
                    <?php if (!empty($my_profile)): ?>
                        <table class="table">
                            <!-- Display Owner's Information -->
                            <tr>
                                <td>Owner ID</td>
                                <td><?php echo $my_profile['owner_id']; ?></td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td><?php echo $my_profile['first_name'] . ' ' . $my_profile['last_name']; ?></td>
                            </tr>

                            <!-- Add more fields as needed -->
                        </table>
                    <?php else: ?>
                        <p>No Profile is found.</p>
                    <?php endif; ?>
                <?php elseif ($tab === 'Rooms'): ?>
                    <?php if (!empty($rooms)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Room ID</th>
                                        <th>Location</th>
                                        <th>Address</th>
                                        <th>Floor Number</th>
                                        <th>Bedrooms</th>
                                        <th>Drawing Rooms</th>
                                        <th>Dining Rooms</th>
                                        <th>Verandas</th>
                                        <th>Bathrooms</th>
                                        <th>Kitchens</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rooms as $room): ?>
                                        <tr>
                                            <td><?php echo $room['room_id']; ?></td>
                                            <td><?php echo $room['location']; ?></td>
                                            <td><?php echo $room['address']; ?></td>
                                            <td><?php echo $room['floor_number']; ?></td>
                                            <td><?php echo $room['bedrooms']; ?></td>
                                            <td><?php echo $room['drawing_rooms']; ?></td>
                                            <td><?php echo $room['dining_rooms']; ?></td>
                                            <td><?php echo $room['verandas']; ?></td>
                                            <td><?php echo $room['bathrooms']; ?></td>
                                            <td><?php echo $room['kitchens']; ?></td>
                                            <td><?php echo $room['price']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <button style="padding: 10px 20px; font-size: 16px;" onclick="showAddRoomsForm()">Add more rooms</button>

                        <div id="add-rooms-form" style="display: none;">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?tab=Rooms">
                                <!-- Form fields for room details -->
                                <input type="text" name="location" placeholder="Location" required>
                                <input type="number" name="floor_number" placeholder="Floor Number" required>
                                <input type="number" name="bedrooms" placeholder="Bedrooms" required>
                                <input type="number" name="drawing_rooms" placeholder="Drawing Rooms" required>
                                <input type="number" name="dining_rooms" placeholder="Dining Rooms" required>
                                <input type="number" name="verandas" placeholder="Verandas" required>
                                <input type="number" name="bathrooms" placeholder="Bathrooms" required>
                                <input type="number" name="kitchens" placeholder="Kitchens" required>
                                <textarea name="address" placeholder="Address" required></textarea>
                                <button type="submit">Save Room</button>
                            </form>
                        </div>

                        <script>
                            function showAddRoomsForm() {
                                document.getElementById("add-rooms-form").style.display = "block";
                            }
                        </script>

                    <?php else: ?>
                        <button style="padding: 10px 20px; font-size: 16px;" onclick="showAddRoomsForm()">Add more rooms</button>

                        <div id="add-rooms-form" style="display: none;">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?tab=Rooms">
                                <!-- Form fields for room details -->
                                <input type="text" name="location" placeholder="Location" required>
                                <input type="number" name="floor_number" placeholder="Floor Number" required>
                                <input type="number" name="bedrooms" placeholder="Bedrooms" required>
                                <input type="number" name="drawing_rooms" placeholder="Drawing Rooms" required>
                                <input type="number" name="dining_rooms" placeholder="Dining Rooms" required>
                                <input type="number" name="verandas" placeholder="Verandas" required>
                                <input type="number" name="bathrooms" placeholder="Bathrooms" required>
                                <input type="number" name="kitchens" placeholder="Kitchens" required>
                                <textarea name="address" placeholder="Address" required></textarea>
                                <button type="submit">Save Room</button>
                            </form>
                        </div>

                        <script>
                            function showAddRoomsForm() {
                                document.getElementById("add-rooms-form").style.display = "block";
                            }
                        </script>

                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


