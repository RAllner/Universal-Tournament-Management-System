<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 09.09.2016
 * Time: 21:07
 */
/* @var $this yii\web\View */
/* @var $model frontend\models\TournamentMatch */
/* @var $stage integer */


use frontend\models\Participant;
use frontend\models\Tournament;
use frontend\models\TournamentMatch;
use yii\helpers\Html;
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

$groupStageTitle = ($model->stage == Tournament::STAGE_GS) ? Yii::t('app', 'Group Stage') : Yii::t('app', 'Final Stage');
$title = ($tournament->stage_type == Tournament::STAGE_TYPE_SINGLE_STAGE) ? $tournament->name : $tournament->name . " - " . $groupStageTitle;


/** @var Participant $participant_B */
$participant_B = Participant::find()
    ->where(['id' => $model->participant_id_B])
    ->one();

$photoInfoA = $model->getParticipantAImage();
$photoA = Html::img($photoInfoA['url'], ['alt' => $photoInfoA['alt'], 'style' => 'width:100%']);
$optionsA = ['data-lightbox' => 'profile-image', 'data-title' => $photoInfoA['alt']];

$photoInfoB = $model->getParticipantBImage();
$photoB = Html::img($photoInfoB['url'], ['alt' => $photoInfoB['alt'], 'style' => 'width:100%']);
$optionsB = ['data-lightbox' => 'profile-image', 'data-title' => $photoInfoB['alt']];
?>


<div class="modal fade match" id="myModal<?= $model->id ?>" tabindex="-1" role="dialog"
     aria-labelledby="match<?= $model->id ?>Modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h2 class="modal-title" id="myModalLabel"><?= Yii::t('app', 'Match') . ' ' . $model->matchID ?></h2>
                <p><?= $title ?></p>
            </div>
            <div class="modal-body">


                <?php $form = ActiveForm::begin([
                    'action' => ['tournament/report-match', 'id' => $model->id],
                    'options' => [
                        'id' => $model->id,
                    ]]); ?>
                <div class="row">
                    <div class="col-xs-5">
                        <figure style="text-align: center">
                            <?= Html::a($photoA, $photoInfoA['url'], $optionsA) ?>
                        </figure>
                    </div>
                    <div class="col-xs-2">
                        <div class="vs">VS</div>
                    </div>

                    <div class="col-xs-5">
                        <figure style="text-align: center">
                            <?= Html::a($photoB, $photoInfoB['url'], $optionsB) ?>
                        </figure>
                    </div>
                </div>
                <div class="row">
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
                </div>
                <div class="clearfix"></div>
                <div class="row">
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

                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-xs-12 center">
                        <button type="button" class="btn btn-primary report-match"
                                data-target="<?= $model->id ?>"><?= Yii::t('app', 'Report') ?></button>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
