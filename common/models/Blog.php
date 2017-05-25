<?php

namespace common\models;

use Yii;
use backend\modules\rbac\models\UserBackend;
use common\models\Category;
use common\models\TagMap;

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
     
    public function getBuildQuery($where=[])
    {
        $data = self::find()->filterWhere($where)->orderBy('create_time desc');

        return $data;
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

    /**
     * 根据标签获取博客
     */
    public function getBlogByTag()
    {
        return $this->hasMany(TagMap::className(), ['blog_id' => 'id']);
    }

    public function getOneBlog($id)
    {
        $res = self::find()
            ->where(['id' => $id])
            ->with('author')
            ->one();

        return $res;
    }
}
