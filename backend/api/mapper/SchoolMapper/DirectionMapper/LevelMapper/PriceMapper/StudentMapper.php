<?php
declare(strict_types=1);

namespace api\mapper\SchoolMapper\DirectionMapper\LevelMapper\PriceMapper;

use api\entity\SchoolEntity\DirectionEntity\LevelEntity;
use api\helper\AbstractToolHelper;
use sf\phpmvc\mapper\AbstractMapper;

class StudentMapper extends AbstractMapper
{
    /**
     * @param LevelEntity\PriceEntity[] $_prices
     */
    public function setupStudents(array $_prices): void
    {
        if (empty($_prices)) {
            return;
        }
        /** @var LevelEntity\PriceEntity\StudentEntity[] $students */
        $students = $this->fetchAll(['school_direction_level_price_id' => array_keys($_prices)]);

        if (empty($students)) {
            return;
        }

        $userIds = [];
        foreach ($students as $student) {
            $userIds[$student->getUserId()] = $student->getUserId();
        }

        $userMapper = AbstractToolHelper::getUserMapper();
        $users      = $userMapper->fetchAll(['id' => $userIds]);

        foreach ($students as $student) {
            $user = $users[$student->getUserId()];
            $student->setUser($user);

            $price = $_prices[$student->getSchoolDirectionLevelPriceId()];
            $price->addStudent($student);
        }
    }
}