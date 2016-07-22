<?php

use frontend\models\Tournament;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ParticipantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$tournament = Tournament::find()->where(['id' => $_GET['tournament_id']])->one();
$this->title = $tournament->name. " ". Yii::t('app', 'Standings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tournaments'), 'url' => ['tournament/index']];
$this->params['breadcrumbs'][] = ['label' => $tournament->name, 'url' => ['tournament/view', 'id' => $tournament->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participant-standings">

    <h1><?= Html::encode($this->title);
        ?>
        <div class="pull-right">

            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['tournament/index'], ['class' => 'btn btn-default']) ?>
        </div>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked">
                <li role="tournament_nav"><a
                        href="<?= Url::to(['tournament/view', 'id' => $tournament->id]) ?>"><?= Yii::t('app', 'Information') ?></a>
                </li>
                <?php if($tournament->stage_type == 1  && $tournament->status > 2): ?>
                    <li role="tournament_nav"><a href="<?= Url::to(['tournament/group-stage', 'id' => $tournament->id])?>"><?= Yii::t('app', 'Group Stage') ?></a></li>
                    <li role="tournament_nav"><a href="<?= Url::to(['tournament/stage', 'id' => $tournament->id])?>"><?= Yii::t('app', 'Final Stage') ?></a></li>
                <?php endif ?>
                <?php if($tournament->stage_type == 0  && $tournament->status > 2): ?>
                    <li role="tournament_nav"><a href="<?= Url::to(['tournament/stage', 'id' => $tournament->id])?>"><?= Yii::t('app', 'Tree') ?></a></li>
                <?php endif ?>
                <li role="tournament_nav" class="active"><a href="#"><?= Yii::t('app', 'Standings')?></a></li>
                <li role="tournament_nav"><a href="<?= Url::to(['index', 'tournament_id' => $tournament->id]) ?>"><?= Yii::t('app', 'Participants')?></a>
                <li role="tournament_nav"><a href="<?= Url::to(['tournament/update', 'id' => $tournament->id])?>">Settings</a></li>
            </ul>
            <?php if($tournament->status === 1): ?>
                <?= Html::a('<i class="material-icons">publish</i> ' . Yii::t('app', 'Publish'), ['tournament/publish', 'id' => $tournament->id], ['class' => 'btn btn-block btn-success']) ?>
            <?php endif ?>
            <?php if ($tournament->status < 3 && $tournament->status !== 1): ?>

                <?= Html::a('<i class="material-icons">play_arrow</i> ' . Yii::t('app', 'Start'), ['tournament/start', 'id' => $tournament->id], ['class' => 'btn btn-block btn-warning']) ?>
            <?php endif ?>
            <?php if (Yii::$app->user->can('updateTournament') && $tournament->status >=3 && $tournament->status <=4): ?>
                <?= Html::a(Yii::t('app', 'Abort'), ['tournament/abort', 'id' => $tournament->id], [
                    'class' => 'btn btn-block btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to abort this tournament?'),
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a(Yii::t('app', 'Reset'), ['tournament/reset', 'id' => $tournament->id], [
                    'class' => 'btn btn-block btn-default',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to reset this tournament?'),
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif ?>
        </div>
        <div class="col-md-10">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'tournament_id',
                    'name',
                    'rank',
                    // 'removed',
                    // 'on_waiting_list',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
