<?php



/* @var $this \yii\web\View */
/* @var $model \app\models\forms\EditEmployeeForm */
/* @var $employee \app\models\User */
/* @var $positions array */


use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактирование сотрудника:';
?>

<div class="edit-employee-form">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true, 'value' => $employee->full_name]) ?>

    <?= $form->field($model, 'position_id')->dropDownList($positions, ['prompt' => 'Выберите должность', 'value' => $employee->position_id]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $employee->username]) ?>

    <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>