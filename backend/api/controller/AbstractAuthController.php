<?php
declare(strict_types=1);

namespace api\controller;

use api\helper\AbstractToolHelper;
use api\mapper\SchoolMapper;
use api\mapper\UserHasSchoolRoleMapper;
use RuntimeException;
use sf\phpmvc\mapper\FileMapper;

abstract class AbstractAuthController extends AbstractController
{
    /** @var SchoolMapper */
    protected $_schoolMapper;

    /** @var SchoolMapper\RoleMapper */
    protected $_schoolRoleMapper;

    /** @var UserHasSchoolRoleMapper */
    protected $_userHasSchoolRoleMapper;

    /** @var FileMapper */
    protected $_fileMapper;

    /** @var SchoolMapper\HasFileMapper */
    protected $_schoolHasFileMapper;

    /**
     * AbstractAuthController constructor.
     */
    public function __construct()
    {
        if (!AbstractToolHelper::getAuthUserService()->isAuth()) {
            throw new RuntimeException('Доступ только для авторизованных!');
        }

        parent::__construct();

        $this->_schoolMapper            = AbstractToolHelper::getSchoolMapper();
        $this->_schoolRoleMapper        = AbstractToolHelper::getSchoolRoleMapper();
        $this->_userHasSchoolRoleMapper = AbstractToolHelper::getUserHasSchoolRoleMapper();
        $this->_fileMapper              = AbstractToolHelper::getFileMapper();
        $this->_schoolHasFileMapper     = AbstractToolHelper::getSchoolHasFileMapper();
    }
}