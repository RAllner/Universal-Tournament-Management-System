<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 22.07.2016
 * Time: 12:26
 */
use yii\helpers\Html;
use yii\helpers\Url;

$stage_name = ($model->stage_type === 0)? Yii::t('app', 'Tournament Tree') : Yii::t('app', 'Final Stage');

$this->title = $model->name. " ".$stage_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tournaments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'width' => '100%']);
$options = ['data-title' => $photoInfo['alt']];

?>
<div class="tournament-stage">
    <h1><?= Html::encode($this->title);
        ?>
        <div class="pull-right">

            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked">
                <li role="tournament_nav"><a
                        href="<?= Url::to(['view', 'id' => $model->id]) ?>"><?= Yii::t('app', 'Information') ?></a>
                </li>
                <?php if ($model->stage_type === 1): ?>
                    <li role="tournament_nav"><a
                            href="<?= Url::to(['group-stage', 'id' => $model->id]) ?>"><?= Yii::t('app', 'Group Stage') ?></a>
                    </li>
                    <li role="tournament_nav" class="active"><a
                            href="<?= Url::to(['stage', 'id' => $model->id]) ?>"><?= Yii::t('app', 'Final Stage') ?></a>
                    </li>
                <?php endif ?>
                <?php if ($model->stage_type === 0): ?>
                    <li role="tournament_nav"  class="active"><a
                            href="<?= Url::to(['stage', 'id' => $model->id]) ?>"><?= Yii::t('app', 'Tree') ?></a></li>
                <?php endif ?>
                <li role="tournament_nav"><a
                        href="<?= Url::to(['participant/standings', 'tournament_id' => $model->id]) ?>"><?= Yii::t('app', 'Standings') ?></a>
                </li>
                <li role="tournament_nav"><a
                        href="<?= Url::to(['participant/index', 'tournament_id' => $model->id]) ?>">Participants</a>
                </li>
                <li role="tournament_nav"><a href="<?= Url::to(['update', 'id' => $model->id]) ?>">Settings</a></li>
            </ul>
            <?php if($model->status === 1): ?>
                <?= Html::a('<i class="material-icons">publish</i> ' . Yii::t('app', 'Publish'), ['publish', 'id' => $model->id], ['class' => 'btn btn-block btn-success']) ?>
            <?php endif ?>
            <?php if ($model->status < 3 && $model->status !== 1): ?>

                <?= Html::a('<i class="material-icons">play_arrow</i> ' . Yii::t('app', 'Start'), ['start', 'id' => $model->id], ['class' => 'btn btn-block btn-warning']) ?>
            <?php endif ?>
            <?php if (Yii::$app->user->can('updateTournament') && $model->status >=3 && $model->status <=4): ?>
                <?= Html::a(Yii::t('app', 'Abort'), ['abort', 'id' => $model->id], [
                    'class' => 'btn btn-block btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to abort this tournament?'),
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a(Yii::t('app', 'Reset'), ['reset', 'id' => $model->id], [
                    'class' => 'btn btn-block btn-default',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to reset this tournament?'),
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif ?>
        </div>
        <div class="col-md-10">
            <div class="well">

            </div>
        </div>
    </div>
</div>


