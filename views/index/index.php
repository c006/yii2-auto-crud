<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/18/14
 * Time: 12:13 PM
 */
use c006\activeForm\ActiveForm;
use yii\helpers\Html;

/** @var $model /c006/crud/model/Crud */
?>


<?php $form = ActiveForm::begin([
                                    'id'     => 'form-crud',
                                    'action' => (Yii::$app->urlManager->enablePrettyUrl) ? '/crud/index/process' : 'index.php?r=crud/index/process',
                                ]
);
?>

<?php /* This is optional if SubmitSpinner is installed */ ?>
<?php if (class_exists('c006\\spinner\\SubmitSpinner')) : ?>
    <?= c006\spinner\SubmitSpinner::widget(['form_id' => $form->id,]);
    ?>
<?php endif ?>
<div class="c006-title">Yii2 Auto CRUD</div>
<div class="c006-row">
    <div class="c006-info">Use whichever database connection to be queried. Default is "db". <br> This refers to
        "Yii::$app->db"
    </div>
    <?= $form->field($model, 'db_connection') ?>
</div>
<div class="c006-row">
    <div class="c006-info">Namespace path to the models directory. Default is automatically added.</div>
    <?= $form->field($model, 'models_path') ?>
</div>
<div class="c006-row">
    <div class="c006-info">Namespace path to the model search directory. Default is automatically added. This can be the
        same as the models path.
    </div>
    <?= $form->field($model, 'models_search_path') ?>
</div>
<div class="c006-row">
    <div class="c006-info">Namespace path to the controllers directory. Default is automatically added. Note, views will
        be added based on the controller path.
    </div>
    <?= $form->field($model, 'controllers_path') ?>
</div>
<div style="margin-top: 20px;">
    <div class="c006-info">Select tables</div>
    <?= $form->field($model, 'database_tables')->dropDownList(['00' => ' '] + $tables) ?>
</div>
<div style="margin-top: 20px;">
    <div class="c006-info">Tables to be processed</div>
    <?= $form->field($model, 'tables') ?>
</div>
<div class="c006-row">
    <div class="c006-info">Overwrite existing models</div>
    <?= $form->field($model, 'overwrite_models')->toggle() ?>
</div>
<div class="c006-row">
    <div class="c006-info">Comma delimited list of models to skip. Note, do NOT add .php</div>
    <?= $form->field($model, 'exclude_models') ?>
</div>
<div class="c006-row">
    <div class="c006-info">Overwrite existing controllers.</div>
    <?= $form->field($model, 'overwrite_controllers')->toggle() ?>
</div>
<div class="c006-row">
    <div class="c006-info">Comma delimited list of controllers to skip. Note, do NOT add .php</div>
    <?= $form->field($model, 'exclude_controllers') ?>
</div>
<div class="c006-row">
    <div class="c006-info">Use On/Off (toggle) instead of checkboxes.</div>
    <?= $form->field($model, 'use_toggle')->toggle() ?>
</div>
<div class="form-group">
    <div class="">
        <?= Html::submitButton('Run', ['class' => 'btn btn-primary', 'name' => 'button-submit']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>





