<?php

namespace App\Auth;

use App\Core\IAuthenticator;
use App\Controllers\UserController;
use App\Models\User;

class LoginAuthenticator implements IAuthenticator
{

    /**
     * @inheritDoc
     */
    public function login($login, $password): bool
    {
        $user = new User();
        $user->setUsername($login);
        $user->setPassword($password);
        if (UserController::userExists($user)) {
            $pass_hash = UserController::getPasswordHash($login);
            if (password_verify($password, $pass_hash)) {
                $_SESSION['user'] = $login;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function logout(): void
    {
        if (isset($_SESSION["user"])) {
            unset($_SESSION["user"]);
            session_destroy();
        }
    }

    /**
     * @inheritDoc
     */
    public function getLoggedUserName(): string
    {
        return isset($_SESSION['user']) ? $_SESSION['user'] : throw new \Exception("User not logged in");
    }

    /**
     * @inheritDoc
     */
    public function getLoggedUserId(): mixed
    {
        return $_SESSION['user'];
    }

    /**
     * @inheritDoc
     */
    public function getLoggedUserContext(): mixed
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function isLogged(): bool
    {
        return isset($_SESSION['user']) && $_SESSION['user'] != null;
    }
}