<?php
declare(strict_types=1);

namespace module\api\entity\SchoolEntity\DirectionEntity\LevelEntity;

use sf\phpmvc\entity\AbstractEntity;
use sf\phpmvc\entity\UserTraitEntity;

class TeacherEntity extends AbstractEntity
{
    use UserTraitEntity;

    /** @var int */
    protected $school_direction_level_id;

    /**
     * @return int
     */
    public function getSchoolDirectionLevelId(): int
    {
        return (int)$this->school_direction_level_id;
    }

    /**
     * @param int $_school_direction_level_id
     */
    public function setSchoolDirectionLevelId(int $_school_direction_level_id): void
    {
        $this->school_direction_level_id = $_school_direction_level_id;
    }
}