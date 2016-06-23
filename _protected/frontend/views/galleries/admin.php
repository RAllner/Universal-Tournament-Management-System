<?php
use common\helpers\CssHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\GalleriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Galleries');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="articles-admin">

    <h1><?= 'Admin '.Html::encode($this->title) ?>
    <span class="pull-right">
        <?= Html::a('<i class="material-icons">create</i> '.Yii::t('app', 'Create Gallery'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-warning']) ?>
    </span>  
    </h1>
    <div class="clearfix"></div>
    <div class="col-lg-12 well bs-component">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            // author
            [
                'attribute'=>'user_id',
                'value' => function ($data) {
                    return $data->getAuthorName();
                },
            ],
            'title',
            // status
            [
                'attribute'=>'status',
                'filter' => $searchModel->statusList,
                'value' => function ($data) {
                    return $data->getStatusName($data->status);
                },
                'contentOptions'=>function($model, $key, $index, $column) {
                    return ['class'=>CssHelper::generalStatusCss($model->statusName)];
                }
            ],
            [
                'attribute'=>'category',
                'filter' => $searchModel->categoryList,
                'value' => function ($data) {
                    return $data->getCategoryName($data->category);
                },
                'contentOptions'=>function($model, $key, $index, $column) {
                    return ['class'=>CssHelper::generalCategoryCss($model->categoryName)];
                }
            ],

            ['class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Menu'),
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('', $url, ['title'=>Yii::t('app', 'View gallery'),
                            'class'=>'glyphicon glyphicon-eye-open']);
                    },
                    'update' => function ($url, $model, $key) {
                        if(Yii::$app->user->can('updateGallery', ['model' => $model])){
                            return Html::a('', $url, ['title'=>Yii::t('app', 'Update gallery'),
                                'class'=>'glyphicon glyphicon-pencil']);
                        } else return "";
                    },
                    'delete' => function ($url, $model, $key) {
                        if(Yii::$app->user->can('deleteGallery', ['model' => $model])) {
                            return Html::a('', $url,
                                ['title' => Yii::t('app', 'Delete gallery'),
                                    'class' => 'glyphicon glyphicon-trash',
                                    'data' => [
                                        'confirm' => Yii::t('app', 'Are you sure you want to delete this gallery?'),
                                        'method' => 'post']
                                ]);
                        }else return "";
                    }
                ]
            ]
        ],
    ]); ?>

</div>
</div>