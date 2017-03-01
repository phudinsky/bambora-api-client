<?php
namespace Bambora\Response\Api;

use Bambora\Response\BaseResponse;
use Bambora\Response\ResponseMetaInfo;
use Symfony\Component\Validator\Constraints as Assert;

abstract class BaseApiResponse extends BaseResponse
{
    /**
     * @var ResponseMetaInfo
     */
    private $meta;

    public function __construct(ResponseMetaInfo $meta, array $data)
    {
        parent::__construct($data);
        $this->meta = $meta;
    }

    /**
     * @return ResponseMetaInfo
     */
    public function getMeta() : ResponseMetaInfo
    {
        return $this->meta;
    }
}
