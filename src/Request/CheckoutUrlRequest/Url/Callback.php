<?php
namespace Bambora\Request\CheckoutUrlRequest\Url;

class Callback
{
    /** @var  string */
    private $url;

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return static
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
}
