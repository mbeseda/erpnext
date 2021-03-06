<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GeoCountry */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="geo-country-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iso3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iso2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zip_name')->textInput(['maxlength' => true]) ?>

    <?= $field = $form->field($model, 'geo_macroregion_geo_id')
        ->dropDownList(\yii\helpers\ArrayHelper::map(\backend\models\GeoMacroregionGeo::find()->where(['status' => 1, 'is_group' => 0])->all(),'id','title'), 
        ['prompt' => ['text' => '', 'options' => ['value' => '0', 'class' => 'prompt', 'label' => '']],
        'options' => [$model->geo_macroregion_geo_id => ['selected' => 'selected']]]) ?>

    <?= $field = $form->field($model, 'geo_macroregion_com_id')
        ->dropDownList(\yii\helpers\ArrayHelper::map(\backend\models\GeoMacroregionCom::find()->where(['status' => 1, 'is_group' => 0])->all(),'id','title'), 
        ['prompt' => ['text' => '', 'options' => ['value' => '0', 'class' => 'prompt', 'label' => '']],
        'options' => [$model->geo_macroregion_geo_id => ['selected' => 'selected']]]) ?>

    <?= !$model->isNewRecord ? $form->field($model, 'status')->dropDownList([ '1' => 'Actual','Archive','Deleted']) : '' ?>

    <?= $field = $form->field($model, 'group_id')->label('Group')->dropDownList($model->getGroups(), 
        ['prompt' => ['text' => '', 'options' => ['value' => '0', 'class' => 'prompt', 'label' => '']],
        'options' => [$model->group_id => ['selected' => 'selected']]]) ?>

    <?= $form->field($model, 'is_group')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
