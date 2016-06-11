<?php

namespace App\Models;

use T4\Core\Exception;
use T4\Orm\Model;

/**
 * Class News Модель новостей
 * @package App\Models
 *
 * news таблица
 * поля:
 * title string (заголовок новости)
 * text text (содержимое)
 * pubday date (дата публикации)
 *
 * relations связь новостей с категориями
 */
class News extends Model
{
    static protected $schema = [
        'table' => 'news',
        'columns' => [
            'title' => ['type' => 'string'],
            'text' => ['type' => 'text'],
            'pubday' => ['type' => 'date'],
        ],

        'relations' => [
            'category' => ['type' => self::BELONGS_TO, 'model' => Category::class],
        ],
    ];

    // валидация поля title
    protected function validateTitle($val) {
        if (!preg_match('~[a-zа-я]~i', $val)) {
            yield new Exception('Некорректные символы для названия');
        }
        if (strlen($val) < 3) {
            yield new Exception('Слишком короткое название');
        }
        return true;
    }
    // санитация поля title
    protected function sanitizeTitle($val) {
        return preg_replace('~\s+~', ' ', $val);
    }
    // санитация поля pubday
    protected function sanitizePubday($val) {
        if ('' == trim($val)) {
            return null;
        }
        return $val;
    }
}
