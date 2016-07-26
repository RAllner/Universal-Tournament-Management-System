<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TournamentMatchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tournament Matches');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tournament-match-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Tournament Match'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'tournament_id',
            'stage',
            'matchID',
            'groupID',
            // 'round',
            // 'participant_id_A',
            // 'participant_score_A',
            // 'participant_id_B',
            // 'participant_score_B',
            // 'winner_id',
            // 'loser_id',
            // 'updated_at',
            // 'created_at',
            // 'begin_at',
            // 'finished_at',
            // 'metablob',
            // 'state',
            // 'follow_winner_and_loser_match_ids',
            // 'qualification_match_ids',
            // 'losers_round',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
