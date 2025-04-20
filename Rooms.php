<!DOCTYPE html>
<html>
<head>
<title>Rooms</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="template.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", Arial, Helvetica, sans-serif}
</style>
</head>
<body class="w3-light-grey">

<!-- Navigation Bar -->

<div class="w3-bar w3-white w3-large">
   <img src="dhakanest.png" alt="dhakanest Logo">
  <!-- <a href="#" class="w3-bar-item w3-button w3-mobile"></i>.dhakanest</a> -->
  
</div>

<!-- Page content -->
<div class="w3-content" style="max-width:1500px;">

  <div class="w3-container w3-margin-top">
    <h2>Rooms</h2>
  </div>
  
  <div class="w3-row-padding w3-padding-16">
    <?php
    // Step 1: Establish a connection to the database
    $conn = new mysqli('localhost', 'root', '', 'dhakanest');

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Step 2: Retrieve the selected location from the query parameter
    $selectedLocation = $_GET['location'];
	

    // Step 3: Prepare and execute the query to retrieve room details for the selected location
    $stmt = $conn->prepare("SELECT * FROM rooms WHERE location = ? LIMIT 15");
    $stmt->bind_param("s", $selectedLocation);
    $stmt->execute();
    $result = $stmt->get_result();

    // Step 4: Check if there are rooms available in the selected location
    if ($result->num_rows > 0) {
      // Step 5: Iterate over the result set and display the room details
      while ($row = $result->fetch_assoc()) {
        echo '<div class="w3-third w3-margin-bottom">';
        echo '<div class="w3-container w3-white">';
        echo '<img src="Roomss.jpg" alt="Room Image" style="width:100%">';
        echo '<p>' . $row['address'] . '</p>';
        //echo '<p>' . 'Location' . '  ' . $row['location'] . '</p>';
        echo '<p>' . $row['location'] . '  ' . 'Location' . '</p>';
        
        echo '<p>' . 'Floor No.' . '  ' . $row['floor_number'] . '</p>';
        echo '<p><strong>Amenities::</strong></p>';
        echo '<p>' . $row['bedrooms'] . '  ' . 'Bedroom' . '</p>';
       
        echo '<p>'. $row['drawing_rooms'] . '  '  . 'Drawing room' . '</p>';
        
        echo '<p>' . $row['dining_rooms'] . '  '. 'Dining room' . '</p>';
       
        echo '<p>'  . $row['verandas'] .  '  ' . 'Veranda' . '</p>';
        
        echo '<p>'  . $row['bathrooms'] . '  ' . 'Bathroom' . '</p>';
        
        echo '<p>'. $row['kitchens'] . '  '  . 'Kitchen' . '</p>';
        echo '<p>' . 'Price' .' - ৳' . $row['price'] . '/night</p>';
        
		// Inside the while loop where you display the rooms
        echo '<a href="Book now.php?room_id=' . $row['room_id'] . '&location=' . urlencode($selectedLocation) . '">Book now</a>';

        echo '</div>';
        echo '</div>';
      } 
    } else {
      echo '<p>No rooms available in the selected location.</p>';
    }

    // Step 6: Close the database connection
    $stmt->close();
    $conn->close();
    ?>
  </div>

</div>

<!-- Footer -->
<footer class="w3-padding-32 w3-black w3-center w3-margin-top">
  <h5>Find Us On</h5>
  <div class="w3-xlarge w3-padding-16">
    <a href="https://www.facebook.com/your-page-url" target="_blank" rel="noopener noreferrer"><i class="fa fa-facebook-official w3-hover-opacity"></i></a>
    <a href="https://www.instagram.com/your-page-url" target="_blank" rel="noopener noreferrer"><i class="fa fa-instagram w3-hover-opacity"></i></a>
    <a href="https://twitter.com/your-page-url" target="_blank" rel="noopener noreferrer"><i class="fa fa-twitter w3-hover-opacity"></i></a>
    <a href="https://www.linkedin.com/company/your-page-url" target="_blank" rel="noopener noreferrer"><i class="fa fa-linkedin w3-hover-opacity"></i></a>

  </div>
  <div class="Rights">
	   <p>&copy; 2024 dhakanest. All rights reserved.</p>
	</div>
</footer>

</body>
</html>

