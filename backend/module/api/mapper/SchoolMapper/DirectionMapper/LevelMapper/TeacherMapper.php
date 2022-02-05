<?php
declare(strict_types=1);

namespace module\api\mapper\SchoolMapper\DirectionMapper\LevelMapper;

use module\api\entity\SchoolEntity\DirectionEntity\LevelEntity;
use module\api\helper\AbstractToolHelper;
use sf\phpmvc\mapper\AbstractMapper;

class TeacherMapper extends AbstractMapper
{
    /**
     * @param LevelEntity[] $_levels
     */
    public function setupTeachers(array $_levels): void
    {
        if (empty($_levels)) {
            return;
        }
        /** @var LevelEntity\TeacherEntity[] $teachers */
        $teachers = $this->fetchAll(['school_direction_level_id' => array_keys($_levels)]);

        if (empty($teachers)) {
            return;
        }

        $userIds = [];
        foreach ($teachers as $teacher) {
            $userIds[$teacher->getUserId()] = $teacher->getUserId();
        }

        $userMapper = AbstractToolHelper::getUserMapper();
        $users      = $userMapper->fetchAll(['id' => $userIds]);

        foreach ($teachers as $teacher) {
            $user = $users[$teacher->getUserId()];
            $teacher->setUser($user);

            $level = $_levels[$teacher->getSchoolDirectionLevelId()];
            $level->addTeacher($teacher);
        }
    }
}