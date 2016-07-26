<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 22.07.2016
 * Time: 12:26
 */

/* @var $this yii\web\View */
/* @var $model frontend\models\TournamentMatch */


use frontend\models\Participant;
use frontend\models\Tournament;
use frontend\models\TournamentMatch;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

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
         if($(this).parents('.selected').length){
                $(':checkbox').closest('div').removeClass('selected');
                 $('#tournamentmatch-winner_id').val(0);
         } else {
                $(':checkbox').not(this).closest('div').removeClass('selected');    
                $(this).closest('div').addClass('selected');
                $('#tournamentmatch-winner_id').val($(this).val());
        }
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
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal<?= $model->matchID?>">
                <i class="material-icons">edit</i>
            </button>
        <?php endif ?>
    </td>

    <!-- Modal -->

</tr>

<div class="modal fade match" id="myModal<?= $model->matchID?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= Yii::t('app', 'Match') . ' ' . $model->matchID ?></h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(); ?>

                <div class="col-md-6 col-md-offset-3 center">
                    <h2><?= Yii::t('app','Winner') ?></h2>
                    <div class="match-winner">
                        <div class="fake-button">
                            <label class="checkbox-inline match-winner"><input type="checkbox"
                                                                            name="match-winner" value="<?= $model->participant_id_A ?>"><?= $participant_A_Name ?></label>
                        </div>
                        <div class="fake-button">
                            <label class="checkbox-inline match-winner"><input type="checkbox"
                                                                            name="match-winner" value="<?= $model->participant_id_B ?>"><?= $participant_B_Name ?></label>
                        </div>
                    </div>
                </div>
                <?= $form->field($model, 'winner_id')->textInput()->hiddenInput()->label(false) ?>

                <?= $form->field($model, 'participant_score_A')->textInput()->hiddenInput()->label(false) ?>

                <?= $form->field($model, 'participant_score_B')->textInput()->hiddenInput()->label(false) ?>

                <div class="clearfix"></div>
                <div class="form-group">

                </div>

                <?php ActiveForm::end(); ?>

            </div>
            <div class="modal-footer">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Report') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>