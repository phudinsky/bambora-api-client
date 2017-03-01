<?php
namespace Bambora\Request;

use Bambora\BamboraEndpoints;
use Bambora\Request\AuthorizeRequest\Authorize;

class AuthorizeRequest extends BaseRequest
{
    /** @var  Authorize */
    private $authorize;

    public function __construct(string $transactionId)
    {
        $this->meta = new RequestMetaInformation("POST", BamboraEndpoints::authorize($transactionId));
    }

    /**
     * @return Authorize
     */
    public function getAuthorize(): Authorize
    {
        return $this->authorize;
    }

    /**
     * @param Authorize $authorize
     * @return static
     */
    public function setAuthorize(Authorize $authorize = null)
    {
        $this->authorize = $authorize;

        return $this;
    }
}
