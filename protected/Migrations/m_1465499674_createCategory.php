<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1465499674_createCategory
    extends Migration
{

    public function up()
    {
        $this->createTable('categories', [
            'title' => ['type' => 'string'],
        ], [], ['tree']);
    }

    public function down()
    {
        $this->dropTable('categories');
    }
    
}