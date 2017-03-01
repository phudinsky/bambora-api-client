<?php
namespace Bambora\Request;

use Bambora\Request\CheckoutUrlRequest\Order;
use Bambora\Request\CheckoutUrlRequest\Subscription;
use Bambora\Request\CheckoutUrlRequest\Url;
use Bambora\BamboraEndpoints;

class CheckoutUrlRequest extends BaseRequest
{
    /** @var  string */
    private $language;

    /** @var  Order */
    private $order;

    /** @var  Url */
    private $url;

    /** @var  Subscription */
    private $subscription;

    public function __construct()
    {
        $this->meta = new RequestMetaInformation("POST", BamboraEndpoints::checkoutUrl());
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return static
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     * @return static
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return Url
     */
    public function getUrl(): Url
    {
        return $this->url;
    }

    /**
     * @param Url $url
     * @return static
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Subscription
     */
    public function getSubscription(): Subscription
    {
        return $this->subscription;
    }

    /**
     * @param Subscription $subscription
     * @return static
     */
    public function setSubscription($subscription)
    {
        $this->subscription = $subscription;

        return $this;
    }
}
