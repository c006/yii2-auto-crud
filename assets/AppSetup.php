<?php

namespace c006\crud\assets;

use Yii;

/**
 * Class AppSetup
 *
 * @package c006\crud\assets
 */
class AppSetup
{

    /**
     * @var mixed
     */
    private $connection;

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
     * @param $db_connection
     */
    function __construct($db_connection)
    {
        $this->connection = Yii::$app->$db_connection;
    }


    /**
     * @param $override
     * @param $array_exclude
     */
    public function runModels($override, $array_exclude)
    {
        self::deleteModels($override, $array_exclude);
        self::makeModels($override, $array_exclude);
    }


    /**
     * @param       $override
     * @param array $array_exclude
     */
    private function deleteModels($override, $array_exclude = [])
    {
        $alias  = AppFile::getFirstFolderInPath($this->models_path);
        $path   = Yii::getAlias('@' . $alias) . '' . str_replace($alias, '', $this->models_path);
        $path   = AppFile::useBackslash($path);
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
     * @param $override
     * @param $array_exclude
     */
    private function makeModels($override, $array_exclude)
    {
        $models = $this->connection->schema->tableNames;
        foreach ($models as $model) {
            if ((!in_array($model, $array_exclude) && $override)
                || (!$override)
            ) {
                $generator             = new \yii\gii\generators\model\Generator();
                $generator->enableI18N = TRUE;
                $generator->tableName  = $model;
                $generator->modelClass = self::createModelName($model);
                $generator->template   = 'default';
                $generator->ns         = AppFile::useForwardSlash($this->models_path);
                $files                 = $generator->generate();
                $alias                 = AppFile::getFirstFolderInPath($this->models_path);
                $path                  = Yii::getAlias('@' . $alias) . '' . str_replace($alias, '', $this->models_path);
                $path                  = AppFile::useBackslash($path . '/' . $generator->modelClass . '.php');
                $content               = $files[0]->content;
                AppFile::writeFile($path, $content);
            }
        }
    }


    /**
     * @param       $override
     * @param array $array_exclude
     */
    public function runCrud($override, $array_exclude = [], $use_toggle = FALSE)
    {
        $alias  = AppFile::getFirstFolderInPath($this->models_path);
        $path   = Yii::getAlias('@' . $alias) . '' . str_replace($alias, '', $this->models_path);
        $path   = AppFile::useBackslash($path);
        $models = $this->connection->schema->tableNames;
        foreach ($models as $model) {
            $modelName = self::createModelName($model);
            if (is_file(realpath($path . '/' . $modelName . '.php'))) {
                if ((!in_array($model, $array_exclude) && $override)
                    || (!$override)
                ) {
                    self::makeCrud($modelName, $use_toggle);
                }
            }
        }

    }


    /**
     * @param      $model
     * @param bool $use_toggle
     */
    private function makeCrud($model, $use_toggle = FALSE)
    {
        $generator                   = new \yii\gii\generators\crud\Generator();
        $generator->enableI18N       = TRUE;
        $generator->modelClass       = AppFile::useForwardSlash($this->models_path . chr(92) . $model);
        $generator->searchModelClass = AppFile::useForwardSlash($this->models_search_path . chr(92) . $model);
        $generator->controllerClass  = AppFile::useForwardSlash($this->controller_path . chr(92) . $model . 'Controller');
        $generator->template         = 'default';
        $files                       = $generator->generate();
        foreach ($files as $file) {
            $dir = AppFile::useBackslash(AppFile::removeFileInPath($file->path));
            if (!is_dir($dir))
                mkdir($dir);
            $content = $file->content;
            if ($use_toggle) {
                $content = preg_replace('/->checkbox/', '->toggle', $content);
                $content = preg_replace('/(yii.widgets.ActiveForm)/', 'c006\\activeForm\\ActiveForm', $content);
                $content = preg_replace('/(yii.bootstrap.ActiveForm)/', 'c006\\activeForm\\ActiveForm', $content);
            }
            AppFile::writeFile(AppFile::useBackslash($file->path), $content);
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
        $array  = explode('_', $table_name);
        foreach ($array as $name)
            $output .= ucfirst(strtolower($name));

        return $output;
    }
}
