<?php
Yii::$app->language = 'es_ES';

use app\models\Areas;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\editors\Summernote;
use kartik\widgets\Select2;
use kartik\widgets\SwitchInput;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Tasks $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php

$this->registerJs(
    '$("document").ready(function(){ 
		$("#new_form").on("pjax:end", function() {
			$.pjax.reload({container:"#grid"});  //Reload GridView
		});
    });'
);
?>

<div class="row">
    <div class="col-md-12">
        <div class="card card-dark card-outline" ;">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title">Crear / Editar registro</h3>
            </div>
            <?php yii\widgets\Pjax::begin(['id' => 'new_form']) ?>
            <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>
            <div class="card-body">
                <form role="form">
                    <div class="row">
                        <div class="col-md-12">
                            <?= Html::activeLabel($model, 'name', ['class' => 'control-label']) ?>
                            <?= $form->field($model, 'name', ['showLabels' => false])->textInput(['autofocus' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= Html::activeLabel($model, 'id_area', ['class' => 'control-label']) ?>
                            <?= $form->field($model, 'id_area', ['showLabels' => false])->widget(Select2::class, [
                                'data' => ArrayHelper::map(Areas::find()->all(), 'id_area', 'name'),
                                'language' => 'es',
                                'options' => ['placeholder' => '- Seleccionar Area -'],
                                'pluginOptions' => ['allowClear' => true],
                            ]); ?>
                        </div>
                        <div class="col-md-12">
                            <?= Html::activeLabel($model, 'description', ['class' => 'control-label']) ?>
                            <?= $form->field($model, 'description', ['showLabels' => false])->widget(Summernote::class, [
                                'useKrajeePresets' => false,
                                'container' => [
                                    'class' => 'kv-editor-container',
                                ],
                                'pluginOptions' => [
                                    'height' => 200,
                                    'dialogsFade' => true,
                                    'toolbar' => [
                                        ['style1', ['style']],
                                        ['style2', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript']],
                                        ['font', ['fontname', 'fontsize', 'color', 'clear']],
                                        ['para', ['ul', 'ol', 'paragraph', 'height']],
                                        ['insert', ['link', 'table', 'hr']],
                                    ],
                                    'fontSizes' => ['8', '9', '10', '11', '12', '13', '14', '16', '18', '20', '24', '36', '48'],
                                    'placeholder' => 'Escribir descripción de categoria...',
                                ]
                            ]); ?>
                        </div>
                        <div class="ml-auto">
                            <?= Html::activeLabel($model, 'status', ['class' => 'control-label']) ?>
                            <?php
                            echo $form->field($model, 'status', ['showLabels' => false])->widget(SwitchInput::class, [
                                'pluginOptions' => [
                                    'handleWidth' => 100,
                                    'onColor' => 'primary',
                                    'offColor' => 'danger',
                                    'onText' => '<i class="fa fa-clock"></i> En proceso',
                                    'offText' => '<i class="fa fa-check"></i> Finalizada'
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Guardar' : '<i class="fa fa-save"></i> Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'name' => 'submit-button']) ?>

                        <?php if ($model->isNewRecord) {
                            echo Html::a('<i class="fa fa-ban"></i> Cancelar', ['index'], ['class' => 'btn btn-danger']);
                        } else {
                            echo Html::a('<i class="fa fa-ban"></i> Cancelar', ['view', 'id_task' => $model->id_task], ['class' => 'btn btn-danger']);
                        }
                        ?>
                    </div>
                </form>
                <?php ActiveForm::end(); ?>
                <?php yii\widgets\Pjax::end() ?>
            </div>
        </div>
    </div>
</div>