<?php


namespace app\controllers;


use app\models\BookReturn;
use app\models\Client;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Response;

class ClientController extends Controller
{

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['administrator']
                    ],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Ajax фильтрация клиентов
     *
     * @param null $searchQuery
     * @param false $onlyWithBooks
     * @return string
     */
    public function actionFilter($searchQuery = null, $onlyWithBooks = false)
    {
        $onlyWithBooks = $onlyWithBooks == 'true';
        $query = Client::find();

        if ($searchQuery !== null) {
            $query->andFilterWhere(['like', 'full_name', $searchQuery]);
        }

        $clients = $query->all();

        if ($onlyWithBooks) {
            $clients = array_filter($clients, function ($client) {
                return count($client->getBooks()) > 0;
            });
        }

        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => count($clients),
        ]);

        $clients = array_slice($clients, $pagination->offset, $pagination->limit);

        return $this->renderAjax('_client', ['clients' => $clients, 'pagination' => $pagination]);
    }


    /**
     * Ajax проверка пароля
     *
     * @return bool[]
     */
    public function actionCheckPassport(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $passportNumber = Yii::$app->request->post('passportNumber');
        $passportNumber = str_replace(' ', '', $passportNumber);

        $client = Client::find()->where(['passport' => $passportNumber])->one();

        return ['exists' => ($client !== null)];
    }
}