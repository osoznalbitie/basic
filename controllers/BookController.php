<?php


namespace app\controllers;


use app\models\Book;
use app\models\BookIssue;
use app\models\BookOperation;
use app\models\BookReturn;
use app\models\forms\AddBookForm;
use app\models\forms\BookIssueForm;
use app\models\forms\BookReturnForm;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class BookController extends Controller
{

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['administrator']
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(): Response
    {
        return $this->redirect('book/list');
    }
    public function actionList(): string
    {
        return $this->render('list');
    }

    /**
     * Ajax фильтрация книг
     *
     * @param string $filter
     * @param false $statusFilter
     * @return string
     */
    public function actionFilter($filter = '', $statusFilter = false): string
    {
        $statusFilter = $statusFilter == 'true';

        $query = Book::find();

        if ($filter) {
            $query->andWhere(['like', 'title', $filter]);
        }

        if ($statusFilter) {
            $query->andWhere(['status' => 1]);
        }

        $pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $query->count(),
        ]);
        $books = $query->orderBy('title')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->renderAjax('_books', [
            'books' => $books,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Добавление книги
     *
     * @return string|\yii\web\Response
     */
    public function actionAddBook()
    {
        $model = new AddBookForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (Book::saveBook($model)) {
                Yii::$app->session->setFlash('success', 'Книга успешно добавлена');
                return $this->redirect(['book/list']);
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось сохранить книгу.');
            }
        }

        return $this->render('add-book', ['model' => $model]);
    }

    /**
     * Удаление книги
     *
     * @param $bookId
     * @return string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteBook($bookId): string
    {
        Book::deleteBook($bookId);

        return $this->actionList();
    }

    /**
     * Выдача книги
     *
     * @param $bookId
     * @return string|\yii\web\Response
     * @throws \yii\base\ExitException
     */
    public function actionIssueBook($bookId)
    {
        $book = Book::getBook($bookId);
        $model = new BookIssueForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if (BookIssue::issueBook( $book, $model)) {
                Yii::$app->session->setFlash('success', 'Книга успешно выдана');
                return $this->redirect(['book/list']);
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось сохранить книгу.');
            }
        }

        return $this->render('issue-book', [
            'book' => $book,
            'model' => $model,
        ]);
    }

    /**
     * Возврат книги
     *
     * @param $bookId
     * @return string|\yii\web\Response
     */
    public function actionReturnBook($bookId)
    {
        $book = Book::getBook($bookId);
        $model = new BookReturnForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (BookReturn::returnBook($book, $model->state_id)) {
                Yii::$app->session->setFlash('success', 'Книга успешно выдана');
                return $this->redirect(['book/list']);
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось сохранить книгу.');
            }
        }

        return $this->render('return-book', [
            'book' => $book,
            'model' => $model,
        ]);
    }

    /**
     * Информация о книге и операции с ней
     *
     * @param $bookArticle
     * @return string
     */
    public function actionInfo($bookArticle)
    {
        $book = Book::findOne(['article' => $bookArticle]);
        $operations = self::getOperations($book->id);

        return $this->render('info',[
            'book' => $book,
            'operations' => $operations
        ]);
    }

    /**
     * Вывод истории операций
     *
     * @return string
     */
    public function actionOperations(): string
    {
        $operations = self::getOperations();

        $pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => count($operations),
        ]);

        $page = Yii::$app->request->get('page', 1);
        $offset = ($page - 1) * $pagination->pageSize;
        $limit = $pagination->pageSize;
        $currentPageOperations = array_slice($operations, $offset, $limit);

        return $this->render('operations', [
            'operations' => $currentPageOperations,
            'pagination' => $pagination
        ]);
    }

    /**
     * Получение всех операций
     *
     * @return array
     */
    public static function getOperations($bookId = null) {
        $operations = array();

        $bookReturns = BookReturn::find()
            ->andFilterWhere(['book_id' => $bookId])
            ->orderBy('return_date DESC')
            ->all();

        foreach ($bookReturns as $bookReturn) {
            array_push($operations,new BookOperation(
                $bookReturn->book_id,
                $bookReturn->client_id,
                $bookReturn->employee_id,
                $bookReturn->return_date,
                2,
                $bookReturn->state_id
            ));

        }

        $bookIssues = BookIssue::find()
            ->andFilterWhere(['book_id' => $bookId])
            ->orderBy('issue_date DESC')
            ->all();

        foreach ($bookIssues as $bookIssue) {
            array_push($operations,new BookOperation(
                $bookIssue->book_id,
                $bookIssue->client_id,
                $bookIssue->employee_id,
                $bookIssue->issue_date,
                1,
                null
            ));
        }

        usort($operations, function ($a, $b) {
            $dateA = $a->operationDate ? strtotime($a->operationDate) : 0;
            $dateB = $b->operationDate ? strtotime($b->operationDate) : 0;

            return $dateB - $dateA;
        });

        return $operations;
    }

}