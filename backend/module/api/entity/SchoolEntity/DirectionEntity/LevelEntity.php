<?php
declare(strict_types=1);

namespace module\api\entity\SchoolEntity\DirectionEntity;

use module\api\entity\SchoolEntity\DirectionEntity\LevelEntity\PriceEntity;
use module\api\entity\SchoolEntity\DirectionEntity\LevelEntity\TeacherEntity;
use sf\phpmvc\entity\AbstractEntity;

class LevelEntity extends AbstractEntity
{
    public const LEVEL_JUNIOR     = 1;
    public const LEVEL_MIDDLE     = 2;
    public const LEVEL_SENIOR     = 3;
    public const LEVEL_INDIVIDUAL = 4;
    public const LEVEL_FOOTWORK   = 5;

    /** @var int */
    protected $school_direction_id;

    /** @var int */
    protected $level;

    /** @var PriceEntity[] */
    private $prices = [];

    /** @var TeacherEntity[] */
    private $teachers = [];

    /**
     * @return int
     */
    public function getSchoolDirectionId(): int
    {
        return (int)$this->school_direction_id;
    }

    /**
     * @param int $_school_direction_id
     */
    public function setSchoolDirectionId(int $_school_direction_id): void
    {
        $this->school_direction_id = $_school_direction_id;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return (int)$this->level;
    }

    /**
     * @param int $_level
     */
    public function setLevel(int $_level): void
    {
        $this->level = $_level;
    }

    /**
     * @return string
     */
    public function getLevelTitle(): string
    {
        if ($this->getLevel() === self::LEVEL_JUNIOR) {
            return 'Младшая';
        }
        if ($this->getLevel() === self::LEVEL_MIDDLE) {
            return 'Средняя';
        }
        if ($this->getLevel() === self::LEVEL_SENIOR) {
            return 'Старшая';
        }
        if ($this->getLevel() === self::LEVEL_INDIVIDUAL) {
            return 'Индивидуальное занятие';
        }
        if ($this->getLevel() === self::LEVEL_FOOTWORK) {
            return 'Футворк';
        }

        return 'Неизвестно';
    }

    /**
     * @return PriceEntity[]
     */
    public function getPrices(): array
    {
        return $this->prices;
    }

    /**
     * @param PriceEntity[] $_prices
     */
    public function setPrices(array $_prices): void
    {
        $this->prices = $_prices;
    }

    /**
     * @param PriceEntity $_price
     */
    public function addPrice(PriceEntity $_price): void
    {
        $this->prices[$_price->getId()] = $_price;
    }

    /**
     * @return TeacherEntity[]
     */
    public function getTeachers(): array
    {
        return $this->teachers;
    }

    /**
     * @param TeacherEntity[] $_teachers
     */
    public function setTeachers(array $_teachers): void
    {
        $this->teachers = $_teachers;
    }

    /**
     * @param TeacherEntity $_teacher
     */
    public function addTeacher(TeacherEntity $_teacher): void
    {
        $this->teachers[$_teacher->getId()] = $_teacher;
    }
}