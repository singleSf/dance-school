<?php
declare(strict_types=1);

namespace module\api\mapper\SchoolMapper\RoleMapper;

use module\api\entity\SchoolEntity;
use module\api\entity\UserHasSchoolRoleEntity;
use module\api\helper\AbstractToolHelper;
use sf\phpmvc\entity\UserEntity;

trait UserTraitMapper
{
    /**
     * @param SchoolEntity[]|SchoolEntity\DirectionEntity\SubscriptionEntity[] $_values
     */
    public function setupUsers(array $_values): void
    {
        if (empty($_values)) {
            return;
        }

        $hases        = [];
        $currentValue = current($_values);
        $valueIds     = array_keys($_values);

        if ($currentValue instanceof SchoolEntity) {
            /** @var UserHasSchoolRoleEntity[] $hases */
            $hases = $this->fetchAll(['school_id' => $valueIds]);
        } elseif ($currentValue instanceof SchoolEntity\DirectionEntity\SubscriptionEntity) {
            /** @var SchoolEntity\DirectionEntity\SubscriptionEntity\HasUserEntity[] $hases */
            $hases = $this->fetchAll(['school_direction_subscription_id' => $valueIds]);
        }

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
            $value = null;
            if ($currentValue instanceof SchoolEntity) {
                $value = $_values[$has->getSchoolId()];
            } elseif ($currentValue instanceof SchoolEntity\DirectionEntity\SubscriptionEntity) {
                $value = $_values[$has->getSchoolDirectionSubscriptionId()];
            }

            $user       = $users[$has->getUserId()];
            $schoolRole = $schoolRoles[$has->getSchoolRoleId()];

            $value->addUser($user, $schoolRole->getType());
        }
    }
}