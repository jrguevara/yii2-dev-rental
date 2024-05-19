<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Tasks $model */

$this->title = 'Editar registro';
$this->params['breadcrumbs'][] = ['label' => 'Listado', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Detalle', 'url' => ['view', 'id_task' => $model->id_task]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasks-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
