<?php
declare(strict_types=1);

namespace module\api\controller;

use module\api\helper\AbstractTool;

/**
 * Class UserController
 *
 * @package module\api\controller
 */
class UserController extends AbstractController
{
    /**
     * @return array
     */
    public function getGetAction(): array
    {
        $user = AbstractTool::getAuthUserService()->getUser();
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

    /**
     * @return array
     */
    public function logoutGetAction(): array
    {
        AbstractTool::getAuthUserService()->unsetUser();

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
    public function authPostAction(array $_get, array $_post): array
    {
        $user = AbstractTool::getUserMapper()->getActiveUser($_post['login'], $_post['password']);

        if ($user) {
            AbstractTool::getAuthUserService()->setUser($user->getId());
        } else {
            AbstractTool::getFlashMessageService()->addErrorMessage('Пользователь не найден!');
        }

        return $this->getGetAction();
    }
}