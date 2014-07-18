<?php

    namespace c006\crud\models;

    use Yii;
    use yii\db\ActiveRecord;

    class Crud extends ActiveRecord
    {

        public $db_connection;
        public $models_path;
        public $models_search_path;
        public $controllers_path;
        public $override_models;
        public $override_controllers;
        public $exclude_models;
        public $exclude_controllers;


        function __construct()
        {

            $this->override_controllers = (boolean)FALSE;
            $this->override_models      = (boolean)FALSE;
        }

    }
