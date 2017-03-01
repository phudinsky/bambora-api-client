<?php
namespace Bambora\Request\AuthorizeRequest;

class Authorize
{
    /** @var  int */
    private $amount;

    /** @var  string */
    private $currency;

    /** @var  string */
    private $orderid;

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return static
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return static
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderid;
    }

    /**
     * @param string $orderId
     * @return static
     */
    public function setOrderId($orderId)
    {
        $this->orderid = $orderId;

        return $this;
    }
}
