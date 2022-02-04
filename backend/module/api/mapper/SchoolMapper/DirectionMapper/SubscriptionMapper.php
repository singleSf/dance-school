<?php
declare(strict_types=1);

namespace module\api\mapper\SchoolMapper\DirectionMapper;

use module\api\entity\SchoolEntity\DirectionEntity;
use module\api\helper\AbstractToolHelper;
use sf\phpmvc\mapper\AbstractMapper;

class SubscriptionMapper extends AbstractMapper
{
    /**
     * @param DirectionEntity[] $_directions
     */
    public function setupSubscriptions(array $_directions): void
    {
        /** @var DirectionEntity\SubscriptionEntity[] $subscriptions */
        $subscriptions = $this->fetchAll(['school_direction_id' => array_keys($_directions)]);

        $schoolDirectionSubscriptionHasUserMapper = AbstractToolHelper::getSchoolDirectionSubscriptionHasUserMapper();
        $schoolDirectionSubscriptionHasUserMapper->setupUsers($subscriptions);

        foreach ($subscriptions as $subscription) {
            $direction = $_directions[$subscription->getSchoolDirectionId()];
            $direction->addSubscriptions($subscription);
        }
    }
}