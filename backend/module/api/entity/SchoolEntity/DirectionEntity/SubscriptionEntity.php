<?php
declare(strict_types=1);

namespace module\api\entity\SchoolEntity\DirectionEntity;

use module\api\entity\SchoolEntity\RoleEntity;
use sf\phpmvc\entity\AbstractEntity;

class SubscriptionEntity extends AbstractEntity
{
    use RoleEntity\UserTraitEntity;
    public const LEVEL_JUNIOR     = 1;
    public const LEVEL_MIDDLE     = 2;
    public const LEVEL_SENIOR     = 3;
    public const LEVEL_INDIVIDUAL = 4;
    public const LEVEL_FOOTWORK   = 5;

    /** @var int */
    protected $school_direction_id;

    /** @var int */
    protected $level;

    public function __construct()
    {
        $this->setupTypesUsers();
    }

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
}