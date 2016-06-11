<?php

namespace App\Controllers;

use App\Components\Auth\Identity;
use App\Components\Auth\MultiException;
use T4\Mvc\Controller;

/**
 * Class User Пользователь
 * @package App\Controllers
 */
class User extends Controller
{
    /**
     * Авторизация
     * @param null $login array
     */
    public function actionLogin($login = null)
    {
        if (null !== $login) {
            try {
                $auth = new Identity();
                $auth->login($login);
                // Редирект администратора в админ-панель
                if ('admin@t4.final' == $login['email']) {
                    $this->redirect('/admin/category');
                } else { // обычного пользователя - на главную
                    $this->redirect('/');
                }
            } catch (MultiException $e) {
                $this->data->errors = $e;
            }
        }
    }

    public function actionLogout()
    {
        $auth = new Identity();
        $auth->logout();
        $this->redirect('/');
    }

    /**
     * Регистрация пользователя
     * @param null $register array
     */
    public function actionRegister($register = null)
    {
        if (null !== $register) {
            try {
                $auth = new Identity();
                $auth->register($register);
                $this->redirect('/');
            } catch (MultiException $e) {
                $this->data->errors = $e;
                $this->data->register = $register;
            }
        }
    }
}