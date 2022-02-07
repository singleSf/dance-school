<?php
declare(strict_types=1);

namespace api\controller;

use api\entity\SchoolEntity;
use api\helper\AbstractToolHelper;
use sf\phpmvc\entity\FileEntity;
use sf\phpmvc\mapper\AbstractMapper;
use sf\phpmvc\service\FileService;

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
            $list[$school->getId()] = $this->_prepareSchool($school);
        }

        return [
            'success' => true,
            'list'    => $list,
        ];
    }

    /**
     * @param SchoolEntity $_school
     *
     * @return array
     */
    private function _prepareSchool(SchoolEntity $_school): array
    {
        $subscriptions = 0;
        foreach ($_school->getDirections() as $direction) {
            foreach ($direction->getLevels() as $level) {
                foreach ($level->getPrices() as $price) {
                    $subscriptions += count($price->getStudents());
                }
            }
        }

        return [
            'id'    => $_school->getId(),
            'title' => $_school->getTitle(),
            'count' => [
                'hall'         => count($_school->getHalls()),
                'direction'    => count($_school->getDirections()),
                'participant'  => count($_school->getParticipants()),
                'teacher'      => count($_school->getTeachers()),
                'admin'        => count($_school->getAdmins()),
                'subscription' => $subscriptions,
            ],
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
                $schoolArray                 = $this->_prepareSchool($school);
                $schoolArray['files']        = [];
                $schoolArray['halls']        = [];
                $schoolArray['directions']   = [];
                $schoolArray['participants'] = [];
                $schoolArray['teachers']     = [];
                $schoolArray['admins']       = [];

                foreach ($school->getFiles() as $has) {
                    $schoolArray['files'][$has->getId()] = [
                        'id'             => $has->getId(),
                        'isLogo'         => $has->isLogo(),
                        'isSubscription' => $has->isSubscription(),
                        'file'           => [
                            'id'        => $has->getFile()->getId(),
                            'title'     => $has->getFile()->getTitle(),
                            'extension' => $has->getFile()->getExtension(),
                            'size'      => $has->getFile()->getSize(),
                            'uri'       => $has->getFile()->getUri(),
                        ],
                    ];
                }

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

                foreach ($school->getParticipants() as $student) {
                    $schoolArray['participants'][$student->getId()] = [
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

                $result['rules'] = [
                    'file' => [
                        'image' => [
                            'extensions' => FileService::EXTENSION_IMAGE,
                            'size'       => FileService::MAX_SIZE,
                        ],
                    ],
                ];
            }
        }


        return $result;
    }

    /**
     * @param array $_get
     * @param array $_post
     *
     * @param array $_files
     *
     * @return array
     */
    public function savePOSTAction(array $_get, array $_post, array $_files): array
    {
        $result = [
            'success' => true,
        ];
        $user   = AbstractToolHelper::getAuthUserService()->getUser();

        $schoolMapper            = AbstractToolHelper::getSchoolMapper();
        $schoolRoleMapper        = AbstractToolHelper::getSchoolRoleMapper();
        $userHasSchoolRoleMapper = AbstractToolHelper::getUserHasSchoolRoleMapper();
        $fileMapper              = AbstractToolHelper::getFileMapper();
        $schoolHasFileMapper     = AbstractToolHelper::getSchoolHasFileMapper();

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

            if ($existSchool) {
                if (!empty($_files['logo'])) {
                    foreach ($school->getFiles() as $has) {
                        if ($has->isLogo()) {
                            FileService::deleteFile($has->getFile());

                            $file = new FileEntity();
                            $file->setTitle(FileService::getName($_files['logo']['name']));
                            $file->setExtension(FileService::getExtension($_files['logo']['name']));
                            $file->setSize(FileService::getSize($_files['logo']['tmp_name']));
                            $fileMapper->saveFile($file);

                            $has = new SchoolEntity\HasFileEntity();
                            $has->setFileId($file->getId());
                            $has->setSchoolId($school->getId());
                            $has->setType(SchoolEntity\HasFileEntity::TYPE_LOGO);
                            $schoolHasFileMapper->saveHas($has);

                            move_uploaded_file($_files['logo']['tmp_name'], $file->getPath());

                            break;
                        }
                    }
                }
                if (!empty($_files['subscription'])) {
                    foreach ($school->getFiles() as $has) {
                        if ($has->isSubscription()) {
                            FileService::deleteFile($has->getFile());

                            $file = new FileEntity();
                            $file->setTitle(FileService::getName($_files['subscription']['name']));
                            $file->setExtension(FileService::getExtension($_files['subscription']['name']));
                            $file->setSize(FileService::getSize($_files['subscription']['tmp_name']));
                            $fileMapper->saveFile($file);

                            $has = new SchoolEntity\HasFileEntity();
                            $has->setFileId($file->getId());
                            $has->setSchoolId($school->getId());
                            $has->setType(SchoolEntity\HasFileEntity::TYPE_SUBSCRIPTION);
                            $schoolHasFileMapper->saveHas($has);

                            move_uploaded_file($_files['subscription']['tmp_name'], $file->getPath());

                            break;
                        }
                    }
                }
            } else {
                $roleAdmin = $schoolRoleMapper->getRoleByType(SchoolEntity\RoleEntity::TYPE_ADMIN);
                $userHasSchoolRoleMapper->saveUserHasSchoolRole($user->getId(), $school->getId(), $roleAdmin->getId());

                // todo SF check size && extension
                {
                    $path = ROOT_PATH.'/data/image/default/logo.png';
                    $file = new FileEntity();
                    $file->setTitle(FileService::getName($path));
                    $file->setExtension(FileService::getExtension($path));
                    $file->setSize(FileService::getSize($path));
                    $fileMapper->saveFile($file);

                    $has = new SchoolEntity\HasFileEntity();
                    $has->setFileId($file->getId());
                    $has->setSchoolId($school->getId());
                    $has->setType(SchoolEntity\HasFileEntity::TYPE_LOGO);
                    $schoolHasFileMapper->saveHas($has);

                    copy($path, $file->getPath());
                }
                {
                    $path = ROOT_PATH.'/data/image/default/subscription.png';
                    $file = new FileEntity();
                    $file->setTitle(FileService::getName($path));
                    $file->setExtension(FileService::getExtension($path));
                    $file->setSize(FileService::getSize($path));
                    $fileMapper->saveFile($file);

                    $has = new SchoolEntity\HasFileEntity();
                    $has->setFileId($file->getId());
                    $has->setSchoolId($school->getId());
                    $has->setType(SchoolEntity\HasFileEntity::TYPE_SUBSCRIPTION);
                    $schoolHasFileMapper->saveHas($has);

                    copy($path, $file->getPath());
                }
            }

            $result['school'] = [
                'id' => $school->getId(),
            ];
        } else {
            $schoolMapper->deleteSchool($school);
        }

        return $result;
    }
}