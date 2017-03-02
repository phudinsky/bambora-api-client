<?php
namespace Bambora\Response;

use Bambora\Exception\BamboraException;
use Bambora\Exception\InvalidResponseStructureException;
use Bambora\Response\Api\BaseApiResponse;
use Bambora\Response\Callback\AuthorizeTransactionCallbackResponse;
use Bambora\Response\Callback\BaseCallbackResponse;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class ResponseFactory
{
    /**
     * @var ResponseStructureValidator
     */
    private $validator;

    public function __construct()
    {
        $this->validator = new ResponseStructureValidator(Validation::createValidator());;
    }

    /**
     * @param array $responseData
     * @param string $class
     * @return BaseApiResponse
     */
    public function createApiResponse(array $responseData, string $class) : BaseApiResponse
    {
        $this->validateClass($class, BaseApiResponse::class);

        $metaInfo = $this->createMetaInfo($responseData);

        if ($metaInfo->isSuccessful()) {
            /** @var BaseApiResponse $class */
            $responseRules = $class::getFieldValidationRules();
            $this->validate($responseData, $responseRules);
        }

        return new $class($metaInfo, $responseData);
    }

    /**
     * @param array $data
     * @return AuthorizeTransactionCallbackResponse
     */
    public function createAuthorizeTransactionCallbackResponse(array $data) : AuthorizeTransactionCallbackResponse
    {
        /** @var AuthorizeTransactionCallbackResponse $response */
        $response = $this->createCallbackResponse($data, AuthorizeTransactionCallbackResponse::class);

        return $response;
    }

    /**
     * @param array $responseData
     * @param string $class
     * @return BaseCallbackResponse
     */
    public function createCallbackResponse(array $responseData, string $class) : BaseCallbackResponse
    {
        $this->validateClass($class, BaseCallbackResponse::class);

        /** @var BaseCallbackResponse $class */
        $responseRules = $class::getFieldValidationRules();
        $this->validate($responseData, $responseRules);

        return new $class($responseData);
    }

    /**
     * @param array $responseData
     * @return ResponseMetaInfo
     * @throws InvalidResponseStructureException
     */
    private function createMetaInfo(array $responseData)
    {
        $responseMetaInfoRules = ResponseMetaInfo::getFieldValidationRules();
        $this->validate($responseData, $responseMetaInfoRules);

        return new ResponseMetaInfo($responseData);
    }

    /**
     * @param array $responseData
     * @param array $validationRules
     * @throws InvalidResponseStructureException
     */
    private function validate(array $responseData, array $validationRules)
    {
        $this->validator->validate($responseData, new Assert\Collection([
            'fields' => $validationRules,
            'allowExtraFields' => true,
        ]));
    }

    /**
     * @param string $responseClass
     * @param string $expectedClass
     * @throws BamboraException
     */
    private function validateClass(string $responseClass, string $expectedClass)
    {
        if (!is_subclass_of($responseClass, $expectedClass)) {
            throw $this->createInvalidClassException($expectedClass);
        }
    }

    /**
     * @param string $expectedClass
     * @return BamboraException
     */
    private function createInvalidClassException(string $expectedClass) : BamboraException
    {
        return new BamboraException(
            sprintf(
                "Response class should be instance of '%s'",
                $expectedClass
            )
        );
    }
}
