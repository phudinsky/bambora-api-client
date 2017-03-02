<?php
namespace Bambora\Response\Api;

use Symfony\Component\Validator\Constraints as Assert;

class InitializeSessionUrlApiResponse extends BaseApiResponse
{
    /**
     * @inheritdoc
     */
    public static function getFieldValidationRules() : array
    {
        return [
            'url' => [
                new Assert\NotBlank(),
                new Assert\Type("string"),
            ],
            'token' => [
                new Assert\NotBlank(),
                new Assert\Type("string"),
            ],
        ];
    }

    /**
     * @return string
     */
    public function getUrl() : string
    {
        return $this->data['url'];
    }

    /**
     * @return string
     */
    public function getToken() : string
    {
        return $this->data['token'];
    }
}
