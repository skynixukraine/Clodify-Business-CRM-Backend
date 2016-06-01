<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 26.05.16
 * Time: 16:36
 */
namespace app\modules\ExtensionPackager\controllers;

use app\modules\ExtensionPackager\models\Extension;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\AccessRule;
use app\components\DataTable;
use app\models\User;
use app\modules\ExtensionPackager\models\UploadForm;
use yii\web\UploadedFile;

class ExtensionController extends DefaultController {

    public $enableCsrfValidation = false;
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions' => [ 'index', 'create', 'find'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN ],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index'     => ['get', 'post'],
                    'create'    => ['get', 'post'],
                    'find'      => ['get', 'post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {        
        return $this->render("index", ['title' => 'Manage Extensions']);
    }


    public function actionFind()
    {
        $order          = Yii::$app->request->getQueryParam("order");
        $search         = Yii::$app->request->getQueryParam("search");
        $keyword        = ( !empty($search['value']) ? $search['value'] : null);
        $query = Extension::find();

        $columns        = [
            'id',
            'name',
            'package',
            'version',
            'type',
        ];
        $dataTable = DataTable::getInstance()
            ->setQuery( $query )
            ->setLimit( Yii::$app->request->getQueryParam("length") )
            ->setStart( Yii::$app->request->getQueryParam("start") )
            ->setSearchValue( $keyword ) //$search['value']
            ->setSearchParams([ 'or',
                ['id', 'name', $keyword],
            ]);

        $dataTable->setOrder( $columns[$order[0]['column']], $order[0]['dir']);

        $activeRecordsData = $dataTable->getData();
        $list = array();


        /** @var  $model Extension*/
        foreach ( $activeRecordsData as $model ) {

            $list[] = [
                $model->id,
                $model->name,
                $model->package,
                $model->version,
                $model->type,
            ];
        }

        $data = [
            "draw"              => DataTable::getInstance()->getDraw(),
            "recordsTotal"      => DataTable::getInstance()->getTotal(),
            "recordsFiltered"   => DataTable::getInstance()->getTotal(),
            "data" => $list
        ];
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->content = json_encode($data);
        Yii::$app->end();

    }

    public function actionCreate()
    {

        if($id = Yii::$app->request->get('id')) {

            $title = Yii::t('app', 'Edit the extension #{s}', ['s' => $id]);
            $model = Extension::findOne($id);
        } else {

            $title = Yii::t('app', 'Add a New Extension');
            $model = new Extension();

        }
        $modelUpload = new UploadForm();
        /** Load data from form*/
        if (Yii::$app->request->isPost) {
            
                /** Save data to table extensions */
            if($model->load(Yii::$app->request->post())){

                if(file_exists(Yii::getAlias("@app") . '/data/extensions/' . $model->id)) {
                    exec('rm -rf ' . Yii::getAlias("@app") . '/data/extensions/' . $model->id);
                }

                $modelUpload->picture = UploadedFile::getInstance($modelUpload, 'picture');
                $modelUpload->license = UploadedFile::getInstance($modelUpload, 'license');
                $modelUpload->user_guide = UploadedFile::getInstance($modelUpload, 'user_guide');
                $modelUpload->installation_guide = UploadedFile::getInstance($modelUpload, 'installation_guide');

                if($model->validate() && $model->save() && $modelUpload->validate()) {
                    /** Create the folders */
                    $path = Extension::getPathExtension($model->id);

                    $modelUpload->picture->           saveAs($path . 'cover.jpg');
                    $modelUpload->license->           saveAs($path . 'license.txt');
                    $modelUpload->user_guide->        saveAs($path . 'Skynix-Installation-Guide.pdf');
                    $modelUpload->installation_guide->saveAs($path . 'User-Guide.pdf');

                    Extension::createExtensionFolder($model->id);

                    /** clone from repository and parsed composer.json */
                    exec('cd ' . Yii::getAlias("@app") . '/data/extensions/' . $model->id . '/temp/ && git clone ' . $model->repository, $return, $output);
                    if($output == 0) {
                        $composer = exec('cd ' . Yii::getAlias("@app") . '/data/extensions/' . $model->id . '/temp/ && ls');
                        if (file_exists(Yii::getAlias("@app") . '/data/extensions/' . $model->id . '/temp/' . $composer . '/composer.json')) {

                            $composer_content = file_get_contents(Yii::getAlias("@app") . '/data/extensions/' . $model->id . '/temp/' . $composer . '/composer.json');
                            $json_a = json_decode($composer_content);

                            /** save name adn version extension */
                            if (isset($json_a->name)) {
                                $model->name = $json_a->name;
                                $paths = explode('/', $json_a->name);
                                $model->path1 = $paths[0];
                                $model->path2 = $paths[1];

                            }
                            if (isset($json_a->version)) {
                                $model->version = $json_a->version;
                            }
                            if ($model->validate() && $model->save(true, ['name', 'version'])) {

                                if ($model->type == Extension::TYPE_EXTENSION) {
                                    if (Extension::extensionType($model->path1, $model->path2, $model->id)) {

                                        Yii::$app->getSession()->setFlash('success', Yii::t("app", "You create/edit new Extension " . $model->id . ' TYPE EXTENSION'));
                                        return $this->redirect('index');
                                    }
                                }
                                if ($model->type == Extension::TYPE_THEME) {
                                    if (Extension::themeType($model->path1, $model->path2, $model->id)) {

                                        Yii::$app->getSession()->setFlash('success', Yii::t("app", "You create/edit new Extension " . $model->id . ' TYPE THEME'));
                                        return $this->redirect('index');
                                    }
                                }
                                if ($model->type == Extension::TYPE_LANGUAGE) {
                                    if (Extension::languageType($model->path1, $model->path2, $model->id)) {

                                        Yii::$app->getSession()->setFlash('success', Yii::t("app", "You create/edit new Extension " . $model->id . ' TYPE LANGUAGE'));
                                        return $this->redirect('index');
                                    }
                                }
                            }

                        } else {

                            Yii::$app->getSession()->setFlash('error', Yii::t("app", "File composer.json does not exist!"));
                            return $this->redirect('index');

                        }

                    } else {

                        Yii::$app->getSession()->setFlash('error', Yii::t("app", "Failed to clone the files from the repository!"));
                        return $this->redirect('index');

                    }

                }
            }
        }
        
        return $this->render("create", ['model' => $model, 'modelUpload' => $modelUpload, 'title' => $title]);
    }    
}

