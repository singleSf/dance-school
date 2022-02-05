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

        $schoolMapper = AbstractToolHelper::getSchoolMapper();
        $schools      = $schoolMapper->getSchoolListByAdmin($user->getId());

        $list = [];
        foreach ($schools as $school) {
            $list[$school->getId()] = [
                'id'    => $school->getId(),
                'title' => $school->getTitle(),
                'count' => [
                    'hall'      => count($school->getHalls()),
                    'direction' => count($school->getDirections()),
                    'student'   => count($school->getStudents()),
                    'teacher'   => count($school->getTeachers()),
                    'admin'     => count($school->getAdmins()),
                    'level'     => 0,
                ],
            ];
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

        $schoolArray = null;
        if (isset($_post['id'])) {
            $school = $schoolMapper->getSchoolByAdmin($user->getId(), (int)$_post['id']);

            if ($school) {
                $schoolArray = [
                    'id'         => $school->getId(),
                    'title'      => $school->getTitle(),
                    'halls'      => [],
                    'directions' => [],
                    'students'   => [],
                    'teachers'   => [],
                    'admins'     => [],
                ];

                foreach ($school->getHalls() as $hall) {
                    $schoolArray['halls'][$hall->getId()] = [
                        'id'      => $hall->getId(),
                        'title'   => $hall->getTitle(),
                        'address' => $hall->getAddress(),
                    ];
                }

                foreach ($school->getDirections() as $direction) {
                    $levels = [];
                    foreach ($direction->getLevels() as $level) {
                        $prices = [];
                        foreach ($level->getPrices() as $price) {
                            $prices[$price->getId()] = [
                                'id'           => $price->getId(),
                                'count_lesson' => $price->getCountLesson(),
                                'count_skip'   => $price->getCountSkip(),
                                'price'        => $price->getPrice(),
                            ];
                        }

                        $teachers = [];
                        foreach ($level->getTeachers() as $teacher) {
                            $teachers[$teacher->getId()] = [
                                'id'   => $teacher->getId(),
                                'user' => [
                                    'id'    => $teacher->getUser()->getId(),
                                    'title' => $teacher->getUser()->getTitle(),
                                ],
                            ];
                        }

                        $levels[$level->getId()] = [
                            'id'       => $level->getId(),
                            'level'    => $level->getLevel(),
                            'title'    => $level->getLevelTitle(),
                            'prices'   => $prices,
                            'teaches'  => $teachers,
                            'students' => [],
                        ];
                    }

                    $schoolArray['directions'][$direction->getId()] = [
                        'id'     => $direction->getId(),
                        'title'  => $direction->getTitle(),
                        'levels' => $levels,
                    ];
                }

                foreach ($school->getStudents() as $student) {
                    $schoolArray['students'][$student->getId()] = [
                        'id'    => $student->getId(),
                        'title' => $student->getTitle(),
                    ];
                }

                foreach ($school->getTeachers() as $teacher) {
                    $schoolArray['teachers'][$teacher->getId()] = [
                        'id'    => $teacher->getId(),
                        'title' => $teacher->getTitle(),
                    ];
                }

                foreach ($school->getAdmins() as $admin) {
                    $schoolArray['admins'][$admin->getId()] = [
                        'id'    => $admin->getId(),
                        'title' => $admin->getTitle(),
                    ];
                }
            }
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

        if (empty($_post['school']['isDeleted'])) {
            $school->setTitle($_post['school']['title']);

            $schoolMapper->saveSchool($school);

            $roleAdmin = $schoolRoleMapper->getRoleByType(SchoolEntity\RoleEntity::TYPE_ADMIN);
            $userHasSchoolRoleMapper->saveUserHasSchoolRole($user->getId(), $school->getId(), $roleAdmin->getId());
        } else {
            $schoolMapper->deleteSchool($school);
        }

        return [
            'success' => true,
        ];
    }
}