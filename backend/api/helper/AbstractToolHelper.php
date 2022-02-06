<?php
declare(strict_types=1);

namespace api\helper;

use api\mapper\FileMapper;
use api\mapper\SchoolMapper;
use api\mapper\UserHasSchoolRoleMapper;
use sf\phpmvc\mapper\AbstractDb;

abstract class AbstractToolHelper extends \sf\phpmvc\helper\AbstractToolHelper
{
    /**
     * @return FileMapper
     */
    static public function getFileMapper(): FileMapper
    {
        return AbstractDb::getMapper(FileMapper::class);
    }

    /**
     * @return SchoolMapper
     */
    static public function getSchoolMapper(): SchoolMapper
    {
        return AbstractDb::getMapper(SchoolMapper::class);
    }

    /**
     * @return SchoolMapper\HasFileMapper
     */
    static public function getSchoolHasFileMapper(): SchoolMapper\HasFileMapper
    {
        return AbstractDb::getMapper(SchoolMapper\HasFileMapper::class);
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
     * @return SchoolMapper\DirectionMapper\LevelMapper
     */
    static public function getSchoolDirectionLevelMapper(): SchoolMapper\DirectionMapper\LevelMapper
    {
        return AbstractDb::getMapper(SchoolMapper\DirectionMapper\LevelMapper::class);
    }

    /**
     * @return SchoolMapper\DirectionMapper\LevelMapper\PriceMapper
     */
    static public function getSchoolDirectionLevelPriceMapper(): SchoolMapper\DirectionMapper\LevelMapper\PriceMapper
    {
        return AbstractDb::getMapper(SchoolMapper\DirectionMapper\LevelMapper\PriceMapper::class);
    }

    /**
     * @return SchoolMapper\DirectionMapper\LevelMapper\PriceMapper\StudentMapper
     */
    static public function getSchoolDirectionLevelPriceStudentMapper(): SchoolMapper\DirectionMapper\LevelMapper\PriceMapper\StudentMapper
    {
        return AbstractDb::getMapper(SchoolMapper\DirectionMapper\LevelMapper\PriceMapper\StudentMapper::class);
    }

    /**
     * @return SchoolMapper\DirectionMapper\LevelMapper\TeacherMapper
     */
    static public function getSchoolDirectionLevelTeacherMapper(): SchoolMapper\DirectionMapper\LevelMapper\TeacherMapper
    {
        return AbstractDb::getMapper(SchoolMapper\DirectionMapper\LevelMapper\TeacherMapper::class);
    }

    /**
     * @return UserHasSchoolRoleMapper
     */
    static public function getUserHasSchoolRoleMapper(): UserHasSchoolRoleMapper
    {
        return AbstractDb::getMapper(UserHasSchoolRoleMapper::class);
    }
}