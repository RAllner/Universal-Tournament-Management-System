<?php

use common\helpers\CssHelper;
use frontend\models\Tournament;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Tournament */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tournaments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'width' => '100%']);
$options = ['data-title' => $photoInfo['alt']];
?>
<div class="tournament-view">
    <h1><?= Html::encode($this->title);
        ?>
        <div class="pull-right">
            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Tournaments'), ['index'], ['class' => 'btn btn-warning']) ?>
        </div>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
    <div class="col-md-12 col-xs-12">
        <?php echo $this->render('nav', ['model' => $model, 'active' => Tournament::ACTIVE_VIEW]); ?>
    </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="row tournament-header" style="margin-top:1em">
                <div class="col-xs-10 col-md-10 no-padding-right">
                    <div class="well">
                        <div class="media tournament">

                            <div class="media-left hidden-xs">
                                <a href="<?= Url::to(['tournament/view', 'id' => $model->id]) ?>">
                                    <img class="media-object img-circle" style="width:70px"
                                         src="<?= $photoInfo['url'] ?>"
                                         alt="<?= $model->getHostedBy() ?>">
                                </a>
                            </div>
                            <div class="media-body media-middle">
                                <h3 class="media-heading">
                                    <div class="pull-right">
                                        <?= $model->game->name ?>
                                        </br>
                                        <?= '<div class=' . CssHelper::tournamentStatusCss($model->statusName) . ">" . $model->getStatusName($model->status) . '</div>'; ?>
                                    </div>
                                    <?= Yii::t('app','Hosted by') ?>
                                    <br/>
                                    <?php if ($model->hosted_by != -1): ?>
                                        <a href="<?= Url::to(['organisation/view', 'id' => $model->organisation_id]) ?>">
                                            <?= $model->getHostedBy() ?>
                                        </a>
                                    <?php endif ?>
                                    <?php if ($model->hosted_by == -1): ?>
                                        <?= $model->getHostedBy() ?>
                                    <?php endif ?>
                                </h3>


                            </div>
                            <div class="clearfix"></div>
                            </br>
                            <?php if($model->status >= Tournament::STATUS_RUNNING): ?>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?= $model->getTournamentProgress($model)?>%" aria-valuemin="0"
                                     aria-valuemax="100" style="width: <?= $model->getTournamentProgress($model->id)?>%;">
                                    <span class="sr-only"><?= $model->getTournamentProgress($model->id)?>% <?= Yii::t('app','Complete') ?></span>
                                </div>
                            </div>
                            <div class="pull-right">
                                <?= $model->getTournamentFinishedMatchesCount($model->id).'/'.$model->getTournamentMatchesCount($model->id).' '.Yii::t('app','games') ?>
                            </div>
                            <?php endif ?>
                        </div>


                    </div>
                </div>
                <div class="col-xs-2 no-padding-left register <?= $class=($model->status >= Tournament::STATUS_RUNNING)? "locked": "" ?>">

                        <a href="<?= $class=($model->status >= Tournament::STATUS_RUNNING)? "#": Url::to(['participant/signup', 'tournament_id' => $model->id]) ?>">

                            <?= '<i class="material-icons">plus_one</i></br> ' . Yii::t('app', 'Signup') ?>

                        </a>

                </div>

            </div>
            <div class="hidden-md hidden-lg">
            <a href="<?= $class=($model->status >= Tournament::STATUS_RUNNING)? "#": Url::to(['participant/signup', 'tournament_id' => $model->id]) ?>" class="btn">

                <?= '<i class="material-icons">plus_one</i></br> ' . Yii::t('app', 'Signup') ?>

            </a>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><?= Yii::t('app','Informations')?></div>
                <ul class="list-group">
                    <li class="list-group-item">
                        <i class="material-icons">info</i>
                        <?php
                        if ($model->stage_type === Tournament::STAGE_TYPE_TWO_STAGE) {
                            echo Yii::t('app', 'Group Stage') . ': ' . $model->getFormatName($model->gs_format);
                            echo ' (' . $model->participants_compete . ' <i class="material-icons">directions_run</i> ' . $model->participants_advance . ') ' . Yii::t('app', 'Final Stage') . ': ';
                        }
                        echo $model->getFormatName($model->fs_format); ?>
                    </li>
                    <li class="list-group-item">
                        <i class="material-icons">event</i> <?= $model->begin . ' ' . Yii::t('app', 'o\' clock') ?>
                        . <?= Yii::t('app', 'Begin in') . ' ' . $model->countdown ?>
                    </li>
                    <li class="list-group-item">
                        <?= Html::a('<i class="material-icons">home</i> ' . $model->tournamentLocation->name, Url::to(['location/view', 'id' => $model->tournamentLocation->id])) . ' - ' . $model->tournamentLocation->adress . ', ' . $model->tournamentLocation->postalcode . ' ' . $model->tournamentLocation->citystate ?>
                    </li>
                    <li class="list-group-item">
                        <i class="material-icons">people</i> <?php
                        echo ($model->participants_count == null) ? 0 : $model->participants_count;
                            echo '/' . $model->max_participants . ' ';
                        if ($model->is_team_tournament === 0) {
                            echo Yii::t('app', 'players registered');
                        } else {
                            echo Yii::t('app', 'teams registered (Team tournament)');
                        }
                        ?>
                    </li>
                </ul>
                <?php if (!empty($model->description)): ?>
                    <div class="panel-body">
                        <blockquote>
                            <?= $model->description ?>
                        </blockquote>
                    </div>
                <?php endif ?>

            </div>


        </div>

    </div>
</div>
