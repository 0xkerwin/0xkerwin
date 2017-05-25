<?php
namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tag_map".
 *
 * @property integer $tag_id
 * @property integer $blog_id
 */
class TagMap extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag_map';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_id', 'blog_id'], 'required'],
            [['tag_id', 'blog_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tag_id' => 'Tag ID',
            'blog_id' => 'Blog ID',
        ];
    }

    /**
     * 增加博客与标签映射关系
     * @param integer $blog_id 博客id
     * @param array $tag_ids 多个标签id
     * @return boole
     */
    public function addMap($blog_id, $tag_ids)
    {
        if (count($tag_ids)<=1) {
            $arr=current($tag_ids);
            if(empty($arr)){
                return false;
            }
        }

        foreach ($tag_ids as $value) {
            $map[] = [$value, $blog_id];
        }

        $res = Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['tag_id', 'blog_id'], $map)->execute();

        return $res;
    }

    /**
     * 更新博客与标签映射关系，先将原先有的标签删除再增加标签
     * @param  integer $blog_id  博客id
     * @param  array $tag_ids  现标签id
     * @return boole           
     */
    public function updateMap($blog_id, $tag_ids)
    {
        $res = $this->deleteMap($blog_id);

        return $this->addMap($blog_id, $tag_ids);
    }

    /**
     * 删除博客与标签映射关系
     * @param  integer $blog_id  博客id
     * @return boole          description
     */
    public function deleteMap($blog_id)
    {
        $res = self::deleteAll(['blog_id'=>$blog_id]);

        return $res;
    }

}