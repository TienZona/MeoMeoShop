<?php

namespace App;

use App\Models\Account;

class SessionGuard
{
    protected static $user;

    public static function login(Account $account, array $credentials)
    {
        $verified = md5($credentials['password']) == $account->password;
        if ($verified) {
            $_SESSION['user_id'] = $account->id_user;
            // $_SESSION['user_avatar'] = $user->avatar;
            $_SESSION['user_name'] = $account->username;
            $_SESSION['rule'] = $account->rule;
        }
        return $verified;
    }

    public static function user()
    {
        if (! static::$user && static::isUserLoggedIn()) {
            static::$user = User::find($_SESSION['user_id']);
        }
        return static::$user;
    }

    public static function logout()
    {
        static::$user = null;
        session_unset();
        session_destroy();
    }

    public static function isUserLoggedIn()
    {
        return isset($_SESSION['user_id']);    
    }

    public static function isAdminLoggedIn()
    {
        return isset($_SESSION['rule']) && $_SESSION['rule'] == 'admin'; 
    }
}
