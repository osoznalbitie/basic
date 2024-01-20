<?php


namespace app\models;


use yii\db\ActiveRecord;

class Author extends ActiveRecord
{
    public static function tableName()
    {
        return 'author';
    }

    /**
     * Добавление автора
     *
     * @param $newAuthorName
     * @return bool
     */
    public static function saveAuthor($newAuthorName)
    {
        $author = new Author();
        $author->author_name = $newAuthorName;
        return $author->save();
    }
}