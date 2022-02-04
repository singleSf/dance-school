<?php
declare(strict_types=1);

namespace module\api\helper;

use module\api\mapper\School\DirectionMapper as SchoolDirectionMapper;
use module\api\mapper\School\HallMapper as SchoolHallMapper;
use module\api\mapper\School\RoleMapper as SchoolRoleMapper;
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
     * @return SchoolRoleMapper
     */
    static public function getSchoolRoleMapper(): SchoolRoleMapper
    {
        return AbstractDb::getMapper(SchoolRoleMapper::class);
    }

    /**
     * @return SchoolHallMapper
     */
    static public function getSchoolHallMapper(): SchoolHallMapper
    {
        return AbstractDb::getMapper(SchoolHallMapper::class);
    }

    /**
     * @return SchoolDirectionMapper
     */
    static public function getSchoolDirectionMapper(): SchoolDirectionMapper
    {
        return AbstractDb::getMapper(SchoolDirectionMapper::class);
    }

    /**
     * @return UserHasSchoolRoleMapper
     */
    static public function getUserHasSchoolRoleMapper(): UserHasSchoolRoleMapper
    {
        return AbstractDb::getMapper(UserHasSchoolRoleMapper::class);
    }
}