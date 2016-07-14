<?php
use common\helpers\CssHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\LocationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Locations');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Locations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="location-admin">

    <h1>

    <?= 'Admin '.Html::encode($this->title) ?>

    <span class="pull-right">
        <?= Html::a('<i class="material-icons">create</i> '.Yii::t('app', 'Create Location'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['index'], ['class' => 'btn btn-default']) ?>

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


            [
                'attribute'=>'user_id',
                'value' => function ($data) {
                    return $data->getAuthorName();
                },
            ],
            'name',

            ['class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Menu'),
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('', $url, ['title'=>Yii::t('app', 'View location'),
                            'class'=>'glyphicon glyphicon-eye-open']);
                    },
                    'update' => function ($url, $model, $key) {
                        if(Yii::$app->user->can('updateEventsAndLocations', ['model' => $model])){
                            return Html::a('', $url, ['title'=>Yii::t('app', 'Update location'),
                                'class'=>'glyphicon glyphicon-pencil']);
                        } else return "";
                    },
                    'delete' => function ($url, $model, $key) {
                        if(Yii::$app->user->can('deleteEventsAndLocations', ['model' => $model])) {
                            return Html::a('', $url,
                                ['title' => Yii::t('app', 'Delete location'),
                                    'class' => 'glyphicon glyphicon-trash',
                                    'data' => [
                                        'confirm' => Yii::t('app', 'Are you sure you want to delete this article?'),
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