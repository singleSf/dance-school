<?php
declare(strict_types=1);

namespace api\entity;

use api\entity\SchoolEntity\RoleEntity;
use sf\phpmvc\entity\AbstractEntity;
use sf\phpmvc\entity\UserTraitEntity;

class UserHasSchoolRoleEntity extends AbstractEntity
{
    use UserTraitEntity;
    use SchoolTraitEntity;

    /** @var RoleEntity */
    private $schoolRole;

    /** @var int */
    protected $school_role_id;

    /**
     * @return RoleEntity
     */
    public function getSchoolRole(): RoleEntity
    {
        return $this->schoolRole;
    }

    /**
     * @param RoleEntity $_schoolRole
     */
    public function setSchoolRole(RoleEntity $_schoolRole): void
    {
        $this->schoolRole = $_schoolRole;
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