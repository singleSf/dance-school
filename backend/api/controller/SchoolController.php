<?php
declare(strict_types=1);

namespace api\controller;

use api\entity\SchoolEntity;
use sf\phpmvc\entity\FileEntity;
use sf\phpmvc\mapper\AbstractMapper;
use sf\phpmvc\service\ConvertService;
use sf\phpmvc\service\FileService;

class SchoolController extends AbstractAuthController
{
    private const DEFAULT_SCHOOL_IMAGES = [
        SchoolEntity\HasFileEntity::TYPE_LOGO         => ROOT_PATH.'/data/image/default/logo.png',
        SchoolEntity\HasFileEntity::TYPE_SUBSCRIPTION => ROOT_PATH.'/data/image/default/subscription.png',
    ];

    /**
     * @return array
     */
    public function listGETAction(): array
    {
        $user = $this->_authUserService->getUser();

        $schools = $this->_schoolMapper->getSchoolListByAdmin($user->getId());

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

        $user = $this->_authUserService->getUser();

        $schoolArray = null;
        if (isset($_post['id'])) {
            $school = $this->_schoolMapper->getSchoolByAdmin($user->getId(), (int)$_post['id']);

            if ($school) {
                $schoolArray               = $this->_prepareSchool($school);
                $schoolArray['files']      = [];
                $schoolArray['halls']      = [];
                $schoolArray['directions'] = [];
                $schoolArray['users']      = [];

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
                                    'userId'    => $student->getUserId(),
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
                                'id'     => $teacher->getId(),
                                'userId' => $teacher->getUserId(),
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

                $users = $this->_userMapper->getActiveUsers();
                foreach ($users as $user) {
                    $schoolArray['users'][$user->getId()] = [
                        'id'        => $user->getId(),
                        'title'     => $user->getTitle(),
                        'isStudent' => false,
                        'isTeacher' => false,
                        'isAdmin'   => false,
                    ];
                }

                foreach ($school->getUsers() as $schoolUser) {
                    if ($schoolUser->getSchoolRole()->isStudent()) {
                        $schoolArray['users'][$schoolUser->getUserId()]['isStudent'] = true;
                    } elseif ($schoolUser->getSchoolRole()->isTeacher()) {
                        $schoolArray['users'][$schoolUser->getUserId()]['isTeacher'] = true;
                    } elseif ($schoolUser->getSchoolRole()->isAdmin()) {
                        $schoolArray['users'][$schoolUser->getUserId()]['isAdmin'] = true;
                    }
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
        $user   = $this->_authUserService->getUser();

        $school = null;
        if (isset($_post['school']['id'])) {
            $school = $this->_schoolMapper->getSchoolByAdmin($user->getId(), (int)$_post['school']['id']);
        }
        if (!$school) {
            $school = new SchoolEntity();
        }

        if (empty($_post['school']['isDeleted'])) {
            $school->setTitle($_post['school']['title']);
            $existSchool = $school->hasId();

            $this->_schoolMapper->save($school);

            if ($existSchool) {
                //todo SF
                if (!empty($_files['logo'])) {
                    foreach ($school->getFiles() as $has) {
                        if ($has->isLogo()) {
                            FileService::delete($has->getFile());

                            $file = new FileEntity();
                            $file->setTitle(FileService::getName($_files['logo']['name']));
                            $file->setExtension(FileService::getExtension($_files['logo']['name']));
                            $file->setSize(FileService::getSize($_files['logo']['tmp_name']));
                            $this->_fileMapper->save($file);

                            $has = new SchoolEntity\HasFileEntity();
                            $has->setFileId($file->getId());
                            $has->setSchoolId($school->getId());
                            $has->setType(SchoolEntity\HasFileEntity::TYPE_LOGO);
                            $this->_schoolHasFileMapper->saveHas($has);

                            move_uploaded_file($_files['logo']['tmp_name'], $file->getPath());

                            break;
                        }
                    }
                }
                if (!empty($_files['subscription'])) {
                    foreach ($school->getFiles() as $has) {
                        if ($has->isSubscription()) {
                            FileService::delete($has->getFile());

                            $file = new FileEntity();
                            $file->setTitle(FileService::getName($_files['subscription']['name']));
                            $file->setExtension(FileService::getExtension($_files['subscription']['name']));
                            $file->setSize(FileService::getSize($_files['subscription']['tmp_name']));
                            $this->_fileMapper->save($file);

                            $has = new SchoolEntity\HasFileEntity();
                            $has->setFileId($file->getId());
                            $has->setSchoolId($school->getId());
                            $has->setType(SchoolEntity\HasFileEntity::TYPE_SUBSCRIPTION);
                            $this->_schoolHasFileMapper->saveHas($has);

                            move_uploaded_file($_files['subscription']['tmp_name'], $file->getPath());

                            break;
                        }
                    }
                }
            } else {
                $roleAdmin = $this->_schoolRoleMapper->getRoleByType(SchoolEntity\RoleEntity::TYPE_ADMIN);
                $this->_userHasSchoolRoleMapper->saveUserHasSchoolRole($user->getId(), $school->getId(), $roleAdmin->getId());

                foreach (self::DEFAULT_SCHOOL_IMAGES as $type => $path) {
                    if (!$this->_checkUploadFile($path, FileService::getFullName($path))) {
                        continue;
                    }
                    $file = new FileEntity();
                    $file->setTitle(FileService::getName($path));
                    $file->setExtension(FileService::getExtension($path));
                    $file->setSize(FileService::getSize($path));

                    if (FileService::save($file, $path, false)) {
                        $has = new SchoolEntity\HasFileEntity();
                        $has->setFileId($file->getId());
                        $has->setSchoolId($school->getId());
                        $has->setType($type);
                        $this->_schoolHasFileMapper->saveHas($has);
                    }
                }
            }

            $result['school'] = [
                'id' => $school->getId(),
            ];
        } else {
            $this->_schoolMapper->delete($school);
        }

        return $result;
    }

    /**
     * @param string $_path
     * @param string $_name
     *
     * @return bool
     */
    private function _checkUploadFile(string $_path, string $_name): bool
    {
        if (!FileService::isValidUploadFileImage($_path)) {
            $this->_flashMessageService->addErrorMessage('Файл `'.$_name.'` не является изображением');
        } elseif (!FileService::isValidUploadFileSize($_path)) {
            $this->_flashMessageService->addErrorMessage('Файл `'.$_name.'` больше '.ConvertService::size(FileService::MAX_SIZE));
        } else {
            return true;
        }

        return false;
    }

    /**
     * @param SchoolEntity $_school
     *
     * @return array
     */
    private function _prepareSchool(SchoolEntity $_school): array
    {
        $uniqueUserIds = [];
        foreach ($_school->getUsers() as $user) {
            $uniqueUserIds[$user->getUserId()] = $user->getUserId();
        }

        $countSubscription = 0;
        foreach ($_school->getDirections() as $direction) {
            foreach ($direction->getLevels() as $level) {
                foreach ($level->getPrices() as $price) {
                    $countSubscription += count($price->getStudents());
                }
            }
        }

        return [
            'id'    => $_school->getId(),
            'title' => $_school->getTitle(),
            'count' => [
                'hall'         => count($_school->getHalls()),
                'direction'    => count($_school->getDirections()),
                'student'      => count($_school->getStudents()),
                'teacher'      => count($_school->getTeachers()),
                'admin'        => count($_school->getAdmins()),
                'user'         => count($uniqueUserIds),
                'subscription' => $countSubscription,
            ],
        ];
    }
}