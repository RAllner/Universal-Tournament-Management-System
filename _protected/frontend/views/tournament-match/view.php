<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\TournamentMatch */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tournament Matches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tournament-match-view">

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
            'tournament_id',
            'stage',
            'matchID',
            'groupID',
            'round',
            'participant_id_A',
            'participant_score_A',
            'participant_id_B',
            'participant_score_B',
            'winner_id',
            'loser_id',
            'updated_at',
            'created_at',
            'begin_at',
            'finished_at',
            'metablob',
            'state',
            'follow_winner_and_loser_match_ids',
            'qualification_match_ids',
            'losers_round',
        ],
    ]) ?>

</div>
