<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1465499577_createNews
    extends Migration
{

    public function up()
    {
        $this->createTable('news', [
            'title' => ['type' => 'string', 'length' => 100],
            '__category_id' => ['type' => 'link'],
            'text' => ['type' => 'text'],
            'pubday' => ['type' => 'date'],
        ]);
    }

    public function down()
    {
        $this->dropTable('news');
    }
    
}