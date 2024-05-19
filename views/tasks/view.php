<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Tasks $model */

$this->title = 'Detalle';
$this->params['breadcrumbs'][] = ['label' => 'Listado', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="row">
    <div class="col-md-12">
        <div class="card card-dark card-outline" ;">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title dark"><?= $model->code ?></h3>
            </div>
            <div class="card-body">
                <table class="table table-sm table-striped table-hover table-bordered">
                    <tr>
                        <td width="15%%"><b>Id:</b></td>
                        <td width="85%"><span class="badge bg-purple"><?= $model->id_task ?></span></td>
                    </tr>
                    <tr>
                        <td><b>Codigo:</b></td>
                        <td> <?= $model->code ?></td>
                    </tr>
                    <tr>
                        <td><b>Nombre:</b></td>
                        <td> <?= $model->name ?></td>
                    </tr>
                    <tr>
                        <td><b>Area:</b></td>
                        <td> <?= $model->area->name ?></td>
                    </tr>
                    <tr>
                        <td><b>Descripción: </b></td>
                        <td><?= $model->description ?></td>
                    </tr>
                    <td><b>Fecha creación:</b></td>
                    <td><?= date('d-m-Y H:m:i', strtotime($model->created_at)) ?></td>
                    </tr>
                    <tr>
                        <td><b>Creado por: </b></td>
                        <td><?= $model->createdBy->fullname ?></td>
                    </tr>
                    <tr>
                        <td><b>Fecha modificación:</b></td>
                        <td><?= date('d-m-Y H:m:i', strtotime($model->updated_at)) ?></td>
                    </tr>
                    <tr>
                        <td><b>Modificado por: </b></td>
                        <td><?= $model->updatedBy->fullname ?></td>
                    </tr>
                    <tr>
                        <td><b>Estado: </b></td>
                        <td><span class="badge bg-<?= $model->status == 1 ? "blue" : "red"; ?>"><?= $model->status == 1 ? "En proceso" : "Finalizada"; ?></span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div>
                        <?php echo Html::a('<i class="fa fa-undo"></i> Regresar', ['index'], ['class' => 'btn btn-secondary', 'data-toggle' => 'tooltip', 'title' => 'Regresar']) ?>
                        <?php echo Html::a('<i class="fa fa-edit"></i> Editar', ['update', 'id_task' => $model->id_task], ['class' => 'btn btn-primary', 'data-toggle' => 'tooltip', 'title' => 'Editar registro']) ?>
                    </div>
                    <div class="ml-auto">
                        <?= Html::a('<i class="fa fa-trash"></i> Eliminar', ['delete', 'id_task' => $model->id_task], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Esta seguro de querer eliminar este registro?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>