<?php

use yii\helpers\Html;
use yii\widgets\ListView;


/* @var $this yii\web\View */
/* @var $searchModel frontend\models\EventsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Events');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="events-index">

    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">

                    <?php if (Yii::$app->user->can('createEventsAndLocations')): ?>
                        <?= Html::a('<i class="material-icons">create</i> ' . Yii::t('app', 'Create Event'), ['create'], ['class' => 'btn btn-success']) ?>
                    <?php endif ?>
                    <?php if (Yii::$app->user->can('adminEventsAndLocations')): ?>

                        <?= Html::a(Yii::t('app', 'Admin'), ['admin'], ['class' => 'btn btn-warning']) ?>

                    <?php endif ?>
            </span>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-12">
            <?= ListView::widget([
                'summary' => false,
                'dataProvider' => $dataProvider,
                'emptyText' => Yii::t('app', 'We haven\'t added any Events yet.'),
                'itemOptions' => ['class' => 'item'],
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_index', ['model' => $model]);
                },
            ]) ?>
        </div>
    </div>
</div>
