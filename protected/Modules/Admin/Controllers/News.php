<?php

namespace App\Modules\Admin\Controllers;

use T4\Mvc\Controller;
use T4\Core\MultiException;
use App\Models\Category as MCategory;
use App\Models\News as MNews;

/**
 * Class News Новости
 *
 * @package App\Modules\Admin\Controllers
 */
class News extends Controller
{
    /**
     * Проверка доступа к админ-панели в раздел Новостей
     * @param $action
     * @param array $params
     * @return bool
     */
    protected function access($action, $params = [])
    {
        return (!empty($this->app->user) && (1 == $this->app->user->__id));
    }

    public function actionDefault()
    {
        $this->data->news = MNews::findAll();
    }

    public function actionEdit($id = null, $news = null)
    {
        $this->data->cats = MCategory::findAllTree();

        if(!empty($id)) {
            $this->data->news = MNews::findByPK($id);
        }

        if(!empty($news)) {
            try {
                if (!$news['id']) {
                    $article = new MNews();
                } else {
                    $article  = MNews::findByPK($news['id']);
                }
                $article->fill($news);
                $article->save();
                $this->redirect('/admin/news');
            } catch (MultiException $e) {
                $this->data->errors = $e;
                $this->data->news = $news;
            }
        }
    }

    public function actionDelete($id)
    {
        $article = MNews::findByPK($id);
        if(!empty($article)) {
            $article->delete();
        }
        $this->redirect('/admin/news');
    }
}