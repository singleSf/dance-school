<?php
declare(strict_types=1);

namespace module\api\mapper\SchoolMapper\DirectionMapper\LevelMapper;

use module\api\entity\SchoolEntity\DirectionEntity\LevelEntity;
use module\api\helper\AbstractToolHelper;
use sf\phpmvc\mapper\AbstractMapper;

class PriceMapper extends AbstractMapper
{
    /**
     * @param LevelEntity[] $_levels
     */
    public function setupPrices(array $_levels): void
    {
        if (empty($_levels)) {
            return;
        }
        /** @var LevelEntity\PriceEntity[] $prices */
        $prices = $this->fetchAll(['school_direction_level_id' => array_keys($_levels)]);

        $schoolDirectionLevelPriceStudentMapper = AbstractToolHelper::getSchoolDirectionLevelPriceStudentMapper();
        $schoolDirectionLevelPriceStudentMapper->setupStudents($prices);

        foreach ($prices as $price) {
            $level = $_levels[$price->getSchoolDirectionLevelId()];
            $level->addPrice($price);
        }
    }
}