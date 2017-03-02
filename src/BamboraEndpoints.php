<?php
namespace Bambora;

final class BamboraEndpoints
{
    const CHECKOUT_ENDPOINT = "https://api.v1.checkout.bambora.com";
    const TRANSACTION_ENDPOINT = "https://transaction-v1.api-eu.bambora.com";
    const SUBSCRIPTION_ENDPOINT = "https://subscription-v1.api.epay.eu";

    /**
     * @return string
     */
    public static function initiateSession() : string
    {
        return sprintf('%s/sessions', self::CHECKOUT_ENDPOINT);
    }

    /**
     * @param string $subscriptionId
     * @return string
     */
    public static function authorizeTransaction(string $subscriptionId) : string
    {
        return sprintf('%s/subscriptions/%s/authorize', self::SUBSCRIPTION_ENDPOINT, $subscriptionId);
    }

    /**
     * @param string $transactionId
     * @return string
     */
    public static function captureTransaction(string $transactionId) : string
    {
        return sprintf('%s/transactions/%s/capture', self::TRANSACTION_ENDPOINT, $transactionId);
    }

    /**
     * @param string $transactionId
     * @return string
     */
    public static function deleteTransaction(string $transactionId) : string
    {
        return sprintf('%s/transactions/%s/delete', self::TRANSACTION_ENDPOINT, $transactionId);
    }
}
