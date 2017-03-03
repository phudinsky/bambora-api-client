<?php
namespace Bambora;

use Bambora\Response\BaseResponse;
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
use Bambora\Exception\BamboraRequestException;

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

    /** @var RequestMiddlewareInterface[]  */
    private $middlewares = [];

    public function __construct(string $apiKey, array $httpClientOptions = [])
    {
        $this->apiKey = $apiKey;

        $this->httpClient = $this->createHttpClient($httpClientOptions);
        $this->responseFactory = new ResponseFactory();
        $this->requestSerializer = $this->createRequestSerializer();
    }

    /**
     * @param RequestMiddlewareInterface $middleware
     */
    public function addRequestMiddleware(RequestMiddlewareInterface $middleware)
    {
        $this->middlewares[] = $middleware;
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
        $this->runOnRequest($request, $normalizedRequest);

        try {
            $rawResponse = $this->httpClient->request(
                $request->getMeta()->getHttpMethod(),
                $request->getMeta()->getUrl(),
                [
                    'json' => $normalizedRequest
                ]
            );
        } catch (RequestException $e) {
            $normalizedResponse = $e->hasResponse()
                ? $this->requestSerializer->decode($e->getResponse()->getBody()->getContents(), 'json')
                : null;
            $exception = new BamboraRequestException($e->getMessage(), $normalizedRequest, $normalizedResponse);
            $this->runOnException($request, $exception);
            throw $exception;
        }

        $normalizedResponse = $this->requestSerializer->decode($rawResponse->getBody()->getContents(), 'json');
        $response = $this->responseFactory->createApiResponse($normalizedResponse, $responseClass);
        $this->runOnResponse($response, $normalizedResponse);

        return $response;
    }

    /**
     * @param BaseRequest $request
     * @param array $normalizedRequest
     */
    private function runOnRequest(BaseRequest $request, array $normalizedRequest)
    {
        array_walk(
            $this->middlewares,
            function(RequestMiddlewareInterface $middleware) use ($request, $normalizedRequest) {
                $middleware->onRequest($request, $normalizedRequest);
            }
        );
    }

    /**
     * @param BaseRequest $request
     * @param BamboraRequestException $exception
     */
    private function runOnException(BaseRequest $request, BamboraRequestException $exception)
    {
        array_walk(
            $this->middlewares,
            function(RequestMiddlewareInterface $middleware) use ($request, $exception) {
                $middleware->onException($request, $exception);
            }
        );
    }

    /**
     * @param BaseResponse $response
     * @param array $normalizedResponse
     */
    private function runOnResponse(BaseResponse $response, array $normalizedResponse)
    {
        array_walk(
            $this->middlewares,
            function(RequestMiddlewareInterface $middleware) use ($response, $normalizedResponse) {
                $middleware->onResponse($response, $normalizedResponse);
            }
        );
    }

    /**
     * @return Serializer
     */
    private function createRequestSerializer() : Serializer
    {
        $normalizer = new PropertyNormalizer();
        $normalizer->setIgnoredAttributes(['meta']);

        return new Serializer([$normalizer], [new JsonDecode(true)]);
    }

    /**
     * @param array $httpClientOptions
     * @return HttpClient
     */
    private function createHttpClient(array $httpClientOptions) : HttpClient
    {
        return new HttpClient(
            array_merge(
                [
                    'timeout' => 30,
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => sprintf('Basic %s', $this->apiKey)
                    ]
                ],
                $httpClientOptions
            )
        );
    }
}
