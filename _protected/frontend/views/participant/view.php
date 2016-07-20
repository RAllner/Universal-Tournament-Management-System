<?php

use frontend\models\Tournament;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Participant */
$tournament = Tournament::find()->where(['id' => $model->tournament_id])->one();
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tournaments'), 'url' => ['tournament/index']];
$this->params['breadcrumbs'][] = ['label' => $tournament->name, 'url' => ['tournament/view', 'id' => $tournament->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participant-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'tournament_id',
                'value' => $model->getTournamentName(),
                'label' => Yii::t('app', 'Tournament name')
            ],
            'signup',
            'checked_in',
            'name',
            'seed',
            'updated_at',
            'created_at',
            'rank',
            [
                'attribute' => 'player_id',
                'value' => $model->getPlayerName(),
                'label' => Yii::t('app', 'Player name')
            ],
            [
                'attribute' => 'team_id',
                'value' => $model->getTeamName(),
                'label' => Yii::t('app', 'Team name')
            ],
            'removed',
            'on_waiting_list',
        ],
    ]) ?>

</div>
