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
    public $process_models = 0;

    /**
     * @var string
     */
    public $exclude_models = '';

    /**
     * @var bool
     */
    public $process_controllers = 0;

    /**
     * @var string
     */
    public $exclude_controllers = '';

    /**
     * @var array
     */
    public $database_tables = [];

    /**
     * @var string
     */
    public $tables = '';

    /**
     * @var string
     */
    public $namespace = '';

    /**
     * @var string
     */
    public $crud_template = 'sample';

    /**
     * @var string
     */
    public $crud_template_path = '@c006/crud/templates/sample';

}
