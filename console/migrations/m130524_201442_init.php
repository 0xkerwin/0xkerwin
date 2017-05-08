<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('blog', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull()->defaultValue(''),
            'content' => $this->text(),
            'create_time' => $this->datetime(),
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
