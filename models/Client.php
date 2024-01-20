<?php

namespace app\models;

use yii\db\ActiveRecord;

class Client extends ActiveRecord
{
    public static function tableName()
    {
        return 'client';
    }

    /**
     * Книги на руках у пользователя
     *
     * @return Book[]|array|ActiveRecord[]
     */
    public function getBooks()
    {
        $issuedBooks = BookIssue::find()
            ->select('book_id')
            ->where(['client_id' => $this->id])
            ->andWhere(['not in', 'id', BookReturn::find()->select('book_issue_id')])
            ->asArray()
            ->column();

        return Book::find()
            ->where(['id' => $issuedBooks])
            ->all();
    }

    /**
     * Сохранение клиента
     *
     * @param $passport
     * @param $clientFullName
     * @return bool
     */
    public static function saveClient($passport, $clientFullName)
    {
        $client = new Client();
        $client->passport = $passport;
        $client->full_name = $clientFullName;
        return $client->save();
    }
}