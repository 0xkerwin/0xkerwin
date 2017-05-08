<?php

namespace common\models;

use Yii;
use backend\modules\rbac\models\UserBackend;
use common\models\Category;

/**
 * This is the model class for table "blog".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $create_time
 */
class Blog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'category'], 'required'],
            [['content'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['title'], 'string', 'max' => 100],
            ['tags', 'string', 'max' => 100],
            ['category', 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'edit_id' => '修改者ID',
            'title' => '标题',
            'content' => '内容',
            'tags' => '标签',
            'category' => '分类',
            'create_time' => '创建时间',
            'update_time' => '更新时间'
        ];
    }

    public function getBlogCount()
    {
        $count = self::find()->count();

        return $count;
    }

    /*
    * 获取博客作者信息
    */
    public function getAuthor()
    {
        return $this->hasOne(UserBackend::className(), ['id' => 'user_id']);
    }

    /*
     * 获取分类
     * */

    public function getCategoryInfo()
    {
        return $this->hasOne(Category::className(), ['id' => 'category']);
    }

    public function getOneBlog($id)
    {
        /*$query = self::find()->where(['blog.id' => $id]);
        $res = $query
            ->joinWith('author',false,'INNER JOIN')
            ->one();*/
        /*SELECT `blog`.* FROM `blog` INNER JOIN `user_backend` ON `blog`.`user_id` = `user_backend`.`id` WHERE `blog`.`id`='5'*/

        $res = self::find()
            ->where(['id' => $id])
            ->with('author')
            ->one();
        /*SELECT * FROM `blog` WHERE ``.`id`='5'*/

        return $res;
    }
}
