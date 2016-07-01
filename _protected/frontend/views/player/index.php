<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PlayerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $showAll boolean */

$this->title = Yii::t('app', 'Players');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="player-index">

    <h1><?= Html::encode($this->title) ?>
        <div class="pull-right">
            <?php if($showAll == false):?>
            <?= Html::a('<i class="material-icons">pageview</i> '.Yii::t('app', 'Show all'), ['index'], ['class' => 'btn btn-primary']) ?>
            <?php endif ?>
            <?php if($showAll == true):?>
                <?= Html::a('<i class="material-icons">pageview</i> '.Yii::t('app', 'Show mine'), ['own-index'], ['class' => 'btn btn-primary']) ?>
            <?php endif ?>
            <?php if (Yii::$app->user->can('createPlayer')): ?>
                <?= Html::a('<i class="material-icons">create</i> '.Yii::t('app', 'Create Player'), ['create'], ['class' => 'btn btn-success']) ?>
            <?php endif ?>
            <?php if (Yii::$app->user->can('adminPlayer')): ?>
                <?= Html::a(Yii::t('app', 'Admin'), ['admin'], ['class' => 'btn btn-warning']) ?>
            <?php endif ?>
        </div>
    </h1>
    <div class="col-lg-12 well bs-component">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <div class="clearfix"></div>
        <div class="row">
        <?= ListView::widget([
            'summary' => false,
            'dataProvider' => $dataProvider,
            'emptyText' => '<div class="col-lg-12"><div class="well">'.Yii::t('app', 'We haven\'t added any player yet.').'</div></div>',
            'itemOptions' => ['class' => 'item'],
            'itemView' => function ($model, $key, $index, $widget) {
                return $this->render('_index', ['model' => $model]);
            },
        ]) ?>
        </div>

</div>
