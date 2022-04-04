<?php
declare(strict_types=1);

namespace api\controller;

use api\helper\AbstractToolHelper;
use sf\phpmvc\mapper\UserMapper;
use sf\phpmvc\service\AuthUserService;
use sf\phpmvc\service\FlashMessageService;

abstract class AbstractController extends \sf\phpmvc\controller\AbstractController
{
    /** @var AuthUserService */
    protected $_authUserService;

    /** @var UserMapper */
    protected $_userMapper;

    /** @var FlashMessageService */
    protected $_flashMessageService;

    /**
     * AbstractController constructor.
     */
    public function __construct()
    {
        $this->_authUserService     = AbstractToolHelper::getAuthUserService();
        $this->_userMapper          = AbstractToolHelper::getUserMapper();
        $this->_flashMessageService = AbstractToolHelper::getFlashMessageService();
    }
}