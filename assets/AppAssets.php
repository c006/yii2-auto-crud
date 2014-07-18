<?php
    /**
     * Created by PhpStorm.
     * User: user
     * Date: 5/24/14
     * Time: 11:47 AM
     */
    namespace c006\crud\assets;

    use yii\web\AssetBundle;
    use yii\web\View;

    class AppAssets extends AssetBundle
    {

        /**
         * @inheritdoc
         */
        public $sourcePath = '@vendor/c006/yii2-auto-crud/assets';
        /**
         * @inheritdoc
         */
        public $css = [
            'c006-crud.css',
        ];
        /**
         * @inheritdoc
         */
        public $js = [
            'c006-crud.js',
        ];
        /**
         * @inheritdoc
         */
        public $depends = [
        ];

        public $jsOptions = [
            'position' => View::POS_END,
        ];

    }
