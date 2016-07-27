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
            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-2 col-xs-3">
            <?php echo $this->render('nav', ['model' => $model, 'active' => Tournament::ACTIVE_VIEW]); ?>
        </div>


        <div class="col-md-10 col-xs-9">
            <div class="row tournament-header">
                <div class="col-xs-10 no-padding-right">
                    <div class="well">
                        <div class="media tournament">
                            <div class="media-left">
                                <a href="<?= Url::to(['tournament/view', 'id' => $model->id]) ?>">
                                    <img class="media-object img-circle" style="width:100px"
                                         src="<?= $photoInfo['url'] ?>"
                                         alt="<?= $model->getHostedBy() ?>">
                                </a>
                            </div>
                            <div class="media-body media-middle">
                                <h3 class="media-heading ">
                                    <div class="pull-right">
                                        <?= $model->game->name ?>
                                        </br>
                                        <?= '<div class=' . CssHelper::tournamentStatusCss($model->statusName) . ">" . $model->getStatusName($model->status) . '</div>'; ?>
                                    </div>
                                    Hosted By</br>
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
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                                     aria-valuemax="100" style="width: <?= $model->getTournamentProgress($model)?>%;">
                                    <span class="sr-only"><?= $model->getTournamentProgress($model)?>% Complete</span>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="col-xs-2 no-padding-left register">

                        <a href="<?= Url::to(['participant/signup', 'tournament_id' => $model->id]) ?>">

                            <?= '<i class="material-icons">plus_one</i></br> ' . Yii::t('app', 'Signup') ?>

                        </a>

                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Informations</div>
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
                        echo $model->participants_count . '/' . $model->max_participants . ' ';
                        if ($model->is_team_tournament === 0) {
                            echo Yii::t('app', 'participants registered');
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
