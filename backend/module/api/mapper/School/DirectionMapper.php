<?php
declare(strict_types=1);

namespace module\api\mapper\School;

use module\api\entity\School\DirectionEntity;
use module\api\entity\SchoolEntity;
use sf\phpmvc\mapper\AbstractMapper;
use sf\phpmvc\mapper\action\SelectAction;

class DirectionMapper extends AbstractMapper
{
    /**
     * @param SchoolEntity[] $_schools
     */
    public function setupDirections(array $_schools): void
    {
        $select = new SelectAction($this->getTable());
        $select->getWhere()->in('school_id', array_keys($_schools));
        /** @var DirectionEntity[] $directions */
        $directions = $this->fetchAll($select);

        foreach ($directions as $direction) {
            $school = $_schools[$direction->getSchoolId()];
            $school->addDirection($direction);
        }
    }
}