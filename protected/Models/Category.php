<?php

namespace App\Models;

use T4\Core\Exception;
use T4\Orm\Model;

/**
 * Class Category Модель категории новостей
 * @package App\Models
 *
 * categories таблица
 * title (string) поле
 * связь Категории->Новости (один-ко-многим)
 * используется расширение Tree (дерево)
 */
class Category extends Model
{
    static protected $schema = [
        'table' => 'categories',
        'columns' => [
            'title' => ['type' => 'string'],
        ],
        'relations' => [
            'news' => ['type' => self::HAS_MANY, 'model' => News::class],
        ],
    ];

    static protected $extensions = ['tree'];

    protected function validateTitle($val) {
        if (!preg_match('~[a-zа-я]~i', $val)) {
            yield new Exception('Некорректные символы для названия');
        }
        if (strlen($val) < 3) {
            yield new Exception('Слишком короткое название');
        }
        return true;
    }

    protected function sanitizeTitle($val) {
        return preg_replace('~\s+~', ' ', $val);
    }
}