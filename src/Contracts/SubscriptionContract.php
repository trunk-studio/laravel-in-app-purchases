<?php

namespace Imdhemy\Purchases\Contracts;

use Imdhemy\Purchases\Receipts\AppStore\ReceiptResponse;
use Imdhemy\Purchases\Receipts\GooglePlay\SubscriptionPurchase;
use Imdhemy\Purchases\ValueObjects\Time;

/**
 * Interface SubscriptionContract
 * @package Imdhemy\Purchases\Events\Contracts
 */
interface SubscriptionContract
{
    /**
     * @return Time
     */
    public function getExpiryTime(): Time;

    /**
     * @return string
     */
    public function getItemId(): string;

    /**
     * @return string
     */
    public function getProvider(): string;

    /**
     * @return string
     */
    public function getUniqueIdentifier(): string;

    /**
     * @return mixed|SubscriptionPurchase|ReceiptResponse
     */
    public function getProviderRepresentation();
}
