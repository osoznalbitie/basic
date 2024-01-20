<?php

use app\models\Author;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\forms\AddBookForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Название') ?>

    <?php
    $authors = Author::find()->select(['id', 'author_name'])->asArray()->all();
    $options = ArrayHelper::merge([
        '0' => 'Добавить автора',
    ], ArrayHelper::map($authors, 'id', 'author_name'));
    ?>
    <?=$form->field($model, 'author_id')->dropDownList($options, [
    'prompt' => 'Выберите автора',
    'onchange' => 'if ($(this).val() === "0") {
    $("#new-author").show();
    } else {
    console.log($(this).val());
    $("#new-author").hide();
    }'
    ])
    ?>

    <div id="new-author" style="display: none;">
        <?= $form->field($model, 'new_author_name')->textInput(['maxlength' => true])?>
    </div>

    <?= $form->field($model, 'arrival_date')->textInput(['type' => 'date', 'format' => 'Y-m-d']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
