<?php

namespace Bambora;

use Bambora\Exception\BamboraRequestException;
use Bambora\Request\BaseRequest;
use Bambora\Response\BaseResponse;

interface RequestMiddlewareInterface
{
    /**
     * @param BaseRequest $request
     * @param array $normalizedRequest
     */
    public function onRequest(BaseRequest $request, array $normalizedRequest);

    /**
     * @param BaseRequest $request
     * @param BamboraRequestException $exception
     */
    public function onException(BaseRequest $request, BamboraRequestException $exception);

    /**
     * @param BaseResponse $response
     * @param array $normalizedResponse
     */
    public function onResponse(BaseResponse $response, array $normalizedResponse);
}
