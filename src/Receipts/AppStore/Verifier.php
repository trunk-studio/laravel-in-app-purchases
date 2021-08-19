<?php

namespace Imdhemy\Purchases\Receipts\AppStore;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Imdhemy\AppStore\ClientFactory;
use Imdhemy\AppStore\Exceptions\InvalidReceiptException;
use Imdhemy\AppStore\Receipts\Verifier as BaseVerifier;
use Imdhemy\Purchases\Receipts\AppStore\ReceiptResponse;

class Verifier extends BaseVerifier
{

    /**
     * @param bool $excludeOldTransactions
     * @return ReceiptResponse
     * @throws GuzzleException|InvalidReceiptException
     */
    public function verify(bool $excludeOldTransactions = false): ReceiptResponse
    {
        $responseBody = $this->sendVerifyRequest($excludeOldTransactions);

        $status = $responseBody['status'];

        if ($this->isFromTestEnv($status)) {
            $this->client = ClientFactory::createSandbox();
            $responseBody = $this->sendVerifyRequest($excludeOldTransactions);
        }

        return new ReceiptResponse($responseBody);
    }

    /**
     * @return ReceiptResponse
     * @throws GuzzleException|InvalidReceiptException
     */
    public function verifyRenewable(): ReceiptResponse
    {
        return $this->verify(true);
    }

}
