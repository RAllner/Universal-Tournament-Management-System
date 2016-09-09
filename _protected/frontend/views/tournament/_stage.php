<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 22.07.2016
 * Time: 12:26
 */

/* @var $this yii\web\View */
/* @var $model frontend\models\TournamentMatch */
/* @var $stage integer */


use frontend\models\Participant;

use frontend\models\Tournament;
use frontend\models\TournamentMatch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

$names = $model->getParticipantNames();
$participant_A_Name = $names["A"];
$participant_B_Name = $names["B"];
/* @var $tournament frontend\models\Tournament */
$tournament = Tournament::find()->where(['id' => $model->tournament_id])->one();

$finished = ($model->state == TournamentMatch::MATCH_STATE_FINISHED) ? "class='finished-match'" : "";
$running = ($model->state == TournamentMatch::MATCH_STATE_RUNNING) ? "class='running-match'" : "";
$winnerA = ($model->winner_id == $model->participant_id_A && $model->state == TournamentMatch::MATCH_STATE_FINISHED) ? "class='winner-match'" : "";
$winnerB = ($model->winner_id == $model->participant_id_B && $model->state == TournamentMatch::MATCH_STATE_FINISHED) ? "class='winner-match'" : "";

?>
<tr <?= $finished . $running ?>>
    <td>
        <?= $model->matchID ?>
    </td>
    <?php if ($stage == Tournament::STAGE_GS): ?>
    <td>
        <?= $model->groupID ?>
    </td>
    <?php endif ?>
    <td>
        <?= $model->getRoundName($model->round, $tournament, $model->losers_round) ?>
    </td>
    <td <?= $winnerA ?>>
        <?= $participant_A_Name ?>
    </td>
    <td <?= $winnerA ?>>
        <?php foreach (explode(',',$model->scores) as $score){
            echo $score . "</br>";
        } ?>
    </td>
    <td <?= $winnerB ?>>
        <?= $participant_B_Name ?>
    </td>
    <td>
        <?= $model->getStateName($model->state) ?>
    </td>
    <!-- Button trigger modal -->
    <?php if(($stage == Tournament::STAGE_FS && $tournament->status != Tournament::STATUS_FINISHED) || ($stage == Tournament::STAGE_GS && $tournament->status < Tournament::STATUS_GS_COMPLETE)): ?>
        <td>
            <?php if ($model->state == TournamentMatch::MATCH_STATE_READY): ?>
                <a data-toggle="modal"
                   data-target="#myModal<?= $model->id ?>">
                    <i class="material-icons">edit</i>
                </a>
            <?php endif ?>
            <?php if ($model->state == TournamentMatch::MATCH_STATE_READY || $model->state == TournamentMatch::MATCH_STATE_RUNNING): ?>
                <?= Html::a(($model->state == TournamentMatch::MATCH_STATE_READY) ? '<i class="material-icons">play_arrow</i>' : '<i class="material-icons">pause</i>', Url::to(['/tournament/match-running', 'id' => $model->tournament_id, 'match_id' => $model->id])) ?>
            <?php endif ?>
            <?php if ($model->state == TournamentMatch::MATCH_STATE_FINISHED): ?>
                <?= Html::a('<i class="material-icons">undo</i>', Url::to(['@web/tournament/match-undo', 'id' => $model->tournament_id, 'match_id' => $model->id])) ?>
            <?php endif ?>
        </td>
    <?php endif ?>
    <!-- Modal -->
</tr>
