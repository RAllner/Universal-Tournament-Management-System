<?php
use common\helpers\CssHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VideosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Videos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Videos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="videos-admin">

    <h1>

    <?= Html::encode($this->title) ?>

    <span class="pull-right">
        <?= Html::a(Yii::t('app', 'Show Videos'), ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Add Videos'), ['create'], ['class' => 'btn btn-success']) ?>
    </span>  

    </h1>
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
            'title',
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
            'header' => Yii::t('app', 'Menu')],
        ],
    ]); ?>

</div>
</div>