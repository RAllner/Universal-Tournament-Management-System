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
            <?php if (Yii::$app->user->can('member')): ?>
                <?= Html::a('<i class="material-icons">add</i> ' . Yii::t('app', 'Signup'), ['participant/signup', 'tournament_id' => $model->id], ['class' => 'btn btn-info']) ?>
            <?php endif ?>
            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked">
                <?php if ($model->stage_type == 1): ?>
                    <li role="tournament_nav" class="active"><a
                            href="<?= Url::to(['view', 'id' => $model->id]) ?>"><?= Yii::t('app', 'Group Stage') ?></a>
                    </li>
                    <li role="tournament_nav"><a
                            href="<?= Url::to(['view', 'id' => $model->id]) ?>"><?= Yii::t('app', 'Final Stage') ?></a>
                    </li>
                <?php endif ?>
                <?php if ($model->stage_type == 0): ?>
                    <li role="tournament_nav" class="active"><a
                            href="<?= Url::to(['view', 'id' => $model->id]) ?>"><?= Yii::t('app', 'Tree') ?></a></li>
                <?php endif ?>
                <li role="tournament_nav"><a
                        href="<?= Url::to(['participant/standings', 'tournament_id' => $model->id]) ?>"><?= Yii::t('app', 'Standings') ?></a>
                </li>
                <li role="tournament_nav"><a
                        href="<?= Url::to(['participant/index', 'tournament_id' => $model->id]) ?>">Participants</a>
                </li>
                <li role="tournament_nav"><a href="<?= Url::to(['update', 'id' => $model->id]) ?>">Settings</a></li>
                <li role="tournament_nav"><a
                        href="<?= Url::to(['participant/signup', 'tournament_id' => $model->id]) ?>"><?= '<i class="material-icons">plus_one</i> ' . Yii::t('app', 'Signup') ?></a>
            </ul>

        </div>


        <div class="col-md-10">
            <div class="well">
                <div class="media tournament">
                    <div class="media-left">
                        <a href="<?= Url::to(['tournament/view', 'id' => $model->id]) ?>">
                            <img class="media-object img-circle" style="width:100px" src="<?= $photoInfo['url'] ?>"
                                 alt="<?= $model->getHostedBy() ?>">
                        </a>
                    </div>
                    <div class="media-body media-middle">
                        <h3 class="media-heading ">
                            <div class="pull-right">
                                <?= $model->game->name ?>
                                </br>
                                <?= '<div class='.CssHelper::generalStatusCss($model->statusName).">".$model->getStatusName($model->status).'</div>';?>
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
                </div>


            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Informations</div>
                <ul class="list-group">
                    <li class="list-group-item">
                        <i class="material-icons">info</i>
                        <?php
                        if($model->stage_type === Tournament::STAGE_TYPE_TWO_STAGE) {
                            echo  Yii::t('app','Group Stage').': '.$model->getFormatName($model->gs_format);
                            echo ' ('.$model->participants_compete.' <i class="material-icons">directions_run</i> ' .$model->participants_advance.') '. Yii::t('app','Final Stage').': ';
                        }
                        echo $model->getFormatName($model->fs_format); ?>
                    </li>
                    <li class="list-group-item">
                        <i class="material-icons">event</i> <?= $model->begin . ' ' . Yii::t('app', 'o\' clock') ?>.  <?= Yii::t('app', 'Begin in'). ' '. $model->countdown ?>
                    </li>
                    <li class="list-group-item">
                        <?= Html::a('<i class="material-icons">home</i> '.$model->tournamentLocation->name, Url::to(['location/view', 'id' => $model->tournamentLocation->id])) . ' - '. $model->tournamentLocation->adress . ', '.$model->tournamentLocation->postalcode. ' '.$model->tournamentLocation->citystate?>
                    </li>
                    <li class="list-group-item">
                        <i class="material-icons">people</i> <?= $model->participants_count. '/'.$model->max_participants. ' '. Yii::t('app', 'participants registered') ?>
                    </li>
                </ul>
                <?php if(!empty($model->description)): ?>
                <div class="panel-body">
                    <blockquote>
                        <?= $model->description ?>
                    </blockquote>
                </div>
                <?php endif ?>
            </div>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'user_id',
                    'game_id',
                    'organisation_id',
                    'hosted_by',
                    'name',
                    'begin',
                    'end',
                    'location',
                    'description:ntext',
                    'url:url',
                    'max_participants',
                    'status',
                    'created_at',
                    'updated_at',
                    'has_sets',
                    'participants_count',
                    'stage_type',
                    'is_team_tournament',
                    'fs_format',
                    'fs_third_place',
                    'fs_de_grand_finals',
                    'fs_rr_ranked_by',
                    'fs_rr_ppmw',
                    'fs_rr_ppmt',
                    'fs_rr_ppgw',
                    'fs_rr_ppgt',
                    'fs_s_ppb',
                    'participants_compete',
                    'participants_advance',
                    'gs_format',
                    'gs_rr_ranked_by',
                    'gs_rr_ppmw',
                    'gs_rr_ppmt',
                    'gs_rr_ppgw',
                    'gs_rr_ppgt',
                    'gs_tie_break1',
                    'gs_tie_break2',
                    'quick_advance',
                    'gs_tie_break3',
                    'gs_tie_break1_copy1',
                    'gs_tie_break2_copy1',
                    'gs_tie_break3_copy1',
                    'notifications',
                ],
            ]) ?>

        </div>
    </div>
</div>
