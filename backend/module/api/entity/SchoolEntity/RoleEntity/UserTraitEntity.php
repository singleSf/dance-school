<?php
declare(strict_types=1);

namespace module\api\entity\SchoolEntity\RoleEntity;

use module\api\entity\SchoolEntity\RoleEntity;
use sf\phpmvc\entity\UserEntity;

trait UserTraitEntity
{
    /** @var UserEntity[][] */
    private $users = [];

    protected function setupTypesUsers(): void
    {
        foreach (RoleEntity::TYPES as $type) {
            $this->users[$type] = [];
        }
    }

    /**
     * @param UserEntity $_user
     * @param int        $_type
     */
    public function addUser(UserEntity $_user, int $_type): void
    {
        $this->users[$_type][$_user->getId()] = $_user;
    }

    /**
     * @return UserEntity[]
     */
    public function getStudents(): array
    {
        return $this->users[RoleEntity::TYPE_STUDENT];
    }

    /**
     * @return UserEntity[]
     */
    public function getTeachers(): array
    {
        return $this->users[RoleEntity::TYPE_TEACHER];
    }

    /**
     * @return UserEntity[]
     */
    public function getAdmins(): array
    {
        return $this->users[RoleEntity::TYPE_ADMIN];
    }
}