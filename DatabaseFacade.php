<?php
require_once 'BookingObserver.php';

class DatabaseFacade
{
    private $bookingObserver;

    public function __construct($databaseProxy)
    {
        $this->bookingObserver = new BookingObserver($databaseProxy);
    }

    public function getRecentOrder()
    {
        return $this->bookingObserver->getRecentOrder();
    }

    public function getBookingDetails()
    {
        return $this->bookingObserver->getBookingDetails();
    }

    public function getCustomers()
    {
        return $this->bookingObserver->getCustomers();
    }
}
?>
