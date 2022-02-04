<?php
declare(strict_types=1);

namespace module\api\mapper\SchoolMapper\DirectionMapper\SubscriptionMapper;

use module\api\entity\SchoolEntity;
use module\api\entity\SchoolEntity\DirectionEntity;
use module\api\helper\AbstractToolHelper;
use sf\phpmvc\entity\UserEntity;
use sf\phpmvc\mapper\AbstractMapper;

class HasUserMapper extends AbstractMapper
{
    /**
     * @param DirectionEntity\SubscriptionEntity[] $_subscriptions
     */
    public function setupUsers(array $_subscriptions): void
    {
        /** @var DirectionEntity\SubscriptionEntity\HasUserEntity[] $hases */
        $hases = $this->fetchAll(['school_direction_subscription_id' => array_keys($_subscriptions)]);

        if (empty($hases)) {
            return;
        }
        $userMapper       = AbstractToolHelper::getUserMapper();
        $schoolRoleMapper = AbstractToolHelper::getSchoolRoleMapper();

        $userIds       = [];
        $schoolRoleIds = [];
        foreach ($hases as $has) {
            $userIds[$has->getUserId()]             = $has->getUserId();
            $schoolRoleIds[$has->getSchoolRoleId()] = $has->getSchoolRoleId();
        }

        /** @var UserEntity[] $users */
        $users = $userMapper->fetchAll(['id' => $userIds]);
        /** @var SchoolEntity\RoleEntity[] $schoolRoles */
        $schoolRoles = $schoolRoleMapper->fetchAll(['id' => $schoolRoleIds]);

        foreach ($hases as $has) {
            $subscription = $_subscriptions[$has->getSchoolDirectionSubscriptionId()];
            $user         = $users[$has->getUserId()];
            $schoolRole   = $schoolRoles[$has->getSchoolRoleId()];

            $subscription->addUser($user, $schoolRole->getType());
        }
    }
}