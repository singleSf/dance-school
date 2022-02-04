<?php
declare(strict_types=1);

namespace module\api\mapper;

use module\api\entity\SchoolEntity;
use module\api\helper\AbstractToolHelper;
use sf\phpmvc\mapper\AbstractMapper;

class SchoolMapper extends AbstractMapper
{
    /**
     * @param int $_userId
     * @param int $_schoolId
     *
     * @return SchoolEntity|null
     */
    public function getSchoolByAdmin(int $_userId, int $_schoolId): ?SchoolEntity
    {
        /** @var SchoolEntity[] $schools */
        $schools = $this->getSchoolListByAdmin($_userId);

        return $schools[$_schoolId] ?? null;
    }

    /**
     * @param int $_userId
     *
     * @return SchoolEntity[]
     */
    public function getSchoolListByAdmin(int $_userId): array
    {
        $schoolRoleMapper        = AbstractToolHelper::getSchoolRoleMapper();
        $schoolHallMapper        = AbstractToolHelper::getSchoolHallMapper();
        $schoolDirectionMapper   = AbstractToolHelper::getSchoolDirectionMapper();
        $userHasSchoolRoleMapper = AbstractToolHelper::getUserHasSchoolRoleMapper();

        $roleAdmin = $schoolRoleMapper->getRoleByType(SchoolEntity\RoleEntity::TYPE_ADMIN);

        $schoolIds = $userHasSchoolRoleMapper->getSchoolIds($_userId, $roleAdmin->getId());
        if (empty($schoolIds)) {
            return [];
        }

        $schools = $this->fetchAll(['id' => $schoolIds]);

        $schoolHallMapper->setupHalls($schools);
        $schoolDirectionMapper->setupDirections($schools);
        $userHasSchoolRoleMapper->setupUsers($schools);

        return $schools;
    }

    /**
     * @param SchoolEntity $_school
     */
    public function saveSchool(SchoolEntity $_school): void
    {
        $this->saveEntity($_school);
    }

    /**
     * @param SchoolEntity $_school
     */
    public function deleteSchool(SchoolEntity $_school): void
    {
        $this->deleteEntity($_school);
    }
}