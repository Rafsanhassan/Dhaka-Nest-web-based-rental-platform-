<?php
class BookingObserver
{
    private $observers = [];

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

    public function notify($data)
    {
        foreach ($this->observers as $observer) {
            $observer($data);
        }
    }
}