<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PlayersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Players');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="players-index">

    <h1><?= Html::encode($this->title) ?>
        <div class="pull-right">
            <?php if (Yii::$app->user->can('adminArticle')): ?>
                <?= Html::a('<i class="material-icons">create</i> '.Yii::t('app', 'Create Player'), ['create'], ['class' => 'btn btn-success']) ?>
                <?= Html::a(Yii::t('app', 'Admin'), ['admin'], ['class' => 'btn btn-warning']) ?>
            <?php endif ?>
        </div>
    </h1>
    <div class="clearfix"></div>
 
        <?= ListView::widget([
            'summary' => false,
            'dataProvider' => $dataProvider,
            'emptyText' => Yii::t('app', 'We haven\'t added any player yet.'),
            'itemOptions' => ['class' => 'item'],
            'itemView' => function ($model, $key, $index, $widget) {
                return $this->render('_index', ['model' => $model]);
            },
        ]) ?>

</div>
