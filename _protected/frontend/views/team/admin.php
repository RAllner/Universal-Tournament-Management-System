<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TeamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Admin');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Team'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-admin">

    <h1>

    <?= 'Admin '.Html::encode($this->title) ?>

    <span class="pull-right">
        <?= Html::a('<i class="material-icons">create</i> '.Yii::t('app', 'Create Team'), ['create'], ['class' => 'btn btn-success']) ?>
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
            'header' => Yii::t('app', 'Menu')],
        ],
    ]); ?>

</div>
</div>