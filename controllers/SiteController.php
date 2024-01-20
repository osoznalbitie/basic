<?php

namespace app\controllers;

use app\models\forms\LoginForm;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Редиректы с главной
     *
     * @return \yii\web\Response
     */
    public function actionIndex() {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['book/list']);
        }
        return $this->redirect(['site/login']);
    }

    /**
     * Обработка входа пользователя
     *
     * @throws \Throwable
     * @throws \yii\base\InvalidRouteException
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('book/list');
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->login()) {
            return $this->redirect('index.php?r=book/list');
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Завершение сессии
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['site/login']);
    }

}
