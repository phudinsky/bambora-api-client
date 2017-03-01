<?php
namespace Bambora\Response;

use Bambora\Exception\InvalidResponseStructureException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ResponseStructureValidator
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param array $response
     * @param $constrains
     * @throws InvalidResponseStructureException
     */
    public function validate(array $response, $constrains)
    {
        $validationErrors = $this->validator->validate($response, $constrains);

        if ($validationErrors->count()) {

            $stringError = [];
            /** @var ConstraintViolation $error */
            foreach ($validationErrors as $error) {
                if ($error->getPropertyPath()) {
                    $errorMessage = sprintf("Property '%s': %s", $error->getPropertyPath(), $error->getMessage());
                } else {
                    $errorMessage = $error->getMessage();
                }
                $stringError[] = $errorMessage;
            }

            throw new InvalidResponseStructureException(implode(' ', $stringError));
        }
    }
}
