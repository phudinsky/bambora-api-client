<?php
namespace Bambora\Response\Api;

use Symfony\Component\Validator\Constraints as Assert;

class AuthorizeTransactionApiResponse extends BaseApiResponse
{
    /**
     * @inheritdoc
     */
    public static function getFieldValidationRules() : array
    {
        return [
            'transactionid' => [
                new Assert\NotBlank(),
                new Assert\Type("numeric"),
            ],
        ];
    }

    /**
     * @return string
     */
    public function getTransactionId() : string
    {
        return $this->data['transactionid'];
    }
}
