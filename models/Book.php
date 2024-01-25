<?php


namespace app\models;


use app\models\forms\AddBookForm;
use Yii;
use yii\db\ActiveRecord;

/**
 * @property string title
 * @property string article
 * @property int author_id
 * @property string arrival_date
 */
class Book extends ActiveRecord
{
    public static function tableName()
    {
        return 'book';
    }

    /**
     * Сохранение книги
     *
     * @param AddBookForm $model
     * @return bool
     */
    public static function saveBook(AddBookForm $model)
    {
        $author = new Author();
        if ($model->author_id == 0) {
            $author->author_name = $model->new_author_name;

            if (!$author->save()) {
                Yii::$app->session->setFlash('error', 'Не удалось добавить автора.');
                return false;
            }
        } else {
            $author = Author::findOne($model->author_id);
        }

        $uniqueArticle = self::generateUniqueArticle($model->title, $author->id);

        $book = new self();
        $book->title = $model->title;
        $book->article = $uniqueArticle;
        $book->author_id = $author->id;
        $book->arrival_date = $model->arrival_date;
        return $book->save();
    }

    /**
     * Удаление книги с её операциями и проверка автора
     *
     * @param $bookId
     * @throws \Throwable
     * @throws \yii\base\ExitException
     * @throws \yii\db\StaleObjectException
     */
    public static function deleteBook($bookId)
    {
        $book = Book::getBook($bookId);

        $bookIssues = BookIssue::find()->where(['book_id' => $bookId])->all();
        foreach ($bookIssues as $bookIssue) {
            $bookIssue->delete();
        }

        $bookReturns = BookReturn::find()->where(['book_id' => $bookId])->all();
        foreach ($bookReturns as $bookReturn) {
            $bookReturn->delete();
        }

        $book->delete();

        $author = $book->author;
        $countBooks = Book::find()->where(['author_id' => $author->id])->count();

        if ($countBooks == 0) {
            $author->delete();
        }
    }


    /**
     * Получить автора книги
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

    /**
     * Получить последний/текущий срок возврата
     *
     * @return mixed|null
     */
    public function getDeadline()
    {
        $latestBookIssue = $this->hasMany(BookIssue::class, ['book_id' => 'id'])
        ->orderBy('return_deadline DESC')
        ->one();

        return $latestBookIssue ? $latestBookIssue->return_deadline : null;
    }

    /**
     * Получение книги по ID
     *
     * @param $bookId
     * @return Book|mixed
     * @throws \yii\base\ExitException
     */
    public static function getBook($bookId) {
        $book = Book::findOne($bookId);

        if (!$book) {
            Yii::$app->session->setFlash('error', 'Книга не найдена.');
            Yii::$app->response->redirect(['book/list'])->send();
            Yii::$app->end();
        }
        return $book;
    }

    /**
     * Метод генерации артикула
     *
     * @param $title
     * @param $author_id
     * @return false|string
     */
    private static function generateUniqueArticle($title, $author_id)
    {
        $uniqueArticle = sha1($title . $author_id);
        $uniqueArticle = substr($uniqueArticle, 0, 30);
        while (Book::find()->where(['article' => $uniqueArticle])->exists()) {
            if (strlen($uniqueArticle) > 30)
                $uniqueArticle = substr($uniqueArticle,0,25);
            $uniqueArticle = substr($uniqueArticle . uniqid(), 0, 30);
        }
        return $uniqueArticle;
    }
}