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

$participant_A = Participant::find()->where(['id' => $model->participant_id_A])->one();
/** @var Participant $participant_A */
if (isset($participant_A)) {
    $participant_A_Name = $participant_A->name;
} else {
    $tmpArray = explode(',', $model->qualification_match_ids);
    if ($tmpArray[0] != "0" && $model->losers_round == 0) {
        $participant_A_Name = Yii::t('app', 'Winner of') . " " . $tmpArray[0];
    } else if ($tmpArray[0] != "0" && $model->losers_round == 1) {
        $participant_A_Name = Yii::t('app', 'Loser of') . " " . $tmpArray[0];
    } else {
        $participant_A_Name = "";
    }
}
$participant_B = Participant::find()->where(['id' => $model->participant_id_B])->one();
/** @var Participant $participant_B */
if (isset($participant_B)) {
    $participant_B_Name = $participant_B->name;
} else {
    $tmpArray = explode(',', $model->qualification_match_ids);
    if (count($tmpArray) > 1 && $model->losers_round == 0) {
        $participant_B_Name = Yii::t('app', 'Winner of') . " " . $tmpArray[1];
    } else if (count($tmpArray) > 1 && $model->losers_round == 1) {
        $participant_B_Name = Yii::t('app', 'Loser of') . " " . $tmpArray[1];
    } else {
        $participant_B_Name = "";
    }
}
/* @var $tournament frontend\models\Tournament */
$tournament = Tournament::find()->where(['id' => $model->tournament_id])->one();

$script =
    <<< JS
            $(document).ready(function(){
$(':checkbox').on('change', function () {
         var targetID = $(this).data('target');
             
         if($(this).parents('.selected').length){
                $(':checkbox').closest('div').removeClass('selected');
                 $('.field-tournamentmatch-winner_id-'+targetID+'> input').val("");
                 $('.field-tournamentmatch-loser_id-'+targetID+'> input').val("");
         } else {
                $(':checkbox').not(this).closest('div').removeClass('selected');
                $(':checkbox').not(this).closest('div').addClass('unselected'); 
                $(this).closest('div').addClass('selected');
                $(this).closest('div').removeClass('unselected');
                $('.field-tournamentmatch-winner_id-'+targetID+'> input').val($(this).val());
                $('.field-tournamentmatch-loser_id-'+targetID+'> input').val($(this).closest('div.match-winner').find('.fake-button.unselected input').val());
                
        }
});


$('.set-add').on('click', function() {
    var targetID = $(this).data('target');
    var setCount = $('input.setCount'+targetID).val();
    if(setCount == 1){
        $('.set-remove'+targetID).removeClass('hidden');
        $('.set-remove'+targetID).show();
    } 
        setCount++;
        $('div.setsA'+targetID).prepend('<label class="set-points form-control additionalSetA'+ targetID + setCount +'">'+'<input type="number" name="A" min="0" value="0"></label>');
        $('div.setsB'+targetID).prepend('<label class="set-points form-control additionalSetB'+ targetID + setCount +'">'+'<input type="number" name="B" min="0" value="0"></label>');
        

    $('input.setCount'+targetID).val(""+setCount);
})

$('.set-remove').on('click', function() {
    var targetID = $(this).data('target');
    var setCount = $('input.setCount'+targetID).val();
    alert(setCount);

    $('label.set-points.form-control.additionalSetA'+ targetID + setCount).remove();
    $('label.set-points.form-control.additionalSetB'+ targetID + setCount).remove();
    setCount--
    if(setCount == "1"){
        $(this).hide();
    }
    $('input.setCount'+targetID).val(""+setCount);
});

$('.report-match').on('click', function() {
   var targetID = $(this).data('target');
   var setCount = $('input.setCount'+targetID).val();
   var scoreCSV = "";
   var scoreMatches_A = "0";
   var scoreMatches_B = "0";
   for(i=1;i<= setCount; i++){
        var i_string = i.toString();
        var scoreA = $('.additionalSetA'+ targetID + i_string +' > input').val();
        var scoreB = $('.additionalSetB'+ targetID + i_string +' > input').val();
        if(scoreA > scoreB){
            scoreMatches_A++;
        } else if(scoreB > scoreA){
            scoreMatches_B++;
        }
        if(i == 1){
        scoreCSV = scoreCSV+scoreA+'-'+scoreB;
        } else {
        scoreCSV = scoreCSV+','+scoreA+'-'+scoreB;
        }
   }
   $('.field-tournamentmatch-participant_score_A-'+targetID+'> input').val(scoreMatches_A);
   $('.field-tournamentmatch-participant_score_B-'+targetID+'> input').val(scoreMatches_B);
   $('.field-tournamentmatch-scores-'+targetID+'> input').val(scoreCSV);
   $('form#'+targetID).submit();
});

}); 
JS;
$this->registerJs($script, View::POS_END);

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
        <?= $model->participant_score_A ?>
    </td>
    <td <?= $winnerB ?>>
        <?= $model->participant_score_B ?>
    </td>
    <td <?= $winnerB ?>>
        <?= $participant_B_Name ?>
    </td>
    <!-- Button trigger modal -->
    <?php if($tournament->status != Tournament::STATUS_FINISHED): ?>
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

<div class="modal fade match" id="myModal<?= $model->id ?>" tabindex="-1" role="dialog"
     aria-labelledby="match<?= $model->id ?>Modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h2 class="modal-title" id="myModalLabel"><?= Yii::t('app', 'Match') . ' ' . $model->matchID ?></h2>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'action' => ['tournament/report-match', 'id' => $model->id],
                    'options' => [
                        'id' => $model->id,
                    ]]); ?>

                <div class="col-xs-12">
                    <h3><?= Yii::t('app', 'Winner') ?></h3>
                    <div class="row">
                        <div class="col-xs-12 center">
                            <div class="match-winner">
                                <div class="fake-button<?php if ($model->winner_id == $model->participant_id_A) {
                                    echo ' selected';
                                } ?>">
                                    <label class="checkbox-inline match-winner"><input type="checkbox"
                                                                                       name="match-winner"
                                                                                       value="<?= $model->participant_id_A ?>"
                                                                                       data-target="<?= $model->id ?>"
                                        ><?= $participant_A_Name ?>

                                    </label>

                                </div>
                                <div class="fake-button<?php if ($model->winner_id == $model->participant_id_B) {
                                    echo ' selected';
                                } ?>">
                                    <label class="checkbox-inline match-winner"><input type="checkbox"
                                                                                       name="match-winner"
                                                                                       value="<?= $model->participant_id_B ?>"
                                                                                       data-target="<?= $model->id ?>"
                                        ><?= $participant_B_Name ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <hr>
                <div class="col-xs-12">
                    <?php if ($model->tournament->has_sets): ?>
                        <div class="pull-right">
                            <div
                                class="btn btn-warning btn-xs set-remove set-remove<?= $model->id ?> <?php if (count(explode(',', $model->scores)) == 1) echo 'hidden' ?>"
                                data-target="<?= $model->id ?>">-
                            </div>
                            <div class="btn btn-success btn-xs set-add" data-target="<?= $model->id ?>">+</div>
                        </div>
                    <?php endif ?>
                    <h3><?= Yii::t('app', 'Scores') ?>
                    </h3>
                    <div class="clearfix"></div>
                    <div class="scores">
                        <div class="row score-row A">
                            <h3><?= $participant_A_Name ?></h3>
                            <div class="setsA<?= $model->id ?>" style="display: inline">
                                <?php for ($i = count(explode(',', $model->scores)); $i >= 1; $i--) {
                                    echo '<label class="set-points form-control additionalSetA' . $model->id . $i . '">' . '<input type="number" name="A" min="0" value="' . explode('-', (explode(',', $model->scores)[$i - 1]))[0] . '"></label>';

                                }
                                ?>
                            </div>
                        </div>
                        <div class="row score-row B">
                            <h3><?= $participant_B_Name ?></h3>
                            <div class="setsA<?= $model->id ?>" style="display: inline">
                                <?php for ($i = count(explode(',', $model->scores)); $i >= 1; $i--) {
                                    echo '<label class="set-points form-control additionalSetB' . $model->id . $i . '">' . '<input type="number" name="B" min="0" value="' . explode('-', (explode(',', $model->scores)[$i - 1]))[1] . '"></label>';
                                }
                                ?>
                            </div>
                        </div>
                        <input class="setCount<?= $model->id ?>" type="hidden" name="setCount"
                               value="<?= count(explode(',', $model->scores)) ?>">
                    </div>
                </div>


                <?= $form->field($model, 'winner_id')->textInput(['id' => 'tournamentmatch-winner_id-' . $model->id])->hiddenInput()->label(false) ?>
                <?= $form->field($model, 'loser_id')->textInput(['id' => 'tournamentmatch-loser_id-' . $model->id])->hiddenInput()->label(false) ?>
                <?= $form->field($model, 'participant_score_A')->textInput(['id' => 'tournamentmatch-participant_score_A-' . $model->id])->hiddenInput()->label(false) ?>
                <?= $form->field($model, 'participant_score_B')->textInput(['id' => 'tournamentmatch-participant_score_B-' . $model->id])->hiddenInput()->label(false) ?>
                <?= $form->field($model, 'scores')->textInput(['id' => 'tournamentmatch-scores-' . $model->id])->hiddenInput()->label(false) ?>


                <div class="clearfix"></div>
                <button type="button" class="btn btn-primary report-match"
                        data-target="<?= $model->id ?>"><?= Yii::t('app', 'Report') ?></button>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>