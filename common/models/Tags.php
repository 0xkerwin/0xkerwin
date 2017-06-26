<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tags".
 *
 * @property integer $id
 * @property string $name
 * @property integer $count
 * @property string $create_time
 * @property string $update_time
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['count'], 'required'],
            [['count'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '标签名字',
            'count' => '文章总数',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     *  获取所以标签
     * @return array
     */
    public function getTagsIdToName()
    {
        $res = array();
        $query = self::find()->all();
        $res['tags'] = ArrayHelper::map($query, 'id', 'name');
        $res['tags_count'] = ArrayHelper::map($query, 'id', 'count');

        return $res;
    }

    /**
     * 添加标签并返回标签id
     * @param  array $tags_arr 标记名称
     * @return string           字符串，以','隔开
     */
    public function getTagsByName($tags_arr)
    {   
        $model = new self;
        $new_tags = array();

        if (count($tags_arr)<=1) {
            $arr=current($tags_arr);
            if(empty($arr)){
                return implode(',', $tags_arr);
            }
        }

        foreach ($tags_arr as $key => $value) {
            $tags = self::find()->where(['name' => trim($value)])->asArray()->column();
            $new_tags[] = trim($value);

            if(empty($tags)){
                $model->name = trim($value);                
                if(!$model->save(false)){
                    return false;
                }
            }
        }

        $res = self::find()->select('id')->where(['name' => $new_tags])->asArray()->column();

        return implode(',', $res);
    }

    /*统计文章总数*/
    public function addCount($tags_str)
    {
        if (empty($tags_str)) {
            return $tags_str;
        }

        foreach ($tags_str as $key => $value) {
            $tag = self::findOne($value);
            if ($tag) {
                $tag->count = $tag->count + 1;
                $tag->save(false);
            }
        }

        return true;
    }

    /*文章统计递减*/
    public function subtractCount($tags_str)
    {
        if (empty($tags_str)) {
            return $tags_str;
        }

        $model = new self;
        foreach ($tags_str as $key => $value) {
            $tag = self::findOne($value);
            if ($tag) {
                if ($tag->count==0 || $tag->count-1==0) {
                    $tag->delete();
                }else{
                   $tag->count = $tag->count - 1; 
                   $tag->save(false);
                }
            }
        }

        return true;
    }

    /*根据id获取名称*/
    public static function getTagsById($tags_id)
    {
        if (empty($tags_id)) {
            return $tags_id;
        }

        $model = new self;

        $res = self::find()->select('name')->where(['id' => $tags_id])->asArray()->column();

        return implode(',', $res);
    }

    /*删除标签，更新文章数*/
    public function deleteTags($id)
    {
        $this->subtractCount($id);

        return true;
    }

    /*更新文章的总数*/
    public function updateCount($old_id, $new_id)
    {
        $subtract = array_diff($old_id, $new_id);
        $plus = array_diff($new_id, $old_id);

        $res1 = $this->addCount($plus);
        $res2 = $this->subtractCount($subtract);

        return true;
    }
}
