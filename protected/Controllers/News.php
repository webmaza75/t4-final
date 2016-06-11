<?php

namespace App\Controllers;

use App\Models\Category as MCategory;
use T4\Mvc\Controller;
use App\Models\News as MNews;

/**
 * Class News класс новостей
 * @package App\Controllers
 */
class News extends Controller
{
    public function actionDefault()
    {
        $this->data->news = MNews::findAll();
    }

    public function actionOne(int $id = 0)
    {
        $this->data->article = MNews::findByPK($id);
        $this->data->category = MCategory::findByPK($this->data->article->__category_id);
    }

    public function actionLast()
    {
        $this->data->article = MNews::find(['order' => '__id DESC']);
    }
}