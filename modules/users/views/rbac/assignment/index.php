<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

Yii::$app->language = 'es_ES';

/* @var $this \yii\web\View */
/* @var $gridViewColumns array */
/* @var $dataProvider \yii\data\ArrayDataProvider */
/* @var $searchModel \yii2mod\rbac\models\search\AssignmentSearch */

$this->title = Yii::t('yii2mod.rbac', 'Roles Asignados');
$this->params['breadcrumbs'][] = $this->title;
$this->render('/layouts/_sidebar');
?>
<div class="assignment-index">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <?php Pjax::begin(['timeout' => 5000]); ?>
    <div class="col-md-12">
        <div class="card card-dark card-outline">
            <div class="card-body">
                <?php echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => ArrayHelper::merge($gridViewColumns, [
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view}',
                        ],
                    ]),
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>