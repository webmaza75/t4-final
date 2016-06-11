<?php

namespace App\Controllers;

use T4\Mvc\Controller;

class Index
    extends Controller
{
    protected function access($action, $params = [])
    {
        return true;
    }

    public function actionDefault()
    {
        // Публикация ресурсов
        $this->app->assets->publish('/Layouts/assets');
    }
}