<?php
namespace Bambora\Request\CheckoutUrlRequest;

class Order
{
    /** @var  string */
    private $currency;

    /** @var  string */
    private $ordernumber;

    /** @var  int */
    private $total;

    /** @var  int */
    private $vatamount;

    /**
     * @return string
     */
    public function getCurrency(): string
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
    public function getOrderNumber(): string
    {
        return $this->ordernumber;
    }

    /**
     * @param string $orderNumber
     * @return static
     */
    public function setOrderNumber($orderNumber)
    {
        $this->ordernumber = $orderNumber;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     * @return static
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return int
     */
    public function getVatAmount(): int
    {
        return $this->vatamount;
    }

    /**
     * @param int $vatAmount
     * @return static
     */
    public function setVatAmount($vatAmount)
    {
        $this->vatamount = $vatAmount;

        return $this;
    }
}
