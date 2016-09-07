<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 25.07.2016
 * Time: 11:08
 */
use frontend\models\Tournament;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model frontend\models\Tournament */
/* @var $active integer */


?>
    <ul class="nav nav-pills nav-stacked">
        <li role="tournament_nav" class="<?= $class = ($active === Tournament::ACTIVE_VIEW)? 'active' : '' ?>">
            <?= Html::a(Yii::t('app', 'Information'), $url = ($active !== Tournament::ACTIVE_VIEW)? Url::to(['/tournament/view', 'id' => $model->id]) : "#")?>
        </li>
        <?php if ($model->stage_type === 1 && $model->status > 2): ?>
            <li role="tournament_nav" class="<?= $class = ($active === Tournament::ACTIVE_GROUP_STAGE)? 'active' : '' ?>">
                <?= Html::a(Yii::t('app', 'Group Stage'), $url = ($active !== Tournament::ACTIVE_GROUP_STAGE)? Url::to(['/tournament/group-stage', 'id' => $model->id]) : "#")?>
            </li>
            <li role="tournament_nav" class="<?= $class = ($active === Tournament::ACTIVE_FINAL_STAGE)? 'active' : '' ?>">
                <?= Html::a(Yii::t('app', 'Final Stage'), $url = ($active !== Tournament::ACTIVE_FINAL_STAGE)? Url::to(['/tournament/stage', 'id' => $model->id]) : "#")?>
            </li>
        <?php endif ?>
        <?php if ($model->stage_type === 0): ?>
            <li role="tournament_nav" class="<?= $class = ($active === Tournament::ACTIVE_FINAL_STAGE)? 'active' : '' ?>">
                <?= Html::a(Yii::t('app', 'Bracket'), $url = ($active !== Tournament::ACTIVE_FINAL_STAGE)? Url::to(['/tournament/stage', 'id' => $model->id]) : "#")?>
        <?php endif ?>
        <li role="tournament_nav" class="<?= $class = ($active === Tournament::ACTIVE_STANDINGS)? 'active' : '' ?>">
            <?= Html::a(Yii::t('app', 'Standings'), $url = ($active !== Tournament::ACTIVE_STANDINGS)? Url::to(['/participant/standings', 'tournament_id' => $model->id]) : "#")?>
        </li>
        <li role="tournament_nav" class="<?= $class = ($active === Tournament::ACTIVE_PARTICIPANTS)? 'active' : '' ?>">
            <?= Html::a(Yii::t('app', 'Participants'), $url = ($active !== Tournament::ACTIVE_PARTICIPANTS)? Url::to(['/participant/index', 'tournament_id' => $model->id]) : "#")?>
        </li>
        <?php if(Yii::$app->user->can('updateTournament', ['model' => $model])): ?>
        <li role="tournament_nav" class="<?= $class = ($active === Tournament::ACTIVE_SETTINGS)? 'active' : '' ?>">
            <?= Html::a(Yii::t('app', 'Settings'), $url = ($active !== Tournament::ACTIVE_SETTINGS)? Url::to(['/tournament/update', 'id' => $model->id]) : "#")?>
        </li>
        <?php endif ?>
    </ul>
<?php if(Yii::$app->user->can('updateTournament', ['model' => $model])): ?>
    <?= $link = ($model->status == Tournament::STATUS_COMPLETE) ? Html::a('<i class="material-icons">done</i> ' . Yii::t('app', 'Finish'), ['finish', 'id' => $model->id], ['class' => 'btn btn-block btn-success']) : "" ?>
    <?php if ($model->status === 1): ?>
        <?= Html::a('<i class="material-icons">publish</i> ' . Yii::t('app', 'Publish'), ['/tournament/publish', 'id' => $model->id], ['class' => 'btn btn-block btn-success']) ?>
    <?php endif ?>
    <?php if ($model->status == 2): ?>
        <?= Html::a('<i class="material-icons">play_arrow</i> ' . Yii::t('app', 'Start'), ['/tournament/start', 'id' => $model->id], ['class' => 'btn btn-block btn-warning']) ?>
    <?php endif ?>
    <?php if ($model->status == 4): ?>
        <?= Html::a('<i class="material-icons">play_arrow</i> ' . Yii::t('app', 'Start Final'), ['/tournament/start-final-stage', 'id' => $model->id], ['class' => 'btn btn-block btn-warning']) ?>
    <?php endif ?>
<?php endif ?>
