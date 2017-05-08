<?php

use yii\db\Migration;

/**
 * Handles the creation of table `blog`.
 */
class m160614_061124_create_blog_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('blog', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('blog');
    }
}
