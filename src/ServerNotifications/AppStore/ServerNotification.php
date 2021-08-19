<?php

namespace Imdhemy\Purchases\ServerNotifications\AppStore;

use Imdhemy\AppStore\ServerNotifications\ServerNotification as BaseNotification;
use Imdhemy\AppStore\ValueObjects\Time;
use Imdhemy\Purchases\Receipts\AppStore\ReceiptResponse;

class ServerNotification extends BaseNotification
{

    /**
     * @var array
     */
    protected $notificationRawData;

    /**
     * @param array $attributes
     * @return static
     */
    public static function fromArray(array $attributes): self
    {
        $obj = new self();
        $obj->unifiedReceipt = new ReceiptResponse($attributes['unified_receipt']);
        $obj->autoRenewStatusChangeDate = isset($attributes['auto_renew_status_change_date_ms']) ? new Time(
            $attributes['auto_renew_status_change_date_ms']
        ) : null;
        $obj->environment = $attributes['environment'];
        $obj->autoRenewStatus = $attributes['auto_renew_status'] === "true";
        $obj->bvrs = $attributes['bvrs'];
        $obj->bid = $attributes['bid'];
        $obj->password = $attributes['password'];
        $obj->autoRenewProductId = $attributes['auto_renew_product_id'];
        $obj->notificationType = $attributes['notification_type'];
        $obj->notificationRawData = $attributes;

        return $obj;
    }

    /**
     * @return array
     */
    public function getNotificationRawData(): array
    {
        return $this->notificationRawData;
    }
}
