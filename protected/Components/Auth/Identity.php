<?php

namespace App\Components\Auth;

use App\Models\User;
use App\Models\UserSession;
use T4\Http\Helpers;

class Identity
{
    public function login($data)
    {
        $errors = new MultiException();

        if (empty($data->email)) {
            $errors->add(new Exception('Пустой email'));
        }
        if (empty($data->password)) {
            $errors->add(new Exception('Пустой пароль'));
        }
        if(!$errors->isEmpty()) {
            throw $errors;
        }
        $user = User::findByEmail($data->email);

        if(empty($user)) {
            $errors->add(new Exception('Неверно указан email'));
            throw $errors;
        }
        if(!password_verify($data->password, $user->password)) {
            $errors->add(new Exception('Неверный пароль'));
            throw $errors;
        }

        $hash = sha1(microtime() . mt_rand());
        $session = new UserSession();
        $session->hash = $hash;
        $session->user = $user;
        $session->save();

        Helpers::setCookie('t4auth', $hash, time()+10*24*60*60);
    }

    public function logout()
    {
        if (Helpers::issetCookie('t4auth')) {
            if (!empty($hash = Helpers::getCookie('t4auth'))) {
                Helpers::unsetCookie('t4auth');
                $session = UserSession::findByHash($hash);
                if (!empty($session)) {
                    $session->delete();
                }
            }
        }
    }

    public function getUser()
    {
        if (Helpers::issetCookie('t4auth')) {
            if (!empty($hash = Helpers::getCookie('t4auth'))) {
                if (!empty($session = UserSession::findByHash($hash))) {
                    return $session->user;
                }
            }
        }
        //return User::findByPK(1);
        return null;
    }

    public function register($data)
    {
        $errors = new MultiException();

        if (empty($data->email)) {
            $errors->add(new Exception('Пустой email'));
        }
        if (empty($data->password)) {
            $errors->add(new Exception('Пустой пароль'));
        }
        if (empty($data->passwordRep)) {
            $errors->add(new Exception('Введите подтверждение пароля'));
        }
        if ($data->password != $data->passwordRep) {
            $errors->add(new Exception('Пароли не совпадают'));
        }
        if (empty($data->firstName)) {
            $errors->add(new Exception('Имя не указано'));
        }
        if(!$errors->isEmpty()) {
            throw $errors;
        }

        $user = User::findByEmail($data->email);

        if(!empty($user)) {
            $errors->add(new Exception('Пользователь с таким email уже существует'));
            throw $errors;
        }
        if(!$errors->isEmpty()) {
            throw $errors;
        }

        $hash = sha1(microtime() . mt_rand());

        $user = new User();
        $user->fill($data);
        $user->password = $hash;
        $user->save();

        $session = new UserSession();
        $session->hash = $hash;
        $session->user = $user;
        $session->save();

        Helpers::setCookie('t4auth', $hash, time()+10*24*60*60);

        return $user;
    }
}