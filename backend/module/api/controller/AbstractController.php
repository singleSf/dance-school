<?php
declare(strict_types=1);

namespace module\api\controller;

use module\api\helper\AbstractToolHelper;
use RuntimeException;
use sf\phpmvc\service\ServerService;

abstract class AbstractController extends \sf\phpmvc\controller\AbstractController
{
    /** @var bool */
    protected $isCheckUserAuth = true;

    /**
     * AbstractController constructor.
     */
    public function __construct()
    {
        if ($this->isCheckUserAuth) {
            $user = ServerService::isConsole() ? null : AbstractToolHelper::getAuthUserService()->getUser();

            if (!$user) {
                throw new RuntimeException('Доступ только для авторизованных!');
            }
        }
    }
}