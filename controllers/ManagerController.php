<?php


namespace app\controllers;


use app\models\forms\addEmployeeForm;
use app\models\forms\EditEmployeeForm;
use app\models\Position;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

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
                'class' => \yii\filters\AccessControl::class,
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
    public function actionDeleteEmployee($id): \yii\web\Response
    {
        $employee = User::findOne($id);
        if (!$employee) {
            throw new \yii\web\NotFoundHttpException('Сотрудник не найден.');
        }

        if ($employee->id === Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'Вы не можете удалить свой аккаунт.');
            return $this->redirect(['employees']);
        }

        Yii::$app->db->createCommand()->update('book_return', ['employee_id' => null], ['employee_id' => $employee->id])->execute();
        Yii::$app->db->createCommand()->update('book_issue', ['employee_id' => null], ['employee_id' => $employee->id])->execute();
        if ($employee->delete()) {
            Yii::$app->session->setFlash('success', 'Сотрудник успешно удален.');
        } else {
            Yii::$app->session->setFlash('error', 'Произошла ошибка при удалении сотрудника.');
        }

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
            throw new \yii\web\NotFoundHttpException('Сотрудник не найден.');
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