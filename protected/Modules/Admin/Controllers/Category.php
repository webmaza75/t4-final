<?php

namespace App\Modules\Admin\Controllers;

use T4\Mvc\Controller;
use T4\Core\MultiException;
use App\Models\Category as MCategory;

/**
 * Class Category - категории новостей
 * @package App\Modules\Admin\Controllers
 */
class Category extends Controller
{
    /**
     * Проверка доступа к админ-панели в раздел Категорий
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
        $this->data->cats = MCategory::findAllTree();
    }

    public function actionEdit($id = null, $category = null)
    {
        $this->data->cats = MCategory::findAllTree();

        if(!empty($id)) {
            $this->data->category = MCategory::findByPK($id);
        }

        if(!empty($category)) {
            try {
                if (!$category['id']) {
                    $cat1 = new MCategory();
                } else {
                    $cat1 = MCategory::findByPK($category['id']);
                }

                $cat1->fill($category);
                $cat1->save();
                $this->redirect('/admin/category');
            } catch (MultiException $e) {
                $this->data->errors = $e;
                $this->data->category = $category;
            }
        }
    }

    public function actionDelete($id)
    {
        $cat = MCategory::findByPK($id);
        if(!empty($cat)) {
            $cat->delete();
        }
        $this->redirect('/admin/category');
    }
}