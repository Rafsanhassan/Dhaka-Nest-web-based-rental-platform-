<!DOCTYPE html>
<html>
<head>
    <title>Room Selection</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="template.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body, h1, h2, h3, h4, h5, h6 {
            font-family: "Raleway", Arial, Helvetica, sans-serif
        }
    </style>
</head>
<body class="w3-light-grey">

<!-- Navigation Bar -->
<div class="w3-bar w3-white w3-large">
    <img src="dhakanest.png" alt="dhakanest Logo">
    <!-- <a href="#" class="w3-bar-item w3-button w3-mobile">.dhakanest</a> -->
</div>

<!-- Page content -->
<div class="w3-content" style="max-width:800px;margin-top:80px">

    <div class="w3-container">
        <h2>Room Selection</h2>
    </div>

    <?php
    // Decorator Pattern Implementation

    interface Room
    {
        public function getDescription();
        public function getPrice();
    }

    class BasicRoom implements Room
    {
        private $description;
        private $price;

        public function __construct($description, $price)
        {
            $this->description = $description;
            $this->price = $price;
        }

        public function getDescription()
        {
            return $this->description;
        }

        public function getPrice()
        {
            return $this->price;
        }
    }

    abstract class RoomDecorator implements Room
    {
        protected $room;

        public function __construct(Room $room)
        {
            $this->room = $room;
        }

        public function getDescription()
        {
            return $this->room->getDescription();
        }

        public function getPrice()
        {
            return $this->room->getPrice();
        }
    }

    class AirConditioningDecorator extends RoomDecorator
    {
        private $acPrice;

        public function __construct(Room $room, $acPrice)
        {
            parent::__construct($room);
            $this->acPrice = $acPrice;
        }

        public function getDescription()
        {
            return parent::getDescription() . ', Air Conditioning';
        }

        public function getPrice()
        {
            return parent::getPrice() + $this->acPrice;
        }
    }

    class FurnishingDecorator extends RoomDecorator
    {
        private $furnishingPrice;

        public function __construct(Room $room, $furnishingPrice)
        {
            parent::__construct($room);
            $this->furnishingPrice = $furnishingPrice;
        }

        public function getDescription()
        {
            return parent::getDescription() . ', Furnished';
        }

        public function getPrice()
        {
            return parent::getPrice() + $this->furnishingPrice;
        }
    }

    class MealServiceDecorator extends RoomDecorator
    {
        private $mealServicePrice;

        public function __construct(Room $room, $mealServicePrice)
        {
            parent::__construct($room);
            $this->mealServicePrice = $mealServicePrice;
        }

        public function getDescription()
        {
            return parent::getDescription() . ', Meal Service';
        }

        public function getPrice()
        {
            return parent::getPrice() + $this->mealServicePrice;
        }
    }

    // Sample rooms
    $basicRoom = new BasicRoom('Standard Room', 100.00);
    $acRoom = new AirConditioningDecorator($basicRoom, 20.00);
    $furnishedRoom = new FurnishingDecorator($acRoom, 30.00);
    $mealServiceRoom = new MealServiceDecorator($furnishedRoom, 40.00);

    // Display room options
    $rooms = array($basicRoom, $acRoom, $furnishedRoom, $mealServiceRoom);
    foreach ($rooms as $room) {
        echo '<div class="w3-container w3-white w3-padding-16">';
        echo '<img src="pic1.jpg" alt="Room Image" style="width:100%;">'; // Add room image
        echo '<h3>' . $room->getDescription() . '</h3>';
        echo '<p>Price: $' . $room->getPrice() . '</p>';
        echo '<form action="" method="POST">';
        echo '<input type="hidden" name="room_description" value="' . $room->getDescription() . '">';
        echo '<input type="hidden" name="room_price" value="' . $room->getPrice() . '">';
        echo '<input type="submit" value="Confirm">';
        echo '</form>';
        echo '</div>';
    }
    ?>

</div>

<!-- Footer -->
<footer class="w3-padding-32 w3-black w3-center w3-margin-top">
    <h5>Find Us On</h5>
    <div class="w3-xlarge w3-padding-16">
        <a href="https://www.facebook.com/your-page-url" target="_blank" rel="noopener noreferrer"><i class="fa fa-facebook-official w3-hover-opacity"></i></a>
        <a href="https://www.instagram.com/your-page-url" target="_blank" rel="noopener noreferrer"><i class="fa fa-instagram w3-hover-opacity"></i></a>
        <a href="https://twitter.com/your-page-url" target="_blank" rel="noopener noreferrer"><i class="fa fa-twitter w3-hover -opacity"></i></a>
        <a href="https://www.linkedin.com/company/your-page-url" target="_blank" rel="noopener noreferrer"><i class="fa fa-linkedin w3-hover-opacity"></i></a>
    </div>
    <div class="Rights">
        <p>&copy; 2024 DhakaNest. All rights reserved.</p>
    </div>
</footer>

</body>
</html>