<?php
declare(strict_types=1);

namespace module\api\mapper;

use module\api\entity\UserHasSchoolRoleEntity;
use sf\phpmvc\mapper\AbstractMapper;
use sf\phpmvc\mapper\action\SelectAction;
use sf\phpmvc\mapper\where\Where;

class UserHasSchoolRoleMapper extends AbstractMapper
{
    /**
     * @param int $_userId
     * @param int $_roleId
     *
     * @return int[]
     */
    public function getSchoolIds(int $_userId, int $_roleId): array
    {
        $select = new SelectAction($this->getTable());
        $select->getWhere()->equalTo('user_id', $_userId);
        $select->getWhere()->equalTo('school_role_id', $_roleId);

        /** @var UserHasSchoolRoleEntity[] $hases */
        $hases = $this->fetchAll($select);

        $schoolIds = [];
        foreach ($hases as $has) {
            $schoolIds[$has->getSchoolId()] = $has->getSchoolId();
        }

        return $schoolIds;
    }

    /**
     * @param int $_userId
     * @param int $_schoolId
     * @param int $_roleId
     */
    public function saveUserHasSchoolRole(int $_userId, int $_schoolId, int $_roleId): void
    {
        $where = new Where();
        $where->equalTo('user_id', $_userId);
        $where->equalTo('school_id', $_schoolId);
        $where->equalTo('school_role_id', $_roleId);

        if ($this->findOneBy($where)) {
            return;
        }

        $has = new UserHasSchoolRoleEntity();

        $has->setUserId($_userId);
        $has->setSchoolId($_schoolId);
        $has->setSchoolRoleId($_roleId);

        $this->saveEntity($has);
    }
}