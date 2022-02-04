<?php
declare(strict_types=1);

namespace module\api\entity;

use module\api\entity\School\DirectionEntity;
use module\api\entity\School\HallEntity;
use sf\phpmvc\entity\AbstractEntity;
use sf\phpmvc\entity\TitleTraitEntity;

class SchoolEntity extends AbstractEntity
{
    use TitleTraitEntity;

    /** @var HallEntity[] */
    private $halls = [];

    /** @var DirectionEntity[] */
    private $directions = [];

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
}