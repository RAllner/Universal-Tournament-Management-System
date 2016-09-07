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
            <ul class="nav nav-pills">
                <li role="event_nav"
                    <?php if ($_GET['filter'] == 0): ?>
                        class="active"
                    <?php endif ?>
                ><a
                        href="<?= Url::to(['index', 'filter' => 0]) ?>"><?= Yii::t('app', 'Comming') ?><span
                            class="pull-right badge"><?= $commingCount ?></span></a>
                </li>
                <li role="event_nav"
                    <?php if ($_GET['filter'] == 1): ?>
                        class="active"
                    <?php endif ?>
                ><a
                        href="<?= Url::to(['index', 'filter' => 1]) ?>"><?= Yii::t('app', 'Running') ?> <span
                            class="pull-right badge"><?= $runningCount ?></span></a>
                </li>
                <li role="event_nav"
                    <?php if ($_GET['filter'] == 2): ?>
                        class="active"
                    <?php endif ?>
                ><a
                        href="<?= Url::to(['index', 'filter' => 2]) ?>"><?= Yii::t('app', 'Past') ?><span
                            class="pull-right badge"><?= $pastCount ?></span></a>
                </li>
                <li role="event_nav"
                    <?php if ($_GET['filter'] == 3): ?>
                        class="active"
                    <?php endif ?>
                ><a
                        href="<?= Url::to(['index', 'filter' => 3]) ?>"><?= Yii::t('app', 'All') ?><span
                            class="pull-right badge"><?= $allCount ?></span></a>
                </li>

            </ul>

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
