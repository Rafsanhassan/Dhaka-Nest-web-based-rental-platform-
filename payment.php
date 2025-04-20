<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="template.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body, h1, h2, h3, h4, h5, h6 {
            font-family: "Raleway", Arial, Helvetica, sans-serif;
        }
        .payment-option {
            background-color: #f1f1f1;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            cursor: pointer;
            box-shadow: 0 2px 4px 0 rgba(0,0,0,0.2);
        }
        .payment-option:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body class="w3-light-grey">

<!-- Navigation Bar -->
<div class="w3-bar w3-white w3-large">
    <img src="dhakanest.png" alt="dhakanest Logo">
    <a href="logout.php" class="w3-bar-item w3-button w3-right">Logout</a>
</div>

<!-- Page content -->
<div class="w3-content" style="max-width:800px;margin-top:80px">

    <div class="w3-container">
        <h2>Payment</h2>
    </div>

    <div class="w3-container w3-white w3-padding-16">
        <h3>Select Payment Option</h3>
        <div class="payment-option" onclick="payWithBkash()">
            <h4>Bkash</h4>
            <p>Pay securely with your Bkash account.</p>
        </div>
        <div class="payment-option" onclick="payWithNagad()">
            <h4>Nagad</h4>
            <p>Pay securely with your Nagad account.</p>
        </div>
        <div class="payment-option" onclick="payWithCard()">
            <h4>Card</h4>
            <p>Pay securely with your credit or debit card.</p>
        </div>
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

<script>
    // Strategy Design Pattern
    class PaymentStrategy {
        pay(totalDays, totalPrice) {
            throw new Error('Method not implemented');
        }
    }

    class BkashPayment extends PaymentStrategy {
        pay(totalDays, totalPrice) {
            alert(`Payment via Bkash\nTotal Days: ${totalDays}\nTotal Price: ${totalPrice} Taka`);
            // Save payment details to the database
            savePaymentDetails('Bkash', totalPrice);
        }
    }

    class NagadPayment extends PaymentStrategy {
        pay(totalDays, totalPrice) {
            alert(`Payment via Nagad\nTotal Days: ${totalDays}\nTotal Price: ${totalPrice} Taka`);
            // Save payment details to the database
            savePaymentDetails('Nagad', totalPrice);
        }
    }

    class CardPayment extends PaymentStrategy {
        pay(totalDays, totalPrice) {
            alert(`Payment via Card\nTotal Days: ${totalDays}\nTotal Price: ${totalPrice} Taka`);
            // Save payment details to the database
            savePaymentDetails('Card', totalPrice);
        }
    }

    function payWithBkash() {
        const paymentStrategy = new BkashPayment();
        const totalDays = <?php echo isset($_GET['total_days']) ? $_GET['total_days'] : 0; ?>;
        const totalPrice = <?php echo isset($_GET['total_price']) ? $_GET['total_price'] : 0; ?>;
        paymentStrategy.pay(totalDays, totalPrice);
    }

    function payWithNagad() {
        const paymentStrategy = new NagadPayment();
        const totalDays = <?php echo isset($_GET['total_days']) ? $_GET['total_days'] : 0; ?>;
        const totalPrice = <?php echo isset($_GET['total_price']) ? $_GET['total_price'] : 0; ?>;
        paymentStrategy.pay(totalDays, totalPrice);
    }

    function payWithCard() {
        const paymentStrategy = new CardPayment();
        const totalDays = <?php echo isset($_GET['total_days']) ? $_GET['total_days'] : 0; ?>;
        const totalPrice = <?php echo isset($_GET['total_price']) ? $_GET['total_price'] : 0; ?>;
        paymentStrategy.pay(totalDays, totalPrice);
    }

    function savePaymentDetails(paymentType, totalPrice) {
        // Perform AJAX request to save payment details to the database
        const status = 'Paid'; // Set the status to 'Paid'
        const bookId = <?php echo isset($_SESSION['book_id']) ? $_SESSION['book_id'] : 0; ?>;

        $.ajax({
            url: 'process_payment.php',
            type: 'POST',
            data: {
                payment_type: paymentType,
                total_price: totalPrice,
                status: status,
                book_id: bookId
            },
            success: function(response) {
                console.log(response);
                // Handle success response, e.g., redirect to a success page
                window.location.href = 'Home.php';
            },
            error: function(xhr, status, error) {
                console.error(error);
                // Handle error response
            }
        });
    }
</script>

</body>
</html>