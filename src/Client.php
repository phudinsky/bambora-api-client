<?php
namespace Bambora;

use Bambora\Exception\BamboraRequestException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client as HttpClient;
use Bambora\Request\AuthorizeRequest;
use Bambora\Request\BaseRequest;
use Bambora\Request\CaptureRequest;
use Bambora\Request\CheckoutUrlRequest;
use Bambora\Request\DeleteRequest;
use Bambora\Response\Api\AuthorizeApiResponse;
use Bambora\Response\Api\BaseApiResponse;
use Bambora\Response\Api\CaptureApiResponse;
use Bambora\Response\Api\CheckoutUrlApiResponse;
use Bambora\Response\Api\DeleteApiResponse;
use Bambora\Response\ResponseFactory;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

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
    private $requestNormalizer;

    public function __construct(HttpClient $httpClient, ResponseFactory $responseFactory)
    {
        $this->httpClient = $httpClient;
        $this->responseFactory = $responseFactory;

        $normalizer = new PropertyNormalizer();
        $normalizer->setIgnoredAttributes(['meta']);

        $this->requestNormalizer = new Serializer([$normalizer], [new JsonDecode(true)]);
    }

    /**
     * @param \Bambora\Request\CheckoutUrlRequest $request
     * @return \Bambora\Response\Api\CheckoutUrlApiResponse
     */
    public function getCheckoutUrl(CheckoutUrlRequest $request) : CheckoutUrlApiResponse
    {
        /** @var CheckoutUrlApiResponse $response */
        $response = $this->request($request, CheckoutUrlApiResponse::class);

        return $response;
    }

    /**
     * @param \Bambora\Request\CaptureRequest $request
     * @return \Bambora\Response\Api\CaptureApiResponse
     */
    public function capture(CaptureRequest $request) : CaptureApiResponse
    {
        /** @var CaptureApiResponse $response */
        $response = $this->request($request, CaptureApiResponse::class);

        return $response;
    }

    /**
     * @param \Bambora\Request\AuthorizeRequest $request
     * @return \Bambora\Response\Api\AuthorizeApiResponse
     */
    public function authorize(AuthorizeRequest $request) : AuthorizeApiResponse
    {
        /** @var AuthorizeApiResponse $response */
        $response = $this->request($request, AuthorizeApiResponse::class);

        return $response;
    }

    /**
     * @param \Bambora\Request\DeleteRequest $request
     * @return \Bambora\Response\Api\DeleteApiResponse
     */
    public function delete(DeleteRequest $request) : DeleteApiResponse
    {
        /** @var DeleteApiResponse $response */
        $response = $this->request($request, DeleteApiResponse::class);

        return $response;
    }

    /**
     * @param \Bambora\Request\BaseRequest $request
     * @param string $responseClass
     * @return \Bambora\Response\Api\BaseApiResponse
     * @throws \Bambora\Exception\BamboraRequestException
     */
    private function request(BaseRequest $request, string $responseClass) : BaseApiResponse
    {
        $normalizedRequest = $this->requestNormalizer->normalize($request);

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

        $normalizedResponse = $this->requestNormalizer->decode($rawResponse->getBody()->getContents(), 'json');

        return $this->responseFactory->createApiResponse($normalizedResponse, $responseClass);
    }
}
