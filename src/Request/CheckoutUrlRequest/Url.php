<?php
namespace Bambora\Request\CheckoutUrlRequest;

use Bambora\Request\CheckoutUrlRequest\Url\Callback;

class Url
{
    /** @var  string */
    private $accept;

    /** @var  string */
    private $decline;

    /** @var  string */
    private $immediateredirecttoaccept;

    /** @var  Callback[] */
    private $callbacks = [];

    /**
     * @return string
     */
    public function getAccept(): string
    {
        return $this->accept;
    }

    /**
     * @param string $accept
     * @return static
     */
    public function setAccept($accept)
    {
        $this->accept = $accept;

        return $this;
    }

    /**
     * @return string
     */
    public function getDecline(): string
    {
        return $this->decline;
    }

    /**
     * @param string $decline
     * @return static
     */
    public function setDecline($decline)
    {
        $this->decline = $decline;

        return $this;
    }

    /**
     * @return string
     */
    public function getImmediateRedirectToAccept(): string
    {
        return $this->immediateredirecttoaccept;
    }

    /**
     * @param string $immediateRedirectToAccept
     * @return static
     */
    public function setImmediateRedirectToAccept($immediateRedirectToAccept)
    {
        $this->immediateredirecttoaccept = $immediateRedirectToAccept;

        return $this;
    }

    /**
     * @return \Callback[]
     */
    public function getCallbacks(): array
    {
        return $this->callbacks;
    }

    /**
     * @param \Callback[] $callbacks
     * @return static
     */
    public function setCallbacks(array $callbacks)
    {
        $this->callbacks = $callbacks;

        return $this;
    }
}
