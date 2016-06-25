<?php
use common\helpers\CssHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Admin');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Players'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-admin">

    <h1>

    <?= 'Admin '.Yii::t('app', 'Players') ?>
    <span class="pull-right">
        <?php if (Yii::$app->user->can('createPlayer')): ?>
        <?= Html::a('<i class="material-icons">create</i> '.Yii::t('app', 'Create Player'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif ?>
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
            'created_at:date',
            ['class' => 'yii\grid\ActionColumn',
            'header' => Yii::t('app', 'Menu')],
       ],
    ]); ?>

</div>
</div>