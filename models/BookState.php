<?php


namespace app\models;


use yii\db\ActiveRecord;

class BookState extends ActiveRecord
{
    public static function tableName()
    {
        return 'book_state';
    }

}