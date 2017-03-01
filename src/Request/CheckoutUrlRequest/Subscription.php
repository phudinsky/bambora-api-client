<?php
namespace Bambora\Request\CheckoutUrlRequest;

class Subscription
{
    const ACTION_CREATE = 'Create';

    /** @var  string */
    private $action;

    /** @var  string */
    private $description;

    /** @var  string */
    private $reference;

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     * @return static
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return static
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return static
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }
}
