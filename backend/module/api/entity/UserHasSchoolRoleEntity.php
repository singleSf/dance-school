<?php
declare(strict_types=1);

namespace module\api\entity;

use sf\phpmvc\entity\AbstractEntity;
use sf\phpmvc\entity\UserIdTraitEntity;

class UserHasSchoolRoleEntity extends AbstractEntity
{
    use UserIdTraitEntity;
    use SchoolTraitEntity;

    /** @var int */
    protected $school_role_id;

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