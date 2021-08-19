<?php

namespace Imdhemy\Purchases\Receipts\AppStore;

use Imdhemy\AppStore\Exceptions\InvalidReceiptException;
use Imdhemy\AppStore\Receipts\ReceiptResponse as BaseReceiptResponse;
use Imdhemy\AppStore\ValueObjects\PendingRenewal;
use Imdhemy\AppStore\ValueObjects\Receipt;
use Imdhemy\AppStore\ValueObjects\Status;
use Imdhemy\Purchases\Receipts\AppStore\ReceiptInfo;

/**
 * Class ReceiptResponse
 * @package Imdhemy\AppStore\Receipts
 */
class ReceiptResponse extends BaseReceiptResponse
{

    /**
     * ReceiptResponse constructor.
     * TODO: replace public constructor usage with a static factory method
     * @param array $attributes
     * @throws InvalidReceiptException
     */
    public function __construct(array $attributes)
    {
        if ($attributes['status'] !== 0) {
            throw InvalidReceiptException::create($attributes['status']);
        }

        $this->environment = $attributes['environment'];
        $this->latestReceipt = $attributes['latest_receipt'] ?? null;

        $this->latestReceiptInfo = [];
        foreach ($attributes['latest_receipt_info'] ?? [] as $itemAttributes) {
            $this->latestReceiptInfo[] = ReceiptInfo::fromArray($itemAttributes);
        }

        $this->receipt = isset($attributes['receipt']) ? Receipt::fromArray($attributes['receipt']) : null;
        $this->status = new Status($attributes['status']);

        $this->pendingRenewalInfo = [];
        foreach ($attributes['pending_renewal_info'] ?? [] as $item) {
            $this->pendingRenewalInfo[] = PendingRenewal::fromArray($item);
        }

        $this->isRetryable = $attributes['is-retryable'] ?? null;

    }

    /**
     * @return array|ReceiptInfo[]
     */
    public function getLatestReceiptInfo(): array
    {
        return $this->latestReceiptInfo;
    }

}
