<?php


namespace app\models;


use yii\db\ActiveRecord;

class Position extends ActiveRecord
{
    public static function tableName()
    {
        return 'position';
    }

    /**
     * Получить имя должности
     *
     * @param $id
     * @return mixed|null
     */
    public static function getPositionName($id)
    {
        return Position::findOne($id)->position_name;
    }

    /**
     * Получить отформатированный список названий
     *
     * @return array
     */
    public static function getPositionList()
    {
        $position = Position::find()->select(['id', 'position_name'])->asArray()->all();
        $position = array_column($position, 'position_name', 'id');

        return array_map('ucfirst', $position);
    }
}