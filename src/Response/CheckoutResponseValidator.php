<?php
namespace Bambora\Response;

class CheckoutResponseValidator
{
    /** @var string */
    private $md5Key;

    public function __construct(string $md5Key)
    {
        $this->md5Key = $md5Key;
    }

    /**
     * @param array $params
     * @return bool
     */
    public function isValid(array $params): bool
    {
        $isProvided = $this->isAllParamsProvided($params);

        if (!$isProvided) {
            return false;
        }

        $expectedHash = $this->generateHash($params);
        $actualHash = $params['hash'];

        return $expectedHash === $actualHash;
    }

    /**
     * @param array $params
     * @return string
     */
    private function generateHash(array $params) : string
    {
        $allExceptHash = $this->withoutHash($params);

        return md5(implode(array_values($allExceptHash), "") . $this->md5Key);
    }

    /**
     * @param array $params
     * @return bool
     */
    private function isAllParamsProvided(array $params) : bool
    {
        return array_key_exists("hash", $params);
    }

    /**
     * @param array $params
     * @return array
     */
    private function withoutHash(array $params) : array
    {
        return array_diff_key($params, ["hash" => ""]);
    }
}
