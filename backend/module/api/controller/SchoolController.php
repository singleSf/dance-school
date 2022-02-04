<?php
declare(strict_types=1);

namespace module\api\controller;

use module\api\entity\SchoolEntity;
use module\api\helper\AbstractToolHelper;

class SchoolController extends AbstractController
{
    /**
     * @return array
     */
    public function listGETAction(): array
    {
        $user = AbstractToolHelper::getAuthUserService()->getUser();

        $schoolMapper          = AbstractToolHelper::getSchoolMapper();
        $schoolHallMapper      = AbstractToolHelper::getSchoolHallMapper();
        $schoolDirectionMapper = AbstractToolHelper::getSchoolDirectionMapper();

        $list = [];

        $schools = $schoolMapper->getSchoolListByAdmin($user->getId());
        if (!empty($schools)) {
            $schoolHallMapper->setupHalls($schools);
            $schoolDirectionMapper->setupDirections($schools);

            foreach ($schools as $school) {
                $list[$school->getId()] = [
                    'id'    => $school->getId(),
                    'title' => $school->getTitle(),
                    'count' => [
                        'hole'         => count($school->getHalls()),
                        'direction'    => count($school->getDirections()),
                        'student'      => 0,
                        'teacher'      => 0,
                        'subscription' => 0,
                    ],
                ];
            }
        }

        return [
            'success' => true,
            'list'    => $list,
        ];
    }

    /**
     * @param array $_get
     * @param array $_post
     *
     * @return array
     */
    public function getPOSTAction(array $_get, array $_post): array
    {
        $user = AbstractToolHelper::getAuthUserService()->getUser();

        $schoolMapper = AbstractToolHelper::getSchoolMapper();

        $school = null;
        if (isset($_post['id'])) {
            $school = $schoolMapper->getSchoolByAdmin($user->getId(), (int)$_post['id']);
        }


        $schoolArray = null;
        if ($school) {
            $schoolArray = [
                'id'    => $school->getId(),
                'title' => $school->getTitle(),
            ];
        }

        return [
            'success' => true,
            'school'  => $schoolArray,
        ];
    }

    /**
     * @param array $_get
     * @param array $_post
     *
     * @return array
     */
    public function savePOSTAction(array $_get, array $_post): array
    {
        $user = AbstractToolHelper::getAuthUserService()->getUser();

        $schoolMapper            = AbstractToolHelper::getSchoolMapper();
        $schoolRoleMapper        = AbstractToolHelper::getSchoolRoleMapper();
        $userHasSchoolRoleMapper = AbstractToolHelper::getUserHasSchoolRoleMapper();

        $school = null;
        if (isset($_post['school']['id'])) {
            $school = $schoolMapper->getSchoolByAdmin($user->getId(), (int)$_post['school']['id']);
        }
        if (!$school) {
            $school = new SchoolEntity();
        }

        if (empty($_post['school']['isDelete'])) {
            $school->setTitle($_post['school']['title']);

            $schoolMapper->saveSchool($school);

            $roleAdmin = $schoolRoleMapper->getRoleAdmin();
            $userHasSchoolRoleMapper->saveUserHasSchoolRole($user->getId(), $school->getId(), $roleAdmin->getId());
        } else {
            $schoolMapper->deleteSchool($school);
        }

        return [
            'success' => true,
        ];
    }
}