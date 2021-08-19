<?php

namespace Imdhemy\Purchases\Receipts\GooglePlay;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Imdhemy\GooglePlay\Subscriptions\Subscription as BaseSubscription;

/**
 * Class Subscription
 * @package Imdhemy\GooglePlay\Subscriptions
 */
class Subscription extends BaseSubscription
{

    /**
     * @param string|null $developerPayload
     * @return SubscriptionPurchase
     * @throws GuzzleException
     */
    public function acknowledge(?string $developerPayload = null): SubscriptionPurchase
    {
        $subscriptionPurchase = $this->get();

        if (!$subscriptionPurchase->getAcknowledgementState()->isAcknowledged()) {
            $uri = sprintf(self::URI_ACKNOWLEDGE, $this->packageName, $this->subscriptionId, $this->token);
            $options = [
                'form_params' => [
                    'developerPayload' => $developerPayload,
                ],
            ];
            $this->client->post($uri, $options);
        }

        return $subscriptionPurchase;
    }

    /**
     * @return SubscriptionPurchase
     * @throws GuzzleException
     */
    public function get(): SubscriptionPurchase
    {
        $uri = sprintf(self::URI_GET, $this->packageName, $this->subscriptionId, $this->token);
        $response = $this->client->get($uri);
        $responseBody = json_decode($response->getBody(), true);

        return SubscriptionPurchase::fromResponseBody($responseBody);
    }

}
