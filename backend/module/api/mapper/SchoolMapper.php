<?php
declare(strict_types=1);

namespace module\api\mapper;

use module\api\entity\SchoolEntity;
use module\api\helper\AbstractToolHelper;
use sf\phpmvc\mapper\AbstractMapper;
use sf\phpmvc\mapper\action\SelectAction;

class SchoolMapper extends AbstractMapper
{
    /**
     * @param int      $_userId
     * @param int|null $_schoolId
     *
     * @return SchoolEntity|null
     */
    public function getSchoolByAdmin(int $_userId, int $_schoolId = null): ?SchoolEntity
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
        $roleAdmin               = $schoolRoleMapper->getRoleAdmin();

        $schoolIds = $userHasSchoolRoleMapper->getSchoolIds($_userId, $roleAdmin->getId());
        if (empty($schoolIds)) {
            return [];
        }

        $select = new SelectAction($this->getTable());
        $select->getWhere()->in('id', $schoolIds);

        return $this->fetchAll($select);
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