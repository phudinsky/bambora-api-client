<?php
namespace Bambora\Request;

use Bambora\BamboraEndpoints;

class CaptureRequest extends BaseRequest
{
    /** @var  int */
    private $amount;

    /** @var  string */
    private $currency;

    public function __construct(string $transactionId)
    {
        $this->meta = new RequestMetaInformation("POST", BamboraEndpoints::capture($transactionId));
    }

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
}
