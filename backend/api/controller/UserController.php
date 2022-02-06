<?php
declare(strict_types=1);

namespace api\controller;

use api\helper\AbstractToolHelper;

class UserController extends AbstractController
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->isCheckUserAuth = false;

        parent::__construct();
    }

    /**
     * @return array
     */
    public function logoutGETAction(): array
    {
        AbstractToolHelper::getAuthUserService()->unsetUser();

        return [
            'success' => true,
        ];
    }

    /**
     * @param array $_get
     * @param array $_post
     *
     * @return array
     */
    public function authPOSTAction(array $_get, array $_post): array
    {
        $user = AbstractToolHelper::getUserMapper()->getActiveUser($_post['login'], $_post['password']);

        if ($user) {
            AbstractToolHelper::getAuthUserService()->setUser($user->getId());
        } else {
            AbstractToolHelper::getFlashMessageService()->addErrorMessage('Пользователь не найден!');
        }

        return $this->getGetAction();
    }

    /**
     * @return array
     */
    public function getGETAction(): array
    {
        $user = AbstractToolHelper::getAuthUserService()->getUser();
        if ($user) {
            $user = [
                'id'    => $user->getId(),
                'login' => $user->getLogin(),
                'title' => $user->getTitle(),
            ];
        }

        return [
            'success' => true,
            'user'    => $user,
        ];
    }
}