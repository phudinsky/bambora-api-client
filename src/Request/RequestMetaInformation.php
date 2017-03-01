<?php
namespace Bambora\Request;

class RequestMetaInformation
{
    /** @var  string */
    protected $httpMethod;

    /** @var  string */
    protected $url;

    public function __construct(string $httpMethod, string $url)
    {
        $this->httpMethod = $httpMethod;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}
