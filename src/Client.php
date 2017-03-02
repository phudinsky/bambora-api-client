<?php
namespace Bambora;

use Bambora\Exception\BamboraRequestException;
use Bambora\Response\ResponseStructureValidator;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client as HttpClient;
use Bambora\Request\AuthorizeTransactionRequest;
use Bambora\Request\BaseRequest;
use Bambora\Request\CaptureTransactionRequest;
use Bambora\Request\InitiateSessionsRequest;
use Bambora\Request\DeleteTransactionRequest;
use Bambora\Response\Api\AuthorizeTransactionApiResponse;
use Bambora\Response\Api\BaseApiResponse;
use Bambora\Response\Api\CaptureTransactionApiResponse;
use Bambora\Response\Api\InitializeSessionUrlApiResponse;
use Bambora\Response\Api\DeleteTransactionApiResponse;
use Bambora\Response\ResponseFactory;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validation;

class Client
{
    /**
     * @var HttpClient
     */
    private $httpClient;
    /**
     * @var ResponseFactory
     */
    private $responseFactory;
    /**
     * @var Serializer
     */
    private $requestSerializer;
    /**
     * @var string
     */
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;

        $this->httpClient = $this->createHttpClient();
        $this->responseFactory = $this->createResponseFactory();
        $this->requestSerializer = $this->createRequestSerializer();
    }

    /**
     * @param \Bambora\Request\InitiateSessionsRequest $request
     * @return \Bambora\Response\Api\InitializeSessionUrlApiResponse
     */
    public function getCheckoutUrl(InitiateSessionsRequest $request) : InitializeSessionUrlApiResponse
    {
        /** @var InitializeSessionUrlApiResponse $response */
        $response = $this->request($request, InitializeSessionUrlApiResponse::class);

        return $response;
    }

    /**
     * @param \Bambora\Request\CaptureTransactionRequest $request
     * @return \Bambora\Response\Api\CaptureTransactionApiResponse
     */
    public function capture(CaptureTransactionRequest $request) : CaptureTransactionApiResponse
    {
        /** @var CaptureTransactionApiResponse $response */
        $response = $this->request($request, CaptureTransactionApiResponse::class);

        return $response;
    }

    /**
     * @param \Bambora\Request\AuthorizeTransactionRequest $request
     * @return \Bambora\Response\Api\AuthorizeTransactionApiResponse
     */
    public function authorize(AuthorizeTransactionRequest $request) : AuthorizeTransactionApiResponse
    {
        /** @var AuthorizeTransactionApiResponse $response */
        $response = $this->request($request, AuthorizeTransactionApiResponse::class);

        return $response;
    }

    /**
     * @param \Bambora\Request\DeleteTransactionRequest $request
     * @return \Bambora\Response\Api\DeleteTransactionApiResponse
     */
    public function delete(DeleteTransactionRequest $request) : DeleteTransactionApiResponse
    {
        /** @var DeleteTransactionApiResponse $response */
        $response = $this->request($request, DeleteTransactionApiResponse::class);

        return $response;
    }

    /**
     * @param \Bambora\Request\BaseRequest $request
     * @param string $responseClass
     * @return \Bambora\Response\Api\BaseApiResponse
     * @throws \Bambora\Exception\BamboraRequestException
     */
    protected function request(BaseRequest $request, string $responseClass) : BaseApiResponse
    {
        $normalizedRequest = $this->requestSerializer->normalize($request);

        try {
            $rawResponse = $this->httpClient->request(
                $request->getMeta()->getHttpMethod(),
                $request->getMeta()->getUrl(),
                [
                    'json' => $normalizedRequest
                ]
            );
        } catch (RequestException $e) {
            throw new BamboraRequestException($e->getMessage());
        }

        $normalizedResponse = $this->requestSerializer->decode($rawResponse->getBody()->getContents(), 'json');

        return $this->responseFactory->createApiResponse($normalizedResponse, $responseClass);
    }

    /**
     * @return ResponseFactory
     */
    protected function createResponseFactory() : ResponseFactory
    {
        $validator = new ResponseStructureValidator(Validation::createValidator());

        return new ResponseFactory($validator);
    }

    /**
     * @return Serializer
     */
    protected function createRequestSerializer() : Serializer
    {
        $normalizer = new PropertyNormalizer();
        $normalizer->setIgnoredAttributes(['meta']);

        return new Serializer([$normalizer], [new JsonDecode(true)]);
    }

    /**
     * @return HttpClient
     */
    protected function createHttpClient() : HttpClient
    {
        return new HttpClient([
            'timeout' => 30,
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => sprintf('Basic %s', $this->apiKey)
            ]
        ]);
    }
}
