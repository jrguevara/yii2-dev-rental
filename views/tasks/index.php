<?php

use app\models\Areas;
use app\models\Tasks;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TasksSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="categorias-index">
            <h1><?php //= Html::encode($this->title) 
                ?></h1>
            <?php //echo $this->render('_search', ['model' => $searchModel]); 
            ?>

            <?php
            $gridColumns = [
                [
                    'class' => 'kartik\grid\SerialColumn',
                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                    'width' => '36px',
                    'header' => '#',
                    'headerOptions' => ['class' => 'kartik-sheet-style']
                ],
                [
                    'class' => 'kartik\grid\DataColumn',
                    'width' => '40px',
                    'format' => 'raw',
                    'vAlign' => 'middle',
                    'hAlign' => 'center',
                    'attribute' => 'id_task',
                    'value' => function ($model, $key, $index, $widget) {
                        return Html::tag('span', $model->id_task, ['class' => 'badge bg-purple']);
                    },
                    'filter' => false,
                ],
                [
                    'class' => 'kartik\grid\DataColumn',
                    'attribute' => 'name',
                    'vAlign' => 'middle',
                    'format' => 'html',
                    'value' => function ($model, $key, $index, $widget) {
                        return Html::a($model->name,  ['view', 'id_task' => $model->id_task]);
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => ArrayHelper::map(Tasks::find()->orderBy('name')->all(), 'name', 'name'),
                    'filterWidgetOptions' => [
                        'options' => ['placeholder' => 'Todos...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ],
                ],
                [
                    'class' => 'kartik\grid\DataColumn',
                    'attribute' => 'id_area',
                    'vAlign' => 'middle',
                    'format' => 'html',
                    'value' => 'area.name',
                    'width' => '150px',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => ArrayHelper::map(Areas::find()->orderBy('name')->all(), 'id_area', 'name'),
                    'filterWidgetOptions' => [
                        'options' => ['placeholder' => 'Todos...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ],
                ],
                [
                    'attribute' => 'updated_at',
                    'vAlign' => 'middle',
                    'width' => '150px',
                    'value' => function ($model) {
                        return date("d-m-Y",  strtotime($model->updated_at));
                    },
                    'filterType' => GridView::FILTER_DATE_RANGE,
                    'filterWidgetOptions' => ([
                        'model' => $searchModel,
                        'attribute' => 'updated_at',
                        'presetDropdown' => true,
                        'hideInput' => true,
                        'defaultPresetValueOptions' => ['style' => 'display:none'],
                        'convertFormat' => true,
                        'readonly' => true,
                        'options' => [
                            'placeholder' => 'Seleccionar rango...'
                        ],
                        'pluginOptions' => [
                            'locale' => ['format' => 'Y-m-d'],
                            'opens' => 'left'
                        ],
                    ]),
                ],
                [
                    'class' => 'kartik\grid\DataColumn',
                    'attribute' => 'updated_by',
                    'vAlign' => 'middle',
                    'format' => 'html',
                    'value' => 'updatedBy.fullname',
                    'width' => '150px',
                    "visible" => Yii::$app->user->can('AdminRol'),
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => ArrayHelper::map(Tasks::find()->orderBy('updated_by')->all(), 'updated_by', 'updatedBy.fullname'),
                    'filterWidgetOptions' => [
                        'options' => ['placeholder' => 'Todos...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ],
                ],
                [
                    'class' => 'kartik\grid\BooleanColumn',
                    'attribute' => 'status',
                    'vAlign' => 'middle',
                    'width' => '120px',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'options' => ['placeholder' => 'Todos...'],
                        'data' => ['1' => 'En proceso', '0' => 'Finalizada'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ],
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'header' => 'Acciones',
                    'urlCreator' => function ($action, tasks $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id_task' => $model->id_task]);
                    }
                ],
            ];

            $exportmenu = ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns,
                'exportConfig' => [
                    ExportMenu::FORMAT_TEXT => false,
                    ExportMenu::FORMAT_HTML => false,
                    ExportMenu::FORMAT_CSV => false,
                ],
            ]);

            echo GridView::widget([
                'id' => 'kv-sub-categorias',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
                'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                'filterRowOptions' => ['class' => 'kartik-sheet-style'],
                'pjax' => true, // pjax is set to always true for this demo
                // set your toolbar
                'toolbar' =>  [
                    [
                        'content' =>
                        Html::a('<i class="fas fa-plus"></i> Agregar', ['create'], [
                            'class' => 'btn btn-success',
                            'data-pjax' => 0,
                        ]) . ' ' .
                            Html::a('<i class="fas fa-redo"></i>', ['index'], [
                                'class' => 'btn btn-outline-success',
                                'data-pjax' => 0,
                            ]),
                        'options' => ['class' => 'btn-group mr-2']
                    ],
                    $exportmenu,
                    '{toggleData}',
                ],
                'toggleDataContainer' => ['class' => 'btn-group mr-2'],
                // set export properties
                // parameters from the demo form
                'bordered' => true,
                'striped' => true,
                'condensed' => true,
                'responsive' => true,
                'hover' => true,
                //'showPageSummary'=>$pageSummary,
                'panel' => [
                    'type' => 'dark',
                    'heading' => 'Listado de SubCategorias',
                ],
                'persistResize' => false,
            ]);
            ?>
        </div>
    </div>
</div>