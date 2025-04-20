<?php
class BookingObserver
{
    private $observers = [];
    private $databaseProxy;

    public function __construct($databaseProxy)
    {
        $this->databaseProxy = $databaseProxy;
    }

    public function subscribe($callback)
    {
        $this->observers[] = $callback;
    }

    public function unsubscribe($callback)
    {
        $key = array_search($callback, $this->observers, true);
        if ($key !== false) {
            unset($this->observers[$key]);
        }
    }

    public function notify($type)
    {
        $data = null;

        switch ($type) {
            case 'recent-order':
                $data = $this->getRecentOrder();
                break;
            case 'booking-details':
                $data = $this->getBookingDetails();
                break;
            case 'customers':
                $data = $this->getCustomers();
                break;
        }

        foreach ($this->observers as $observer) {
            $observer($data);
        }
    }

    public function getRecentOrder()
    {
        $sql = "SELECT * FROM booking ORDER BY book_id DESC LIMIT 1";
        $result = $this->databaseProxy->executeQuery($sql);
        return $result->fetch_assoc();
    }

    public function getBookingDetails()
    {
        $sql = "SELECT b.*, c.first_name, c.last_name, c.phone_no, r.location
                FROM booking b
                JOIN customer c ON b.customer_id = c.customer_id
                JOIN rooms r ON b.room_id = r.room_id";
        $result = $this->databaseProxy->executeQuery($sql);
        $bookings = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookings[] = $row;
            }
        }
        return $bookings;
    }

    public function getCustomers()
    {
        $sql = "SELECT customer_id, first_name, last_name, order_count, customer_type
                FROM customer";
        $result = $this->databaseProxy->executeQuery($sql);
        $customers = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $customers[] = $row;
            }
        }
        return $customers;
    }
}
?>
