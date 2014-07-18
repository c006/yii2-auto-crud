<?php

    namespace c006\crud\controllers;

    use c006\crud\assets\AppAssets;
    use c006\crud\assets\AppSetup;
    use c006\crud\models\Crud;
    use Yii;
    use yii\filters\VerbFilter;
    use yii\web\Controller;

    /**
     * AliasUrlController implements the CRUD actions for AliasUrl model.
     */
    class DefaultController extends Controller
    {
        function init()
        {

            $view = $this->getView();
            AppAssets::register($view);
        }


        public function behaviors()
        {

            return [
                'verbs' => [
                    'class'   => VerbFilter::className(),
                    'actions' => [
                        'delete' => [ 'post' ],
                    ],
                ],
            ];
        }


        /**
         * Lists all AliasUrl models.
         *
         * @return mixed
         */
        public function actionIndex()
        {

            $model                = new Crud();
            $model->db_connection = 'db';
            if ( is_dir(Yii::getAlias('@app') . '/models') ) {
                $model->models_path = 'app/models';
                if ( !is_dir(Yii::getAlias('@app') . '/models/search') )
                    mkdir(Yii::getAlias('@app') . '/models/search');
                $model->models_search_path = 'app/models/search';

            }
            else {
                $model->models_path = 'common/models';
                if ( !is_dir(Yii::getAlias('@common') . '/models/search') )
                    mkdir(Yii::getAlias('@common') . '/models/search');
                $model->models_search_path = 'common/models/search';
            }
            if ( is_dir(Yii::getAlias('@app') . '/controllers') )
                $model->controllers_path = 'app/controllers';
            else
                $model->controllers_path = 'frontend/controllers';
            $model->exclude_models      = 'User, Migration';
            $model->exclude_controllers = 'Migration';

            return $this->render('index', [
                    'model' => $model,
                ]
            );
        }


        public function actionProcess()
        {

            if ( !isset($_POST['Crud']) )
                $this->redirect('/');
            $post                = $_POST['Crud'];
            $db                  = $post['db_connection'];
            $model_override      = (isset($post['override_models'])) ? TRUE : FALSE;
            $controller_override = (isset($post['override_controllers'])) ? TRUE : FALSE;
            /* */
            $appSetup                     = new AppSetup($db);
            $appSetup->models_path        = $post['models_path'];
            $appSetup->models_search_path = $post['models_search_path'];
            $appSetup->controller_path    = $post['controllers_path'];
            //            print_r($appSetup);exit;
            if ( $model_override ) {
                $string = trim($post['exclude_models']);
                $string = preg_replace('/[^\w|,]/', '', $string);
                $array  = explode(',', $string);
                $appSetup->runModels(TRUE, $array);
            }
            else {
                $appSetup->runModels(FALSE, [ ]);
            }
            if ( $controller_override ) {
                $string = trim($post['exclude_controllers']);
                $string = preg_replace('/[^\w|,]/', '', $string);
                $array  = explode(',', $string);
                $appSetup->runCrud(TRUE, $array);
            }
            else {
                $appSetup->runCrud(FALSE, [ ]);
            }

            return $this->render('process', [ ]);
        }

    }
