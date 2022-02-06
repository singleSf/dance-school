<?php
declare(strict_types=1);

namespace api\mapper\SchoolMapper;

use api\entity\SchoolEntity;
use api\entity\SchoolEntity\DirectionEntity;
use api\helper\AbstractToolHelper;
use sf\phpmvc\mapper\AbstractMapper;

class DirectionMapper extends AbstractMapper
{
    /**
     * @param SchoolEntity[] $_schools
     */
    public function setupDirections(array $_schools): void
    {
        if (empty($_schools)) {
            return;
        }
        /** @var DirectionEntity[] $directions */
        $directions = $this->fetchAll(['school_id' => array_keys($_schools)]);

        $schoolDirectionLevelMapper = AbstractToolHelper::getSchoolDirectionLevelMapper();
        $schoolDirectionLevelMapper->setupLevels($directions);

        foreach ($directions as $direction) {
            $school = $_schools[$direction->getSchoolId()];
            $school->addDirection($direction);
        }
    }
}