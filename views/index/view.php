<?php

use c006\crud\assets\AppFile;
use yii\helpers\Html;

/** @var $array array */
?>

<style>
    .boundary {
        display               : inline-block;
        margin                : 10px;
        padding               : 10px;
        border                : 1px dotted #e7e7e7;
        -webkit-border-radius : 14px;
        -moz-border-radius    : 14px;
        border-radius         : 14px;
        vertical-align        : top;
    }

    .boundary .title {
        color         : #4cae4c;
        display       : block;
        font-size     : 2em;
        font-weight   : bold;
        margin-bottom : 15px;
    }
</style>
<div class="boundary">
    <?= Html::button('Back to Crud', ['class' => 'btn btn-primary', 'id' => 'button-crud']) ?>
</div>
<div class="boundary">
    <div class="title">Backend</div>
    <?php $array = AppFile::recursiveDirectory(Yii::getAlias('@backend') . '/views', '', ''); ?>
    <?php foreach ($array as $item) : ?>
        <?php $item = $item['item'] ?>
        <?php if (!$item['is_dir']) continue; ?>
        <div><a href="/?r=<?= $item['folder'] ?>" target="_blank"><?= $item['folder'] ?></a></div>
    <?php endforeach ?>
</div>
<div class="boundary">
    <div class="title">Frontend</div>
    <?php $array = AppFile::recursiveDirectory(Yii::getAlias('@frontend') . '/views', '', ''); ?>
    <?php foreach ($array as $item) : ?>
        <?php $item = $item['item'] ?>
        <?php if (!$item['is_dir']) continue; ?>
        <div><a href="/?r=<?= $item['folder'] ?>" target="_blank"><?= $item['folder'] ?></a></div>
    <?php endforeach ?>
</div>
<script type="text/javascript">
    jQuery(function () {
        jQuery('#button-crud')
            .bind('click', function () {
                document.location.href = '<?= (Yii::$app->urlManager->enablePrettyUrl) ? '/crud' : '?r=/crud' ?>';
            });
    });
</script>
