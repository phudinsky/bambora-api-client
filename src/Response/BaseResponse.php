<?php
namespace Bambora\Response;

use Symfony\Component\Validator\Constraints as Assert;

abstract class BaseResponse implements FieldValidationProviderInterface
{
    /**
     * @var array
     */
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getRawData() : array
    {
        return $this->data;
    }
}
