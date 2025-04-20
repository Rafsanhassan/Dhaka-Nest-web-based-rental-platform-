<?php

// Customer interface
interface Customer
{
    public function getCustomerDetails();
    public function getOrderCount();
    public function getCustomerType();
    public function incrementOrderCount();
}

// Concrete Customer class
class BasicCustomer implements Customer
{
    private $customerId;
    private $name;
    private $email;
    private $phoneNo;
    private $orderCount = 0;

    public function __construct($customerId, $name, $email, $phoneNo)
    {
        $this->customerId = $customerId;
        $this->name = $name;
        $this->email = $email;
        $this->phoneNo = $phoneNo;
    }

    public function getCustomerDetails()
    {
        return [
            'customerId' => $this->customerId,
            'name' => $this->name,
            'email' => $this->email,
            'phoneNo' => $this->phoneNo,
        ];
    }

    public function getOrderCount()
    {
        return $this->orderCount;
    }

    public function getCustomerType()
    {
        return 'Basic';
    }

    public function incrementOrderCount()
    {
        $this->orderCount++;
    }
}

// Decorator class
abstract class CustomerDecorator implements Customer
{
    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function getCustomerDetails()
    {
        return $this->customer->getCustomerDetails();
    }

    public function getOrderCount()
    {
        return $this->customer->getOrderCount();
    }

    public function getCustomerType()
    {
        return $this->customer->getCustomerType();
    }

    public function incrementOrderCount()
    {
        $this->customer->incrementOrderCount();
    }
}

// Concrete Decorator classes
class PremiumCustomerDecorator extends CustomerDecorator
{
    public function getCustomerType()
    {
        $orderCount = $this->customer->getOrderCount();
        if ($orderCount >= 3 && $orderCount < 5) {
            return 'Premium';
        }
        return $this->customer->getCustomerType();
    }
}

class LoyalCustomerDecorator extends CustomerDecorator
{
    public function getCustomerType()
    {
        $orderCount = $this->customer->getOrderCount();
        if ($orderCount >= 5) {
            return 'Loyal';
        }
        return $this->customer->getCustomerType();
    }
}

function decorateCustomer($customer)
{
    $orderCount = $customer->getOrderCount();
    if ($orderCount >= 3 && $orderCount < 5) {
        $customer = new PremiumCustomerDecorator($customer);
    } elseif ($orderCount >= 5) {
        $customer = new LoyalCustomerDecorator($customer);
    }
    return $customer;
}