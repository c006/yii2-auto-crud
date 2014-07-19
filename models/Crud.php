<?php

    namespace c006\crud\models;

    use Yii;
    use yii\db\ActiveRecord;

    /**
     * Class Crud
     *
     * @package c006\crud\models
     */
    class Crud extends ActiveRecord
    {

        /**
         * @var
         */
        public $db_connection;
        /**
         * @var
         */
        public $models_path;
        /**
         * @var
         */
        public $models_search_path;
        /**
         * @var
         */
        public $controllers_path;
        /**
         * @var bool
         */
        public $override_models;
        /**
         * @var bool
         */
        public $override_controllers;
        /**
         * @var
         */
        public $exclude_models;
        /**
         * @var
         */
        public $exclude_controllers;


        /**
         *
         */
        function __construct()
        {

            $this->override_controllers = (boolean)FALSE;
            $this->override_models      = (boolean)FALSE;
        }

    }
