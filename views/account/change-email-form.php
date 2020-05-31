<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$form = ActiveForm::begin([
    'id'=>'change_email_form',
]);

?>

<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'newEmail')->label('New email') ?>
<?= $form->field($model, 'confirmNewEmail')->label('Confirm new email') ?>

<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>