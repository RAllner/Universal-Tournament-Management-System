<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;


/* @var $this yii\web\View */
/* @var $searchModel frontend\models\EventsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $allCount integer */
/* @var $commingCount integer */
/* @var $runningCount integer */
/* @var $pastCount integer */

$this->title = Yii::t('app', 'Events');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="events-index">
<span class="pull-right">


    <?php if (Yii::$app->user->can('createEventsAndLocations')): ?>
        <?= Html::a('<i class="material-icons">create</i> ' . Yii::t('app', 'Create Event'), ['create'], ['class' => 'btn btn-success']) ?>
    <?php endif ?>
    <?php if (Yii::$app->user->can('adminEventsAndLocations')): ?>

        <?= Html::a(Yii::t('app', 'Admin'), ['admin'], ['class' => 'btn btn-warning']) ?>

    <?php endif ?>
            </span>
    <h1><?= Html::encode($this->title) ?>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-10 col-xs-12">
            <?= ListView::widget([
                'summary' => false,
                'dataProvider' => $dataProvider,
                'emptyText' => Yii::t('app', 'We haven\'t added any events yet.'),
                'itemOptions' => ['class' => 'item'],
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_index', ['model' => $model]);
                },
            ]) ?>
        </div>
        <div class="col-md-2">
            <ul class="nav nav-pills">
                <li class="tournament-nav-pills <?php if ($_GET['filter'] == 0): ?>
                        active
                    <?php endif ?>"

                ><a
                        href="<?= Url::to(['index', 'filter' => 0]) ?>"><span
                            class="pull-right badge"><?= $commingCount ?></span> <?= Yii::t('app', 'Comming') ?></a>
                </li>
                <li class="tournament-nav-pills <?php if ($_GET['filter'] == 1): ?>
                        active
                    <?php endif ?>"
                ><a
                        href="<?= Url::to(['index', 'filter' => 1]) ?>"><span
                            class="pull-right badge"><?= $runningCount ?></span> <?= Yii::t('app', 'Running') ?> </a>
                </li>
                <li class="tournament-nav-pills <?php if ($_GET['filter'] == 2): ?>
                        active
                    <?php endif ?>"
                ><a
                        href="<?= Url::to(['index', 'filter' => 2]) ?>"><?= Yii::t('app', 'Past') ?><span
                            class="pull-right badge"><?= $pastCount ?></span></a>
                </li>
                <li class="tournament-nav-pills <?php if ($_GET['filter'] == 3): ?>
                        active
                    <?php endif ?>"
                ><a
                        href="<?= Url::to(['index', 'filter' => 3]) ?>"><?= Yii::t('app', 'All') ?><span
                            class="pull-right badge"><?= $allCount ?></span></a>
                </li>

            </ul>
        </div>
    </div>
</div>
