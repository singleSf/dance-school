<?php
declare(strict_types=1);

namespace module\api\helper;

use module\api\mapper\SchoolMapper;
use module\api\mapper\UserHasSchoolRoleMapper;
use sf\phpmvc\mapper\AbstractDb;

abstract class AbstractToolHelper extends \sf\phpmvc\helper\AbstractToolHelper
{
    /**
     * @return SchoolMapper
     */
    static public function getSchoolMapper(): SchoolMapper
    {
        return AbstractDb::getMapper(SchoolMapper::class);
    }

    /**
     * @return SchoolMapper\RoleMapper
     */
    static public function getSchoolRoleMapper(): SchoolMapper\RoleMapper
    {
        return AbstractDb::getMapper(SchoolMapper\RoleMapper::class);
    }

    /**
     * @return SchoolMapper\HallMapper
     */
    static public function getSchoolHallMapper(): SchoolMapper\HallMapper
    {
        return AbstractDb::getMapper(SchoolMapper\HallMapper::class);
    }

    /**
     * @return SchoolMapper\DirectionMapper
     */
    static public function getSchoolDirectionMapper(): SchoolMapper\DirectionMapper
    {
        return AbstractDb::getMapper(SchoolMapper\DirectionMapper::class);
    }

    /**
     * @return SchoolMapper\DirectionMapper\SubscriptionMapper
     */
    static public function getSchoolDirectionSubscriptionMapper(): SchoolMapper\DirectionMapper\SubscriptionMapper
    {
        return AbstractDb::getMapper(SchoolMapper\DirectionMapper\SubscriptionMapper::class);
    }

    /**
     * @return SchoolMapper\DirectionMapper\SubscriptionMapper\HasUserMapper
     */
    static public function getSchoolDirectionSubscriptionHasUserMapper(): SchoolMapper\DirectionMapper\SubscriptionMapper\HasUserMapper
    {
        return AbstractDb::getMapper(SchoolMapper\DirectionMapper\SubscriptionMapper\HasUserMapper::class);
    }

    /**
     * @return UserHasSchoolRoleMapper
     */
    static public function getUserHasSchoolRoleMapper(): UserHasSchoolRoleMapper
    {
        return AbstractDb::getMapper(UserHasSchoolRoleMapper::class);
    }
}