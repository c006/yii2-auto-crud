<?php

namespace c006\crud\assets;

use c006\crud\assets\AppFile;
use Yii;

/**
 * Class AppSetup
 *
 * @package c006\crud\assets
 */
class AppSetup
{

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
    public $controller_path;

    /**
     * @var mixed
     */
    private $connection;

    /**
     * @param $db_connection
     */
    function __construct($db_connection)
    {
        $this->connection = Yii::$app->$db_connection;
    }


    /**
     * @param       $override
     * @param       $array_exclude
     * @param array $models
     */
    public function runModels($override, $array_exclude, $models = array())
    {
        self::deleteModels($override, $array_exclude, $models);
        self::makeModels($override, $array_exclude, $models);
    }


    /**
     * @param       $override
     * @param array $array_exclude
     * @param array $models
     */
    private function deleteModels($override, $array_exclude = [], $models = array())
    {
        $path = Yii::getAlias('@' . $this->models_path);
        $path = AppFile::useForwardSlash($path);
        if (!sizeof($models))
            $models = $this->connection->schema->tableNames;
        foreach ($models as $model) {
            $modelName = self::createModelName($model);
            if (is_file(realpath($path . '/' . $modelName . '.php'))) {
                if ((!in_array($model, $array_exclude) && $override)
                    || (!$override)
                ) {
                    chmod(realpath(AppFile::useBackslash($path . '/' . $modelName . '.php')), 0777);
                    unlink(realpath(AppFile::useBackslash($path . '/' . $modelName . '.php')));
                }
            }
        }
    }

    /**
     * @param $table_name
     *
     * @return string
     */
    private function createModelName($table_name)
    {
        $output = "";
        $array = explode('_', $table_name);
        foreach ($array as $name)
            $output .= ucfirst(strtolower($name));

        return $output;
    }

    /**
     * @param       $override
     * @param       $array_exclude
     * @param array $models
     */
    private function makeModels($override, $array_exclude, $models = array())
    {
        if (!sizeof($models))
            $models = $this->connection->schema->tableNames;
        foreach ($models as $model) {
            if ((!in_array($model, $array_exclude) && $override)
                || (!$override)
            ) {
                $generator = new \yii\gii\generators\model\Generator();
                $generator->enableI18N = TRUE;
                $generator->tableName = $model;
                $generator->modelClass = self::createModelName($model);
                $generator->template = 'default';
                $generator->ns = AppFile::useForwardSlash($this->models_path);
                $files = $generator->generate();
                $path = Yii::getAlias('@' . $this->models_path);
                $path = AppFile::useBackslash($path . '/' . $generator->modelClass . '.php');
                $content = $files[0]->content;
                AppFile::writeFile($path, $content);
            }
        }
    }

    /**
     * @param       $override
     * @param array $array_exclude
     * @param bool $use_toggle
     * @param array $models
     */
    public function runCrud($override, $array_exclude = [], $use_toggle = FALSE, $models = array())
    {
        $path = Yii::getAlias('@' . $this->models_path);
        $path = AppFile::useBackslash($path);
        if (!sizeof($models))
            $models = $this->connection->schema->tableNames;
        foreach ($models as $model) {
            $modelName = self::createModelName($model);
            $path = AppFile::useBackslash($path . '/' . $modelName . '.php');
            if (is_file(realpath($path))) {
                if (in_array($model, $array_exclude) == FALSE || $override == TRUE) {
                    self::makeCrud($modelName, $use_toggle);
                }
            } else {
                die("Model does not exist: " . $path);
            }
        }
    }

    /**
     * @param      $model
     * @param bool $use_toggle
     */
    private function makeCrud($model, $use_toggle = FALSE)
    {
        $generator = new \yii\gii\generators\crud\Generator();
        $generator->enableI18N = TRUE;
        $generator->modelClass = AppFile::useForwardSlash($this->models_path . chr(92) . $model);
        $generator->searchModelClass = AppFile::useForwardSlash($this->models_search_path . chr(92) . $model);
        $generator->controllerClass = AppFile::useForwardSlash($this->controller_path . chr(92) . $model . 'Controller');
        $generator->template = 'default';
        $files = $generator->generate();

        foreach ($files as $file) {
            $file->path = AppFile::useBackslash($file->path);
            echo "<BR>" . $file->path;
            $dir = AppFile::removeFileInPath($file->path);
            if (!is_dir($dir))
                mkdir($dir);
            $content = $file->content;
            if (strpos($file->path, '/views/') != FALSE) {
                if ($use_toggle) {
                    $content = preg_replace('/->checkbox/', '->toggle', $content);
                    $content = preg_replace('/(yii.widgets.ActiveForm)/', 'c006\\activeForm\\ActiveForm', $content);
                    $content = preg_replace('/(yii.bootstrap.ActiveForm)/', 'c006\\activeForm\\ActiveForm', $content);
                }
                $dir_name = trim(preg_replace('/([A-Z])/', " $1", $model));
                $dir_name = strtolower(str_replace(' ', '-', $dir_name));
                $path = AppFile::useBackslash(Yii::getAlias('@' . $this->controller_path)) . '/' . $dir_name;
                $file->path = AppFile::fileFromPath($file->path);
                $path = preg_replace('/\/controllers\//', '/views/', $path);
                if (!is_dir($path))
                    mkdir($path);
                $file->path = $path . '/' . $file->path;
            }
            AppFile::writeFile($file->path, $content);
        }
    }
}
