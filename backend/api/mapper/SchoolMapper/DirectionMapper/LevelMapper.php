<?php
declare(strict_types=1);

namespace api\mapper\SchoolMapper\DirectionMapper;

use api\entity\SchoolEntity\DirectionEntity;
use api\helper\AbstractToolHelper;
use sf\phpmvc\mapper\AbstractMapper;

class LevelMapper extends AbstractMapper
{
    /**
     * @param DirectionEntity[] $_directions
     */
    public function setupLevels(array $_directions): void
    {
        if (empty($_directions)) {
            return;
        }
        /** @var DirectionEntity\LevelEntity[] $levels */
        $levels = $this->fetchAll(['school_direction_id' => array_keys($_directions)]);

        $schoolDirectionLevelPriceMapper   = AbstractToolHelper::getSchoolDirectionLevelPriceMapper();
        $schoolDirectionLevelTeacherMapper = AbstractToolHelper::getSchoolDirectionLevelTeacherMapper();

        $schoolDirectionLevelPriceMapper->setupPrices($levels);
        $schoolDirectionLevelTeacherMapper->setupTeachers($levels);

        foreach ($levels as $level) {
            $direction = $_directions[$level->getSchoolDirectionId()];
            $direction->addLevel($level);
        }
    }
}