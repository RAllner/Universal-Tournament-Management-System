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
            <?php if (Yii::$app->user->can('member')): ?>
                <?= Html::a('<i class="material-icons">add</i> ' . Yii::t('app', 'Signup'), ['signup', 'tournament_id' => $tournament->id], ['class' => 'btn btn-info']) ?>
            <?php endif ?>
            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['tournament/index'], ['class' => 'btn btn-default']) ?>
        </div>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked">
                <?php if($tournament->stage_type == 1): ?>
                    <li role="tournament_nav"><a href="<?= Url::to(['tournament/view', 'id' => $tournament->id])?>"><?= Yii::t('app', 'Group Stage') ?></a></li>
                    <li role="tournament_nav"><a href="<?= Url::to(['tournament/view', 'id' => $tournament->id])?>"><?= Yii::t('app', 'Final Stage') ?></a></li>
                <?php endif ?>
                <?php if($tournament->stage_type == 0): ?>
                    <li role="tournament_nav"><a href="<?= Url::to(['tournament/view', 'id' => $tournament->id])?>"><?= Yii::t('app', 'Tree') ?></a></li>
                <?php endif ?>
                <li role="tournament_nav" class="active"><a href="#"><?= Yii::t('app', 'Standings')?></a></li>
                <li role="tournament_nav"><a href="<?= Url::to(['index', 'tournament_id' => $tournament->id]) ?>"><?= Yii::t('app', 'Participants')?></a>
                <li role="tournament_nav"><a href="<?= Url::to(['tournament/update', 'id' => $tournament->id])?>">Settings</a></li>
                <li role="tournament_nav"><a href="<?= Url::to(['signup', 'tournament_id' => $tournament->id]) ?>"><?= '<i class="material-icons">plus_one</i> ' .Yii::t('app', 'Signup') ?></a>
            </ul>

        </div>
        <div class="col-md-10">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'tournament_id',
                    'signup',
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
