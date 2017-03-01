<?php
namespace Bambora\Response;

use Symfony\Component\Validator\Constraint;

interface FieldValidationProviderInterface
{
    /**
     * @return Constraint[]
     */
    public static function getFieldValidationRules() : array;
}
