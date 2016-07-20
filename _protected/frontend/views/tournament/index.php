<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TournamentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tournaments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tournament-index">

    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">
        <?php if (Yii::$app->user->can('premium')): ?>
            <?= Html::a('<i class="material-icons">create</i> ' . Yii::t('app', 'Create Tournament'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif ?>
        <?php if (Yii::$app->user->can('premium')): ?>
            <?= Html::a(Yii::t('app', 'Admin'), ['admin'], ['class' => 'btn btn-warning']) ?>
        <?php endif ?>
            </span>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked">

                    <li role="tournament_nav"
                        <?php if($_GET['filter']==0): ?>
                            class="active"
                        <?php endif ?>
                    ><a
                            href="<?= Url::to(['index', 'filter' => 0]) ?>"><?= Yii::t('app', 'Comming') ?></a>
                    </li>
                    <li role="tournament_nav"
                        <?php if($_GET['filter']==1): ?>
                            class="active"
                        <?php endif ?>
                    ><a
                        href="<?= Url::to(['index', 'filter' => 1]) ?>"><?= Yii::t('app', 'Running') ?></a>
                    </li>
                    <li role="tournament_nav"
                        <?php if($_GET['filter']==2): ?>
                            class="active"
                        <?php endif ?>
                    ><a
                            href="<?= Url::to(['index', 'filter' => 2]) ?>"><?= Yii::t('app', 'Past') ?></a>
                    </li>

            </ul>

        </div>
        <div class="col-md-10">
            <div class="well">
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
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
    </div>
</div>
