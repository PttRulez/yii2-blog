<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Url;
use pttrulez\blog\models\Tag;

/* @var $this yii\web\View */
/* @var $model pttrulez\blog\models\Blog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data'],
    ]); ?>

    
    
   
<div class="row">
    <?= $form->field($model, 'file', ['options' => ['class' => 'col-xs-6']])->widget(kartik\file\FileInput::className(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
            'showCaption' => false,
            'showRemove' => false,
            'showUpload' => false,
            'browseClass' => 'btn btn-primary btn-block',
            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
            'browseLabel' =>  'Выберите файл'
        ],
    ]) ?>
    
    <?= $form->field($model, 'title', ['options' => ['class' => 'col-xs-6']])->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'url', ['options' => ['class' => 'col-xs-6']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_id', ['options' => ['class' => 'col-xs-6']])->dropDownList($model->statusList) ?>

    <?= $form->field($model, 'sort', ['options' => ['class' => 'col-xs-6']])->textInput() ?>
 
    

    <?= $form->field($model, 'tags_array', ['options' => ['class' => 'col-xs-6']])->widget(\kartik\select2\Select2::classname(), [
        'data' => yii\helpers\ArrayHelper::map(Tag::find()->all(), 'id', 'name'),
        'language' => 'ru',
        'options' => [
            'placeholder' => 'Выбери тэг',
            'multiple' => true,
            ],
        'pluginOptions' => [
            'tags' => true,
            'allowClear' => true,
            'maximumInputLength' => 10,
        ],
    ]);?>
</div>    
     <?= $form->field($model, 'text')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'formatting' => ['p', 'blockquote', 'h1', 'h2'],
            'imageUpload' => \yii\helpers\Url::to(['/site/save-redactor-img', 'sub'=>'blog']),
            'plugins' => [
                'clips',
                'fullscreen',
            ],
            'clips' => [
                ['Lorem ipsum...', 'Lorem...'],
                ['red', '<span class="label-red">red</span>'],
                ['green', '<span class="label-green">green</span>'],
                ['blue', '<span class="label-blue">blue</span>'],
            ],
        ],
    ]); ?>
    


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ?'Create' : 'Update', ['class' => $model->isNewRecord ? 
                'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?= \kartik\file\FileInput::widget([
        'name' => 'ImageManager[attachment]',
        'options'=>[
            'multiple'=>true
        ],
        'pluginOptions' => [
            'deleteUrl' => Url::toRoute(['/blog/delete-image']),
            'initialPreview'=> $model->imagesLinks,
            'initialPreviewAsData'=>true,
            'overwriteInitial'=>false,
            'initialPreviewConfig'=>$model->imagesLinksData,
            'uploadUrl' => yii\helpers\Url::to(['/site/save-img']),
            'uploadExtraData' => [
                'ImageManager[class]' => $model->formName(),
                'ImageManager[item_id]' => $model->id,
            ],
            'maxFileCount' => 10
        ],
        'pluginEvents' => [
            'filesorted' => new \yii\web\JsExpression('function(event, params) {
                $.post("'.Url::toRoute(["/blog/sort-image",
                    "id"=>$model->id]).'",{sort: params});
            }')
        ],
    ]) ?>
</div>
