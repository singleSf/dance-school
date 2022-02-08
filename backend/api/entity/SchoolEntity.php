<?php
declare(strict_types=1);

namespace api\entity;

use api\entity\SchoolEntity\DirectionEntity;
use api\entity\SchoolEntity\HallEntity;
use api\entity\SchoolEntity\HasFileEntity;
use api\entity\SchoolEntity\RoleEntity;
use sf\phpmvc\entity\AbstractEntity;
use sf\phpmvc\entity\TitleTraitEntity;

class SchoolEntity extends AbstractEntity
{
    use TitleTraitEntity;

    /** @var HallEntity[] */
    private $halls = [];

    /** @var DirectionEntity[] */
    private $directions = [];

    /** @var UserHasSchoolRoleEntity[] */
    private $users = [];

    /** @var HasFileEntity[] */
    private $files = [];

    /**
     * @return HallEntity[]
     */
    public function getHalls(): array
    {
        return $this->halls;
    }

    /**
     * @param HallEntity $_hall
     */
    public function addHall(HallEntity $_hall): void
    {
        $this->halls[$_hall->getId()] = $_hall;
    }

    /**
     * @return DirectionEntity[]
     */
    public function getDirections(): array
    {
        return $this->directions;
    }

    /**
     * @param DirectionEntity $_direction
     */
    public function addDirection(DirectionEntity $_direction): void
    {
        $this->directions[$_direction->getId()] = $_direction;
    }

    /**
     * @param UserHasSchoolRoleEntity $_user
     */
    public function addUser(UserHasSchoolRoleEntity $_user): void
    {
        $this->users[$_user->getId()] = $_user;
    }

    /**
     * @return UserHasSchoolRoleEntity[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    /**
     * @param HasFileEntity $_file
     */
    public function addFile(HasFileEntity $_file): void
    {
        $this->files[$_file->getId()] = $_file;
    }

    /**
     * @return HasFileEntity[]
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @return UserHasSchoolRoleEntity[]
     */
    public function getStudents(): array
    {
        return $this->_getUsers(RoleEntity::TYPE_STUDENT);
    }

    /**
     * @return UserHasSchoolRoleEntity[]
     */
    public function getTeachers(): array
    {
        return $this->_getUsers(RoleEntity::TYPE_TEACHER);
    }

    /**
     * @return UserHasSchoolRoleEntity[]
     */
    public function getAdmins(): array
    {
        return $this->_getUsers(RoleEntity::TYPE_ADMIN);
    }

    /**
     * @param int $_type
     *
     * @return UserHasSchoolRoleEntity[]
     */
    private function _getUsers(int $_type): array
    {
        return array_filter(
            $this->users,
            function (UserHasSchoolRoleEntity $_user) use ($_type): bool {
                return $_user->getSchoolRole()->getType() === $_type;
            }
        );
    }
}