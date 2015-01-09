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
    public $overwrite_models = 0;

    /**
     * @var bool
     */
    public $overwrite_controllers = 0;

    /**
     * @var
     */
    public $exclude_models;

    /**
     * @var
     */
    public $exclude_controllers;

    /**
     * @var int
     */
    public $use_toggle = 0;

    /**
     * @var array
     */
    public $database_tables = [];

    /**
     * @var string
     */
    public $tables = '';

}
