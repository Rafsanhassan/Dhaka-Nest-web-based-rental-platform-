<!DOCTYPE html>
<html>
<head>
<title>Book Now</title>
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
</div>

<!-- Page content -->
<div class="w3-content" style="max-width:800px;margin-top:80px">

  <div class="w3-container">
    <h2>Book Now</h2>
  </div>

  <div class="w3-container w3-white w3-padding-16">
    <form action="process_booking.php" method="POST">
      <input type="hidden" name="room_id" value="<?php echo $_GET['room_id']; ?>">
      <input type="hidden" name="location" value="<?php echo $_GET['location']; ?>">
      
      <label for="check_in">Check-in Date:</label>
      <input class="w3-input w3-border" type="text" placeholder="YYYY-MM-DD" name="check_in_date" required> 
      <br><br>
      <label for="check_out">Check-out Date:</label>
      <input class="w3-input w3-border" type="text" placeholder="YYYY-MM-DD" name="check_out_date" required> 
      <br><br>
      <input type="submit" value="Book Now">
    </form>
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
