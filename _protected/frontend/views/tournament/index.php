<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TournamentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $allCount integer */
/* @var $commingCount integer */
/* @var $runningCount integer */
/* @var $pastCount integer */

$this->title = Yii::t('app', 'Tournaments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tournament-index">
<span class="pull-right">

    <?php if (Yii::$app->user->can('premium')): ?>
        <?= Html::a('<i class="material-icons">create</i> ' . Yii::t('app', 'Create Tournament'), ['create'], ['class' => 'btn btn-success']) ?>
    <?php endif ?>
            </span>
    <h1><?= Html::encode($this->title) ?></h1>


    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-10">
            <div class="well">
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>

        </div>
    </div>
    <div class="row">
    <div class="col-xs-12 hidden-lg" style="margin-bottom: 1em">
        <ul class="nav nav-pills nav-justified">
            <li class="tournament-nav-pills <?php if ($_GET['filter'] == 0): ?>
                        active
                    <?php endif ?>"

            ><a
                    href="<?= Url::to(['index', 'filter' => 0]) ?>"><span
                        class="pull-right badge"><?= $allCount ?></span> <?= Yii::t('app', 'Open') ?></a>
            </li>
            <li class="tournament-nav-pills <?php if ($_GET['filter'] == 1): ?>
                        active
                    <?php endif ?>"
            ><a
                    href="<?= Url::to(['index', 'filter' => 1]) ?>"><?= Yii::t('app', 'Running') ?><span
                        class="pull-right badge"><?= $runningCount ?></span></a>
            </li>
            <li class="tournament-nav-pills <?php if ($_GET['filter'] == 2): ?>
                        active
                    <?php endif ?>"
            ><a
                    href="<?= Url::to(['index', 'filter' => 2]) ?>"><span
                        class="pull-right badge"><?= $commingCount ?></span> <?= Yii::t('app', 'Comming') ?> </a>
            </li>
            <li class="tournament-nav-pills <?php if ($_GET['filter'] == 3): ?>
                        active
                    <?php endif ?>"
            ><a
                    href="<?= Url::to(['index', 'filter' => 3]) ?>"><?= Yii::t('app', 'Finished') ?><span
                        class="pull-right badge"><?= $pastCount ?></span></a>
            </li>
            <li class="tournament-nav-pills <?php if ($_GET['filter'] == 4): ?>
                        active
                    <?php endif ?>"

            ><a
                    href="<?= Url::to(['index', 'filter' => 4]) ?>"><span
                        class="pull-right badge"><?= $allCount ?></span> <?= Yii::t('app', 'All') ?></a>
            </li>
        </ul>
    </div>

    </div>

    <div class="row">
        <div class="col-lg-10 col-md-12">

            <?= ListView::widget([
                'summary' => false,
                'dataProvider' => $dataProvider,
                'emptyText' => '<div class="row"><div class="col-lg-12"><div class="well">' . Yii::t('app', 'We haven\'t created any Tournaments yet.') . '</div></div></div>',
                'itemOptions' => ['class' => 'item'],
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_index', ['model' => $model]);
                },
            ]) ?>
        </div>
        <div class="col-lg-2 hidden-md">
            <ul class="nav nav-pills">
                <li class="tournament-nav-pills <?php if ($_GET['filter'] == 0): ?>
                        active
                    <?php endif ?>"

                ><a
                        href="<?= Url::to(['index', 'filter' => 0]) ?>"><span
                            class="pull-right badge"><?= $allCount ?></span> <?= Yii::t('app', 'Open') ?></a>
                </li>
                <li class="tournament-nav-pills <?php if ($_GET['filter'] == 1): ?>
                        active
                    <?php endif ?>"
                ><a
                        href="<?= Url::to(['index', 'filter' => 1]) ?>"><?= Yii::t('app', 'Running') ?><span
                            class="pull-right badge"><?= $runningCount ?></span></a>
                </li>
                <li class="tournament-nav-pills <?php if ($_GET['filter'] == 2): ?>
                        active
                    <?php endif ?>"
                ><a
                        href="<?= Url::to(['index', 'filter' => 2]) ?>"><span
                            class="pull-right badge"><?= $commingCount ?></span> <?= Yii::t('app', 'Comming') ?> </a>
                </li>
                <li class="tournament-nav-pills <?php if ($_GET['filter'] == 3): ?>
                        active
                    <?php endif ?>"
                ><a
                        href="<?= Url::to(['index', 'filter' => 3]) ?>"><?= Yii::t('app', 'Finished') ?><span
                            class="pull-right badge"><?= $pastCount ?></span></a>
                </li>
                <li class="tournament-nav-pills <?php if ($_GET['filter'] == 4): ?>
                        active
                    <?php endif ?>"

                ><a
                        href="<?= Url::to(['index', 'filter' => 4]) ?>"><span
                            class="pull-right badge"><?= $allCount ?></span> <?= Yii::t('app', 'All') ?></a>
                </li>
            </ul>
        </div>
    </div>
</div>
