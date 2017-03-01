<?php
namespace Bambora\Request;

abstract class BaseRequest
{
    /** @var  RequestMetaInformation */
    protected $meta;

    /**
     * @return \Bambora\Request\RequestMetaInformation
     */
    public function getMeta() : RequestMetaInformation
    {
        return $this->meta;
    }
}
