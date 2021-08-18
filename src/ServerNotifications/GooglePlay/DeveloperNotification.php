<?php

namespace Imdhemy\Purchases\GooglePlay;

use Imdhemy\GooglePlay\DeveloperNotifications\DeveloperNotification as BaseNotification;
use Imdhemy\GooglePlay\ValueObjects\Time;

class DeveloperNotification extends BaseNotification
{

    /**
     * @var array
     */
    protected $notificationRawData;

    /**
     * DeveloperNotification constructor.
     * @param string $version
     * @param string $packageName
     * @param int $eventTimeMillis
     * @param array|null $oneTimeProductNotification
     * @param array|null $subscriptionNotification
     * @param array|null $testNotification
     */
    public function __construct(
        string $version,
        string $packageName,
        int $eventTimeMillis,
        ?array $oneTimeProductNotification = null,
        ?array $subscriptionNotification = null,
        ?array $testNotification = null
    ) {

        $this->version = $version;
        $this->packageName = $packageName;
        $this->eventTimeMillis = $eventTimeMillis;
        $this->oneTimeProductNotification = $oneTimeProductNotification;
        $this->subscriptionNotification = $subscriptionNotification;
        $this->testNotification = $testNotification;

        $this->notificationRawData = [
            "version" => $version,
            "packageName" => $packageName,
            "eventTimeMillis" => $eventTimeMillis,
            "subscriptionNotification" => $subscriptionNotification,
        ];
    }

    /**
     * @param string $data
     * @return self
     */
    public static function parse(string $data): self
    {
        $decodedData = json_decode(base64_decode($data), true);
        $params = array_values($decodedData);

        if (isset($decodedData[self::ONE_TIME_PRODUCT_NOTIFICATION])) {
            return self::oneTimeProductNotification(...$params);
        }

        if (isset($decodedData[self::SUBSCRIPTION_NOTIFICATION])) {
            return self::subscriptionNotification(...$params);
        }

        return self::testNotification(...$params);
    }

    /**
     * @param string $version
     * @param string $packageName
     * @param int $eventTimeMillis
     * @param array $oneTimeProductNotification
     * @return static
     */
    protected static function oneTimeProductNotification(
        string $version,
        string $packageName,
        int $eventTimeMillis,
        array $oneTimeProductNotification
    ): self {
        return new self($version, $packageName, $eventTimeMillis, $oneTimeProductNotification);
    }

    /**
     * @param string $version
     * @param string $packageName
     * @param int $eventTimeMillis
     * @param array $subscriptionNotification
     * @return static
     */
    protected static function subscriptionNotification(
        string $version,
        string $packageName,
        int $eventTimeMillis,
        array $subscriptionNotification
    ): self {
        return new self($version, $packageName, $eventTimeMillis, null, $subscriptionNotification);
    }

    /**
     * @param string $version
     * @param string $packageName
     * @param int $eventTimeMillis
     * @param array $testNotification
     * @return static
     */
    protected static function testNotification(
        string $version,
        string $packageName,
        int $eventTimeMillis,
        array $testNotification
    ): self {
        return new self($version, $packageName, $eventTimeMillis, null, null, $testNotification);
    }

    /**
     * @return array
     */
    public function getNotificationRawData(): array
    {
        return $this->notificationRawData;
    }

}
