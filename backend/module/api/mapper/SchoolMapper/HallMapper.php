<?php
declare(strict_types=1);

namespace module\api\mapper\SchoolMapper;

use module\api\entity\SchoolEntity;
use module\api\entity\SchoolEntity\HallEntity;
use sf\phpmvc\mapper\AbstractMapper;

class HallMapper extends AbstractMapper
{
    /**
     * @param SchoolEntity[] $_schools
     */
    public function setupHalls(array $_schools): void
    {
        if (empty($_schools)) {
            return;
        }
        /** @var HallEntity[] $halls */
        $halls = $this->fetchAll(['school_id' => array_keys($_schools)]);

        foreach ($halls as $hall) {
            $school = $_schools[$hall->getSchoolId()];
            $school->addHall($hall);
        }
    }
}