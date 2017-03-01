<?php
namespace Bambora\Response;

use Symfony\Component\Validator\Constraints as Assert;

class ResponseMetaInfo implements FieldValidationProviderInterface
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @return array
     */
    public static function getFieldValidationRules() : array
    {
        return [
            'meta' => new Assert\Collection([
                'fields' => [
                    'result' => [
                        new Assert\NotNull(),
                        new Assert\Type("boolean"),
                    ],
                    'message' => new Assert\Collection([
                        'fields' => [
                            'enduser' => [
                                new Assert\Type("string"),
                            ],
                            'merchant' => [
                                new Assert\Type("string"),
                            ]
                        ],
                        'allowExtraFields' => true,
                    ])
                ],
                'allowExtraFields' => true,
            ])
        ];
    }

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return bool
     */
    public function isSuccessful() : bool
    {
        return $this->data['meta']['result'];
    }

    /**
     * @return string|null
     */
    public function getEndUserMessage()
    {
        return $this->data['meta']['message']['enduser'];
    }

    /**
     * @return string|null
     */
    public function getSystemMessage()
    {
        return $this->data['meta']['message']['merchant'];
    }
}
