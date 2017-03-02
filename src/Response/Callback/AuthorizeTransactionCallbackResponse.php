<?php
namespace Bambora\Response\Callback;

use Symfony\Component\Validator\Constraints as Assert;

class AuthorizeTransactionCallbackResponse extends BaseCallbackResponse
{
    /**
     * @inheritdoc
     */
    public static function getFieldValidationRules() : array
    {
        return [
            'txnid' => [
                new Assert\NotBlank(),
                new Assert\Type("numeric"),
            ],
            'subscriptionid' => [
                new Assert\Type("numeric"),
            ],
            'orderid' => [
                new Assert\Type("string"),
            ],
        ];
    }

    /**
     * @return string
     */
    public function getTransactionId() : string
    {
        return $this->data['txnid'];
    }

    /**
     * @return string
     */
    public function getSubscriptionId() : string
    {
        return $this->data['subscriptionid'];
    }

    /**
     * @return string
     */
    public function getOrderId() : string
    {
        return $this->data['orderid'];
    }
}
