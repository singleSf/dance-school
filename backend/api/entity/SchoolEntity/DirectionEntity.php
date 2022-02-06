<?php
declare(strict_types=1);

namespace api\entity\SchoolEntity;

use api\entity\SchoolTraitEntity;
use sf\phpmvc\entity\AbstractEntity;
use sf\phpmvc\entity\TitleTraitEntity;

class DirectionEntity extends AbstractEntity
{
    use TitleTraitEntity;
    use SchoolTraitEntity;

    /** @var DirectionEntity\LevelEntity[] */
    private $levels = [];

    /**
     * @return DirectionEntity\LevelEntity[]
     */
    public function getLevels(): array
    {
        return $this->levels;
    }

    /**
     * @param DirectionEntity\LevelEntity[] $_levels
     */
    public function setLevels(array $_levels): void
    {
        $this->levels = $_levels;
    }

    /**
     * @param DirectionEntity\LevelEntity $_level
     */
    public function addLevel(DirectionEntity\LevelEntity $_level): void
    {
        $this->levels[$_level->getId()] = $_level;
    }
}