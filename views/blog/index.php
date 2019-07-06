<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use pttrulez\blog\models\Blog;

/* @var $this yii\web\View */
/* @var $searchModel pttrulez\blog\models\BlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blogs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-index">


    <p>
        <?= Html::a('Create Blog', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            // 'text:ntext',
            ['attribute'=>'url', 'format'=>'text', 'headerOptions'=>['class'=>'sdasd']],
            ['attribute'=>'status_id','filter'=> Blog::STATUS_LIST, 'value'=>'statusName'],
            'sort',
            ['attribute'=>'tags', 'value'=>'tagsAsString'],
            'smallImage:image',
            'date_create:datetime',
            'date_update:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {check}',
                'buttons' => [
                    'check'=>function($url, $model, $key){
                        return Html::a('<i class="fa fa-check"></i>', $url);
                    }
                ],
                'visibleButtons' => [
                    'check'=>function($model, $key, $index){
                        return ($model->status_id == 0)?false:true;
                    }
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
