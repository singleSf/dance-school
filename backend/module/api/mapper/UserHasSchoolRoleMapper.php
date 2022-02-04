<?php
declare(strict_types=1);

namespace module\api\mapper;

use module\api\entity\SchoolEntity;
use module\api\entity\UserHasSchoolRoleEntity;
use module\api\mapper\SchoolMapper\RoleMapper\UserTraitMapper;
use sf\phpmvc\mapper\AbstractMapper;

class UserHasSchoolRoleMapper extends AbstractMapper
{
    use UserTraitMapper;

    /**
     * @param int $_userId
     * @param int $_roleId
     *
     * @return int[]
     */
    public function getSchoolIds(int $_userId, int $_roleId): array
    {
        /** @var UserHasSchoolRoleEntity[] $hases */
        $hases = $this->fetchAll(
            [
                'user_id'        => $_userId,
                'school_role_id' => $_roleId,
            ]
        );

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
        $where = [
            'user_id'        => $_userId,
            'school_id'      => $_schoolId,
            'school_role_id' => $_roleId,
        ];

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