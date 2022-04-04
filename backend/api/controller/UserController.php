<?php
declare(strict_types=1);

namespace api\controller;

class UserController extends AbstractController
{
    /**
     * @return array
     */
    public function logoutGETAction(): array
    {
        $this->_authUserService->unsetUser();

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
        $user = $this->_userMapper->getActiveUser($_post['login'], $_post['password']);

        if ($user) {
            $this->_authUserService->setUser($user->getId());
        } else {
            $this->_flashMessageService->addErrorMessage('Пользователь не найден!');
        }

        return $this->getGetAction();
    }

    /**
     * @return array
     */
    public function getGETAction(): array
    {
        $user = $this->_authUserService->getUser();
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