<?php
declare(strict_types=1);

namespace module\api\entity;

use module\api\entity\SchoolEntity\DirectionEntity;
use module\api\entity\SchoolEntity\HallEntity;
use module\api\entity\SchoolEntity\RoleEntity;
use sf\phpmvc\entity\AbstractEntity;
use sf\phpmvc\entity\TitleTraitEntity;
use sf\phpmvc\entity\UserEntity;

class SchoolEntity extends AbstractEntity
{
    use TitleTraitEntity;

    /** @var HallEntity[] */
    private $halls = [];

    /** @var DirectionEntity[] */
    private $directions = [];

    /** @var UserEntity[][] */
    private $users = [];

    /**
     * SchoolEntity constructor.
     */
    public function __construct()
    {
        $this->setupTypesUsers();
    }

    /**
     * @return HallEntity[]
     */
    public function getHalls(): array
    {
        return $this->halls;
    }

    /**
     * @param HallEntity[] $_halls
     */
    public function setHalls(array $_halls): void
    {
        $this->halls = $_halls;
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
     * @param DirectionEntity[] $_directions
     */
    public function setDirections(array $_directions): void
    {
        $this->directions = $_directions;
    }

    /**
     * @param DirectionEntity $_direction
     */
    public function addDirection(DirectionEntity $_direction): void
    {
        $this->directions[$_direction->getId()] = $_direction;
    }

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