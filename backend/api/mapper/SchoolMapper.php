<?php
declare(strict_types=1);

namespace api\mapper;

use api\entity\SchoolEntity;
use api\helper\AbstractToolHelper;
use sf\phpmvc\mapper\AbstractMapper;
use sf\phpmvc\service\FileService;

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
        $userHasSchoolRoleMapper = AbstractToolHelper::getUserHasSchoolRoleMapper();

        $roleAdmin = $schoolRoleMapper->getRoleByType(SchoolEntity\RoleEntity::TYPE_ADMIN);

        $schoolIds = $userHasSchoolRoleMapper->getSchoolIds($_userId, $roleAdmin->getId());
        if (empty($schoolIds)) {
            return [];
        }

        $schools = $this->fetchAll(['id' => $schoolIds]);
        $this->_setupSchool($schools);

        return $schools;
    }

    /**
     * @param SchoolEntity[] $_schools
     */
    private function _setupSchool(array $_schools): void
    {
        $schoolHallMapper        = AbstractToolHelper::getSchoolHallMapper();
        $schoolDirectionMapper   = AbstractToolHelper::getSchoolDirectionMapper();
        $userHasSchoolRoleMapper = AbstractToolHelper::getUserHasSchoolRoleMapper();
        $schoolHasFileMapper     = AbstractToolHelper::getSchoolHasFileMapper();

        $schoolHallMapper->setupHalls($_schools);
        $schoolDirectionMapper->setupDirections($_schools);
        $userHasSchoolRoleMapper->setupUsers($_schools);
        $schoolHasFileMapper->setupFiles($_schools);
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
        foreach ($_school->getFiles() as $has) {
            FileService::deleteFile($has->getFile());
        }

        $this->deleteEntity($_school);
    }
}