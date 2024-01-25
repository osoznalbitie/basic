<?php


namespace app\controllers;


use app\models\forms\addEmployeeForm;
use app\models\forms\EditEmployeeForm;
use app\models\Position;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ManagerController extends Controller
{
    /**
     * @throws ForbiddenHttpException
     * @throws \yii\web\BadRequestHttpException
     * @throws \Throwable
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['manager']
                    ],
                ],
            ],
        ];
    }

    /**
     * Список сотрудников
     *
     * @return string
     */
    public function actionEmployees()
    {
        $employees = User::find()->all();

        return $this->render('employees', ['employees' => $employees]);
    }

    /**
     * Добавление сотрудника
     *
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionAddEmployee()
    {
        $model = new AddEmployeeForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (User::saveEmployee($model)) {
                $user = User::findByUsername($model->username);
                User::setRole($user);
                Yii::$app->session->setFlash('success', 'Сотрудник успешно добавлен.');
                return $this->redirect(['site/index']);
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось сохранить пользователя.');
            }
        }

        return $this->render('add-employee', [
            'model' => $model,
            'position' => Position::getPositionList(),
        ]);
    }

    /**
     * Удаление сотрудника
     *
     * @param $id
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteEmployee($id): Response
    {
        $employee = User::findOne($id);
        if (!$employee) {
            throw new NotFoundHttpException('Сотрудник не найден.');
        }

        if ($employee->id === Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'Вы не можете удалить свой аккаунт.');
            return $this->redirect(['employees']);
        }

        User::deleteUser($employee);

        return $this->redirect(['employees']);
    }

    /**
     * Редактирование сотрудника
     *
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionEditEmployee($id)
    {
        $employee = User::findOne($id);
        if (!$employee) {
            throw new NotFoundHttpException('Сотрудник не найден.');
        }

        $model = new EditEmployeeForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (User::updateEmployee($model, $employee)) {
                Yii::$app->session->setFlash('success', 'Данные сотрудника успешно обновлены.');
                return $this->redirect(['employees']);
            } else {
                Yii::$app->session->setFlash('error', 'Произошла ошибка при обновлении данных сотрудника.');
            }
        }

        return $this->render('edit-employee', [
            'model' => $model,
            'employee' => $employee,
            'positions' => Position::getPositionList(),
        ]);
    }


}