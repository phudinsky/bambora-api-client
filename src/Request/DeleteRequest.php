<?php
namespace Bambora\Request;

use Bambora\BamboraEndpoints;

class DeleteRequest extends BaseRequest
{
    public function __construct(string $transactionId)
    {
        $this->meta = new RequestMetaInformation("POST", BamboraEndpoints::delete($transactionId));
    }
}
