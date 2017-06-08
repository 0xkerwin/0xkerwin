<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadFile;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $count
 * @property string $create_time
 * @property string $update_time
 */
class Category extends \yii\db\ActiveRecord
{
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['count'], 'integer'],
            [['name'], 'unique'],
            [['create_time', 'update_time'], 'safe'],
            [['image_url'], 'string', 'max' => 256],
            [['file'], 'file'],
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
            'name' => '分类名称',
            'count' => '文章总数',
            'image_url' => '图片',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    public static function getIdName()
    {
        $data = self::find()->asArray()->all();
        $res = ArrayHelper::map($data, 'id', 'name');

        return $res;
    }

    /*统计文章总数*/
    public function addCount($id)
    {
        if (!$id) {
            return $id;
        }

        $category = self::findOne($id);
        $category->count = $category->count + 1;

        if($category->save(false)){
            return true;
        }else {
            return false;
        }
    }

    /*删除一篇相关文章减1*/
    public function subtractCount($id)
    {
        if (!$id) {
            return $id;
        }

        $category = self::findOne($id);

        if ($category->count!=0) {
            $category->count = $category->count - 1;
        }        

        if($category->save(false)){
            return true;
        }else {
            return false;
        }
    }

    /*更新文章的总数*/
    public function updateCount($old_id, $new_id)
    {
        if ($old_id != $new_id) {
            $this->addCount($new_id);
            $this->subtractCount($old_id);
        }

        return true;
    }

    public static function getOneCategory($id)
    {
        $res = self::findOne($id);
        
        return $res->name;
    }
}
