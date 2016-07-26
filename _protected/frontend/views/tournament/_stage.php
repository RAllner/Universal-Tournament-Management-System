<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 22.07.2016
 * Time: 12:26
 */

/* @var $this yii\web\View */
/* @var $model frontend\models\TournamentMatch */
/* @var $tournament frontend\models\Tournament */

use frontend\models\Participant;

use frontend\models\TournamentMatch;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$participant_A = Participant::find()->where(['id' => $model->participant_id_A])->one();
/** @var Participant $participant_A */
if (isset($participant_A)) {
    $participant_A_Name = $participant_A->name;
} else {
    $tmpArray = explode(',', $model->qualification_match_ids);
    if ($tmpArray[0] != "0") {
        $participant_A_Name = Yii::t('app', 'Winner of') . " " . $tmpArray[0];
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
    if (isset($tmpArray[1])) {
        $participant_B_Name = Yii::t('app', 'Winner of') . " " . $tmpArray[1];
    } else {
        $participant_B_Name = "";
    }
}

$script =
    <<< JS
            $(document).ready(function(){
$(':checkbox').on('change', function () {
         var targetID = $(this).data('target');
             
         if($(this).parents('.selected').length){
                $(':checkbox').closest('div').removeClass('selected');
                 $('.field-tournamentmatch-winner_id-'+targetID+'> input').val(undefined);
         } else {
                $(':checkbox').not(this).closest('div').removeClass('selected');    
                $(this).closest('div').addClass('selected');
                $('.field-tournamentmatch-winner_id-'+targetID+'> input').val($(this).val());
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
        $('div.setsA'+targetID).append('<label class="set-points form-control additionalSetA'+ targetID + setCount +'">'+'<input type="number" name="A" min="0" value="0"></label>');
        $('div.setsB'+targetID).append('<label class="set-points form-control additionalSetB'+ targetID + setCount +'">'+'<input type="number" name="B" min="0" value="0"></label>');
    

    $('input.setCount'+targetID).val(""+setCount);
})

$('.set-remove').on('click', function() {
    var targetID = $(this).data('target');
    var setCount = $('input.setCount'+targetID).val();

    $('label.set-points.form-control.additionalSetA'+ targetID + setCount).remove();
    $('label.set-points.form-control.additionalSetB'+ targetID + setCount).remove();
            setCount--;
    if(setCount == "1"){
        $('.set-remove#'+targetID).hide();
    }

    $('input.setCount'+targetID).val(""+setCount);
});

$('.report-match').on('click', function() {
   var targetID = $(this).data('target');
   var setCount = $('input.setCount'+targetID).val();
   var scoreCSV = "";
   for(i=1;i<= setCount; i++){
        var i_string = i.toString();
        var scoreA = $('.additionalSetA'+ targetID + i_string +' > input').val();
        var scoreB = $('.additionalSetB'+ targetID + i_string +' > input').val();
        if(i == 1){
        scoreCSV = scoreCSV+scoreA+'-'+scoreB;
        } else {
        scoreCSV = scoreCSV+','+scoreA+'-'+scoreB;
        }
   }        
           $('.field-tournamentmatch-scores-'+targetID+'> input').val(scoreCSV);
  $('form#'+targetID).submit();
});

}); 
JS;
$this->registerJs($script, View::POS_END);
?>
<tr>
    <td>
        <?= $model->matchID ?>
    </td>
    <td>
        <?= $participant_A_Name ?>
    </td>
    <td>
        <?= $model->participant_score_A ?>
    </td>
    <td>
        <?= $model->participant_score_B ?>
    </td>
    <td>
        <?= $participant_B_Name ?>
    </td>
    <td>
        <?= $model->state ?>
    </td>
    <!-- Button trigger modal -->
    <td>
        <?php if ($model->state >= TournamentMatch::MATCH_STATE_READY): ?>
            <button type="button" class="btn btn-primary btn-lg open-match-modal" data-toggle="modal"
                    data-target="#myModal<?= $model->id ?>">
                <i class="material-icons">edit</i>
            </button>
        <?php endif ?>
    </td>

    <!-- Modal -->

</tr>

<div class="modal fade match" id="myModal<?= $model->id ?>" tabindex="-1" role="dialog"
     aria-labelledby="match<?= $model->id ?>Modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= Yii::t('app', 'Match') . ' ' . $model->matchID ?></h4>
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
                                class="btn btn-warning btn-xs set-remove<?= $model->id ?> <?php if (count(explode(',', $model->scores)) == 1) echo 'hidden' ?>"
                                data-target="<?= $model->id ?>">-
                            </div>
                            <div class="btn btn-success btn-xs set-add" data-target="<?= $model->id ?>">+</div>
                        </div>
                    <?php endif ?>
                    <h3><?= Yii::t('app', 'Scores') ?>
                    </h3>
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

                <?= $form->field($model, 'participant_score_A')->textInput()->hiddenInput()->label(false) ?>

                <?= $form->field($model, 'participant_score_B')->textInput()->hiddenInput()->label(false) ?>
                <?= $form->field($model, 'scores')->textInput(['id' => 'tournamentmatch-scores-' . $model->id])->hiddenInput()->label(false) ?>


                <div class="clearfix"></div>
                <button type="button" class="btn btn-primary report-match"
                        data-target="<?= $model->id ?>"><?= Yii::t('app', 'Report') ?></button>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>