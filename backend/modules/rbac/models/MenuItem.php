<?php

namespace backend\modules\rbac\models;

use Yii;

/**
 * This is the model class for table "menu_item".
 *
 * @property integer $menu_id
 * @property string $item_name
 */
class MenuItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'item_name'], 'required'],
            [['menu_id'], 'integer'],
            [['item_name'], 'string', 'max' => 64],
            [['menu_id', 'item_name'], 'unique', 'targetAttribute' => ['menu_id', 'item_name'], 'message' => 'The combination of Menu ID and Item Name has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'menu_id' => '所属模块',
            'item_name' => '模块名称',
        ];
    }

    /*获取menu_id
    *$item_name：数据库里item_name
    */
    public function getMenuIdByItemName($item_name){

        $result = static::find()->select('menu_id')->where(['item_name'=> $item_name])->one();

        return $result;
    }
}
