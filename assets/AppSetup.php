<?php

    namespace c006\crud\assets;

    use Yii;

    /**
     * Class AppModelSetup
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
         *
         */
        function __construct($db_connection)
        {

            $this->connection = Yii::$app->$db_connection;
        }


        /**
         *
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
        private function deleteModels($override, $array_exclude = [ ])
        {

            $path   = Yii::getAlias('@' . $this->models_path);
            $path   = AppFile::useBackslash($path);
            $models = $this->connection->schema->tableNames;
            foreach ($models as $model) {
                $modelName = self::createModelName($model);
                if ( is_file(realpath($path . '/' . $modelName . '.php')) ) {
                    if ( $override && in_array($modelName, $array_exclude) == FALSE ) {
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
                if ( $override && in_array($model, $array_exclude) )
                    continue;
                $generator             = new \yii\gii\generators\model\Generator();
                $generator->enableI18N = TRUE;
                $generator->tableName  = $model;
                $generator->modelClass = self::createModelName($model);
                $generator->template   = 'default';
                $generator->ns         = AppFile::useForwardSlash($this->models_path);
                $files                 = $generator->generate();
                $path                  = AppFile::useBackslash(Yii::getAlias('@' . $this->models_path) . '/' . $generator->modelClass . '.php');
                AppFile::writeFile($path, $files[0]->content);
            }
        }


        /**
         * @param       $override
         * @param array $array_exclude
         */
        public function runCrud($override, $array_exclude = [ ])
        {

            $path   = Yii::getAlias('@' . $this->models_path);
            $path   = AppFile::useBackslash($path);
            $models = $this->connection->schema->tableNames;
            foreach ($models as $model) {
                $modelName = self::createModelName($model);
                if ( is_file(realpath($path . '/' . $modelName . '.php')) ) {
                    if ( $override && in_array($modelName, $array_exclude) == FALSE ) {
                        self::makeCrud($modelName);
                    }
                }
            }

        }


        /**
         * @param $model
         */
        private function makeCrud($model)
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
                if ( !is_dir($dir) )
                    mkdir($dir);
                AppFile::writeFile(AppFile::useBackslash($file->path), $file->content);
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
