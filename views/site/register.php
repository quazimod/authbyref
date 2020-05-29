<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RegisterForm */
/* @var $form ActiveForm */

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="register">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Please fill out the following fields to register:</p>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true])->label('Email') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'confirmPassword')->passwordInput() ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- register -->
