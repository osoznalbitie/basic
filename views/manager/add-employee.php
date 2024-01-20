<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\addEmployeeForm */
/* @var $position array */
$this->title = 'Добавление сотрудника';
?>

<div class="site-signup">

    <h1>Добавление сотрудника</h1>

    <?php $form = ActiveForm::begin(['id' => 'signup-form']); ?>

    <?= $form->field($model, 'full_name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'position_id')->dropDownList($position)->label('Должность'); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'password_hash')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
