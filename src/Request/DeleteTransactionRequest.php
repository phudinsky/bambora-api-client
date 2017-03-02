<?php
namespace Bambora\Request;

use Bambora\BamboraEndpoints;

class DeleteTransactionRequest extends BaseRequest
{
    public function __construct(string $transactionId)
    {
        $this->meta = new RequestMetaInformation("POST", BamboraEndpoints::deleteTransaction($transactionId));
    }
}
