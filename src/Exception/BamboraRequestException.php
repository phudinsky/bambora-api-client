<?php

namespace Bambora\Exception;

class BamboraRequestException extends BamboraException
{

    /**
     * @var array
     */
    private $requestData;
    /**
     * @var array|null
     */
    private $responseData;

    public function __construct(
        $message,
        array $requestData,
        array $responseData = null,
        $code = 0,
        \Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->requestData = $requestData;
        $this->responseData = $responseData;
    }

    /**
     * @return array
     */
    public function getRequestData(): array
    {
        return $this->requestData;
    }

    /**
     * @return array
     */
    public function getResponseData(): array
    {
        return $this->responseData;
    }
}
