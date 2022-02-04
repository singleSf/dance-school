<?php
declare(strict_types=1);

namespace module\api\mapper\School;

use module\api\entity\School\HallEntity;
use module\api\entity\SchoolEntity;
use sf\phpmvc\mapper\AbstractMapper;
use sf\phpmvc\mapper\action\SelectAction;

class HallMapper extends AbstractMapper
{
    /**
     * @param SchoolEntity[] $_schools
     */
    public function setupHalls(array $_schools): void
    {
        $select = new SelectAction($this->getTable());
        $select->getWhere()->in('school_id', array_keys($_schools));
        /** @var HallEntity[] $halls */
        $halls = $this->fetchAll($select);

        foreach ($halls as $hall) {
            $school = $_schools[$hall->getSchoolId()];
            $school->addHall($hall);
        }
    }
}