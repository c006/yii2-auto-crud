<?php
    /**
     * Created by PhpStorm.
     * User: user
     * Date: 7/18/14
     * Time: 12:13 PM
     */
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /** @var $model /c006/crud/model/Crud */
?>


<?php $form = ActiveForm::begin([
        'id'           => 'form-crud',
        'action'       => 'index.php?r=crud/default/process',
        'beforeSubmit' => 'c006_show_spinner',
        'attributes'   => [ 'db_connection' => 'DB Connection' ],
    ]
);
?>


<div style="margin-top: 20px;">
    <div class="c006-info">Use whichever database connection to be queried. Default is "db"</div>
    <?= $form->field($model, 'db_connection') ?>
</div>
<div style="margin-top: 20px;">
    <div class="c006-info">Namespace path to the models directory. Default is automatically added.</div>
    <?= $form->field($model, 'models_path') ?>
</div>
<div style="margin-top: 20px;">
    <div class="c006-info">Namespace path to the model search directory. Default is automatically added. This can be the same as the models path as well.</div>
    <?= $form->field($model, 'models_search_path') ?>
</div>
<div style="margin-top: 20px;">
    <div class="c006-info">Namespace path to the controllers directory. Default is automatically added. Note, views will be added based on the controller path.</div>
    <?= $form->field($model, 'controllers_path') ?>
</div>
<div style="margin-top: 20px;">
    <div class="c006-info">Overwrite existing models</div>
    <?= $form->field($model, 'override_models')->checkbox() ?>
</div>
<div style="margin-top: 20px;">
    <div class="c006-info">Comma delimited list of models to skip. Note, do NOT add .php</div>
    <?= $form->field($model, 'exclude_models') ?>
</div>
<div style="margin-top: 20px;">
    <div class="c006-info">Overwrite existing controllers.</div>
    <?= $form->field($model, 'override_controllers')->checkbox() ?>
</div>
<div style="margin-top: 20px;">
    <div class="c006-info">Comma delimited list of controllers to skip. Note, do NOT add .php</div>
    <?= $form->field($model, 'exclude_controllers') ?>
</div>
<div class="form-group">
    <div class="">
        <?= Html::submitButton('Run', [ 'class' => 'btn btn-primary', 'name' => 'button-submit' ]) ?>
    </div>
</div>

<?php ActiveForm::end() ?>


<?=
    c006\spinner\SubmitSpinner::widget(
        [
            'bg_color'               => '#333333',
            'bg_opacity'             => 0.8,
            'spin_speed'             => 4,
            'radius'                 => 250,
            'bg_spinner_opacity'     => 0.0,
            'bg_spinner_color'       => '#000000',
            'sections'               => 5,
            'section_size'           => 80,
            'section_color'          => '#FFFFFF',
            'section_offset'         => 80,
            'section_opacity_base'   => .2,
            'proportionate_increase' => 0,
        ]
    ) ?>


