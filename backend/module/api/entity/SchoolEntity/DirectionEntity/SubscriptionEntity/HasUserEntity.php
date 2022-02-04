<?php
declare(strict_types=1);

namespace module\api\entity\SchoolEntity\DirectionEntity\SubscriptionEntity;

use sf\phpmvc\entity\AbstractEntity;
use sf\phpmvc\entity\UserIdTraitEntity;

class HasUserEntity extends AbstractEntity
{
    use UserIdTraitEntity;

    /** @var int */
    protected $school_direction_subscription_id;

    /** @var int */
    protected $school_role_id;

    /**
     * @return int
     */
    public function getSchoolDirectionSubscriptionId(): int
    {
        return (int)$this->school_direction_subscription_id;
    }

    /**
     * @param int $_school_direction_subscription_id
     */
    public function setSchoolDirectionSubscriptionId(int $_school_direction_subscription_id): void
    {
        $this->school_direction_subscription_id = $_school_direction_subscription_id;
    }

    /**
     * @return int
     */
    public function getSchoolRoleId(): int
    {
        return (int)$this->school_role_id;
    }

    /**
     * @param int $_school_role_id
     */
    public function setSchoolRoleId(int $_school_role_id): void
    {
        $this->school_role_id = $_school_role_id;
    }
}