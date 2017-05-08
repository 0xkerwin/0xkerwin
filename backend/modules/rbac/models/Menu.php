<?php

namespace backend\modules\rbac\models;

use Yii;
use backend\modules\rbac\models\Item;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent
 * @property string $route
 * @property integer $order
 * @property string $data
 *
 * @property Menu $parent0
 * @property Menu[] $menus
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent', 'order'], 'integer'],
            [['data'], 'string'],
            [['name'], 'string', 'max' => 128],
            [['name'], 'unique'],
            [['route'], 'string', 'max' => 256],
            ['route', 'default', 'value' => null],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['parent' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '菜单ID',
            'name' => '菜单名称',
            'parent' => '菜单父级',
            'route' => '路由',
            'order' => '排序',
            'data' => '图标',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent0()
    {
        return $this->hasOne(Menu::className(), ['id' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::className(), ['parent' => 'id']);
    }

    /*获取父级*/
    public function getMenuPid(){
        $pid = static::find()
            ->select('id, name, parent')
            ->where('parent is NULL')
            ->orWhere(['parent' => 0])
            ->asArray()
            ->all();

        return $pid;
    }

    /*获取子级*/
    public function getMenuSub(){
        $pid = static::find()
            ->select('id, name, parent, name')
            ->where('parent is not NULL')
            ->orWhere('parent != 0')
            ->all();

        return $pid;
    }

    public function getItems()
    {
        return $this->hasMany(Item::className(), ['name' => 'item_name'])
            ->viaTable('menu_item',['menu_id' => 'id' ]);
    }

    public static function getBuildQuery($conditions=1, $fields='*'){
        $query = static::find()->select($fields)->where($conditions);

        return $query;
    }

    public function getMenuList()
    {
        $menu = static::find()->all();

        return $menu;
    }

    public function getMenuByParet($parent)
    {
        $menu = static::find()->where(['parent' => $parent])->all();

        return $menu;
    }
}
