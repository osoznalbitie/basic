<?php


namespace app\models;


use app\models\forms\addEmployeeForm;
use app\models\forms\EditEmployeeForm;
use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 *
 * @property-read null $authKey
 * @property-read mixed $id
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @var mixed|null
     */

    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['full_name', 'position_id', 'username', 'password_hash'], 'required'],
            [['position_id'], 'integer'],
            [['full_name', 'username'], 'string', 'max' => 255],
        ];
    }

    /**
     * Добавление сотрудника
     * @param AddEmployeeForm $model
     * @return bool
     * @throws \yii\base\Exception
     */
    public static function saveEmployee(AddEmployeeForm $model)
    {
        $user = new self();
        $user->username = $model->username;
        $user->position_id = $model->position_id;
        $user->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
        $user->full_name = $model->full_name;

        return $user->save();
    }

    /**
     * Обновление сотрудника
     *
     * @param EditEmployeeForm $model
     * @param User $employee
     * @return bool
     * @throws \yii\base\Exception
     */
    public static function updateEmployee(EditEmployeeForm $model, User $employee)
    {
        $employee->full_name = $model->full_name;
        $employee->position_id = $model->position_id;

        if (!empty($model->new_password)) {
            $employee->password_hash = Yii::$app->security->generatePasswordHash($model->new_password);
        }

        return $employee->save();
    }

    /**
     * Установка роли пользователю
     *
     * @throws \Exception
     */
    public static function setRole($user) {
        $userRole = Position::find()->where(['id' => $user->position_id])->one()->position_name;
        Yii::$app->authManager->revokeAll($user->getId());

        $userRole = Yii::$app->authManager->getRole($userRole);

        Yii::$app->authManager->assign($userRole, $user->getId());
    }


    public function getId()
    {
        return $this->id;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null; // Not implemented for simplicity
    }

    public function getAuthKey()
    {
        return null; // Not implemented for simplicity
    }

    public function validateAuthKey($authKey)
    {
        return null; // Not implemented for simplicity
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

}