<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$form = ActiveForm::begin([
    'id' => 'change_password_form',
]);
?>

<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'newPassword')->passwordInput()->label('New password') ?>
<?= $form->field($model, 'confirmNewPassword')->passwordInput()->label('Confirm new password') ?>

<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>