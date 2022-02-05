<?php
declare(strict_types=1);

namespace module\api\controller;

use module\api\entity\SchoolEntity;
use module\api\helper\AbstractToolHelper;
use sf\phpmvc\mapper\AbstractMapper;

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
            $subscriptions = 0;

            foreach ($school->getDirections() as $direction) {
                foreach ($direction->getLevels() as $level) {
                    foreach ($level->getPrices() as $price) {
                        $subscriptions += count($price->getStudents());
                    }
                }
            }

            $list[$school->getId()] = [
                'id'    => $school->getId(),
                'title' => $school->getTitle(),
                'count' => [
                    'hall'         => count($school->getHalls()),
                    'direction'    => count($school->getDirections()),
                    'student'      => count($school->getStudents()),
                    'teacher'      => count($school->getTeachers()),
                    'admin'        => count($school->getAdmins()),
                    'subscription' => $subscriptions,
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
        $result = [
            'success' => false,
            'school'  => [],
        ];

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
                            $students = [];
                            foreach ($price->getStudents() as $student) {
                                $students[$student->getId()] = [
                                    'id'        => $student->getId(),
                                    'dateStart' => $student->getDateStart()->format(AbstractMapper::DATE_FORMAT),
                                    'price'     => $student->getPrice(),
                                    'user'      => [
                                        'id'    => $student->getUser()->getId(),
                                        'title' => $student->getUser()->getTitle(),
                                    ],
                                ];
                            }

                            $prices[$price->getId()] = [
                                'id'          => $price->getId(),
                                'countLesson' => $price->getCountLesson(),
                                'countSkip'   => $price->getCountSkip(),
                                'price'       => $price->getPrice(),
                                'students'    => $students,
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
                            'id'      => $level->getId(),
                            'level'   => $level->getLevel(),
                            'title'   => $level->getLevelTitle(),
                            'prices'  => $prices,
                            'teaches' => $teachers,
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

                $result['success'] = true;
                $result['school']  = $schoolArray;
            }
        }


        return $result;
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
            $existSchool = $school->hasId();

            $schoolMapper->saveSchool($school);

            if (!$existSchool) {
                $roleAdmin = $schoolRoleMapper->getRoleByType(SchoolEntity\RoleEntity::TYPE_ADMIN);
                $userHasSchoolRoleMapper->saveUserHasSchoolRole($user->getId(), $school->getId(), $roleAdmin->getId());
            }
        } else {
            $schoolMapper->deleteSchool($school);
        }

        return [
            'success' => true,
        ];
    }
}