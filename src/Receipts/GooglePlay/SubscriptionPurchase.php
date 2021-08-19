<?php

namespace Imdhemy\Purchases\Receipts\GooglePlay;

use Imdhemy\GooglePlay\Subscriptions\SubscriptionPurchase as BaseSubscriptionPurchase;

class SubscriptionPurchase extends BaseSubscriptionPurchase
{

    /**
     * @var array
     */
    protected $receiptRawData;

    /**
     * @param array $responseBody
     * @return self
     */
    public static function fromResponseBody(array $responseBody): self
    {
        $object = new self();

        $attributes = array_keys(get_class_vars(self::class));
        foreach ($attributes as $attribute) {
            if (isset($responseBody[$attribute])) {
                $object->$attribute = $responseBody[$attribute];
            }
        }

        $object->receiptRawData = $responseBody;

        return $object;
    }

    /**
     * @return array
     */
    public function getReceiptRawData(): array
    {
        return $this->receiptRawData;
    }
}
