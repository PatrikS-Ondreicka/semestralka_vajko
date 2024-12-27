<?php

namespace App\Controllers;

use App\Config\Configuration;
use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Core\Responses\ViewResponse;
use App\Controllers\UserController;
use App\Models\User;
use function Sodium\add;

/**
 * Class AuthController
 * Controller for authentication actions
 * @package App\Controllers
 */
class AuthController extends AControllerBase
{
    public function index(): Response
    {
        // TODO: Implement index() method.
    }


    /**
     *
     * @return Response
     */
    public function login(): Response
    {
        return $this->html();
    }

    public function register(): Response
    {
        return $this->html();
    }

    /**
     * Login a user
     * @return Response
     */
    public function loginAction(): Response
    {
        $data = [];
        $errors = [];
        $is_error = false;

        $req = $this->request();

        $login = $req->getValue('login_text_form');
        $password = $req->getValue('login_pass_form');

        $logged = $this->app->getAuth()->login($login, $password);
        if ($logged) {
            return $this->redirect($this->url("data.data"));
        } else {
            $is_error = true;
            $errors[] = "Incorrect login or password";
            $data['error'] = $errors;
            return $this->redirect($this->url("Auth.login", $data));
        }
    }

    public function registerAction() : Response
    {
        $errors = [];
        $is_error = false;

        $req = $this->request();

        $login = $req->getValue('reg_text_form');
        $password = $req->getValue('reg_pass_form');
        $conpass = $req->getValue('reg_conpass_form');
        $user = new User();
        $user->setUsername($login);
        $user->setPassword($password);
        if ($password != $conpass) {
            $is_error = true;
            $errors[] = "Passwords don't match!";
        }

        if (UserController::userExists($user)) {
            $is_error = true;
            $errors[] = "User already exists!";
        }

        if ($is_error)
        {
            $data = (['error' => $errors]);
            return $this->redirect($this->url("auth.register", $data));
        }

        UserController::addUser($user);
        return $this->redirect($this->url("data.data"));
    }


    /**
     * Logout a user
     * @return ViewResponse
     */
    public function logout(): Response
    {
        $this->app->getAuth()->logout();
        return $this->html();
    }
}
