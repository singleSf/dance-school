<?php
declare(strict_types=1);

namespace module\api\entity\SchoolEntity;

use module\api\entity\SchoolTraitEntity;
use sf\phpmvc\entity\AbstractEntity;
use sf\phpmvc\entity\TitleTraitEntity;

class DirectionEntity extends AbstractEntity
{
    use TitleTraitEntity;
    use SchoolTraitEntity;

    /** @var DirectionEntity\SubscriptionEntity[] */
    private $subscriptions = [];

    /**
     * @return DirectionEntity\SubscriptionEntity[]
     */
    public function getSubscriptions(): array
    {
        return $this->subscriptions;
    }

    /**
     * @param DirectionEntity\SubscriptionEntity[] $_subscriptions
     */
    public function setSubscriptions(array $_subscriptions): void
    {
        $this->subscriptions = $_subscriptions;
    }

    /**
     * @param DirectionEntity\SubscriptionEntity $_subscription
     */
    public function addSubscriptions(DirectionEntity\SubscriptionEntity $_subscription): void
    {
        $this->subscriptions[$_subscription->getId()] = $_subscription;
    }
}