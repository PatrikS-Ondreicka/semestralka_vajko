<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\DB\Connection;
use App\Core\Responses\Response;
use App\Models\User;
use Exception;
use PDO;

class UserController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {

    }

    public static function addUser(User $user)
    {
        $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
        $user->save();
    }

    public static function getUsername(int $user_id): string
    {
        $user = User::getOne($user_id);
        if ($user) {
            return $user->getUsername();
        } else {
            return "";
        }
    }

    public static function getPasswordHash($username) :string
    {
        try {
            $con = Connection::connect();
            $stmt = $con->prepare("SELECT password AS PASS_HASH FROM users WHERE username = '". $username . "'");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['PASS_HASH'];
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    public static function userExists(User $user) : bool
    {
        try {
            $con = Connection::connect();
            $stmt = $con->prepare("SELECT 'X' AS USER_EXISTS FROM users WHERE username = '". $user->getUsername() . "'");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return !is_null($result['USER_EXISTS']);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }
}