<?php
namespace Bambora\Response\Api;

use Symfony\Component\Validator\Constraints as Assert;

class DeleteApiResponse extends BaseApiResponse
{
    /**
     * @inheritdoc
     */
    public static function getFieldValidationRules() : array
    {
        return [
            'transactionoperations' => new Assert\All([
                'constraints' => [
                    new Assert\Collection([
                        'id' => [
                            new Assert\NotBlank(),
                            new Assert\Type("numeric"),
                        ]
                    ])
                ]
            ]),
        ];
    }
}
