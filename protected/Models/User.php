<?php

namespace App\Models;

use T4\Orm\Model;

/**
 * Class User Модель пользователь
 * @package App\Models
 *
 * __users таблица
 * поля:
 * email string (логин)
 * password string
 * firstName string (Имя)
 * lastName string (Фамилия)
 */
class User extends Model
{
    static  public $schema = [
        'table' => '__users',
        'columns' => [
            'email' => ['type' => 'string'],
            'password' => ['type' => 'string'],
            'firstName' => ['type' => 'string', 'length' => 50],
            'lastName' => ['type' => 'string', 'length' => 50],
        ]
    ];
}