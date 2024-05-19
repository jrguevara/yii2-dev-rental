<?php

namespace app\controllers;

use app\models\Tasks;
use app\models\TasksSearch;
use Cloudinary\Api\Exception\NotAllowed;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

/**
 * TasksController implements the CRUD actions for Tasks model.
 */
class TasksController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Tasks models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TasksSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        if (Yii::$app->user->can('UsuarioRol')) {
            $dataProvider->query->where([
                'created_by' => Yii::$app->user->identity->id
            ]);
        }
        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tasks model.
     * @param int $id_task Id Task
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_task)
    {
        $model = $this->findModel($id_task);

        if (Yii::$app->user->can('UsuarioRol')) {
            if ($model->created_by != Yii::$app->user->identity->id) {
                throw new ForbiddenHttpException('No tienes permisos para ver esta tarea');
            }
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Tasks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Tasks();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->code = $this->CreateCode();
                $model->created_by = Yii::$app->user->identity->id;
                $model->created_at = date("Y-m-d H:i:s");
                $model->updated_by = Yii::$app->user->identity->id;
                $model->updated_at = date("Y-m-d H:i:s");
                $model->save();

                return $this->redirect(['view', 'id_task' => $model->id_task]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tasks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_task Id Task
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_task)
    {
        $model = $this->findModel($id_task);

        if (Yii::$app->user->can('UsuarioRol')) {
            if ($model->created_by != Yii::$app->user->identity->id) {
                throw new ForbiddenHttpException('No tienes permisos para editar esta tarea');
            }
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->updated_by = Yii::$app->user->identity->id;
            $model->updated_at = date("Y-m-d H:i:s");
            $model->save();
            return $this->redirect(['view', 'id_task' => $model->id_task]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tasks model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_task Id Task
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_task)
    {
        $model = $this->findModel($id_task);

        if (Yii::$app->user->can('UsuarioRol')) {
            if ($model->created_by != Yii::$app->user->identity->id) {
                throw new ForbiddenHttpException('No tienes permisos para eliminar esta tarea');
            }
        }
        
        $this->findModel($id_task)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tasks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_task Id Task
     * @return Tasks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_task)
    {
        if (($model = Tasks::findOne(['id_task' => $id_task])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Generete Code for use in actionCreate
     * @return string
     */
    function CreateCode()
    {
        $task = Tasks::find()->orderBy(['id_task' => SORT_DESC])->one();
        if (empty($task->code)) $code = 0;
        else $code = $task->code;

        $int = intval(preg_replace('/[^0-9]+/', '', $code), 10);
        $id = $int + 1;

        $number = $id;
        $tmp = "";
        if ($id < 10) {
            $tmp .= "000";
            $tmp .= $id;
        } elseif ($id >= 10 && $id < 100) {
            $tmp .= "00";
            $tmp .= $id;
        } elseif ($id >= 100 && $id < 1000) {
            $tmp .= "0";
            $tmp .= $id;
        } else {
            $tmp .= $id;
        }
        $result = str_replace($id, $tmp, $number);
        return "TASK-" . $result;
    }
}
