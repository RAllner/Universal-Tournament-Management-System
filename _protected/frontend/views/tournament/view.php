<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Tournament */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tournaments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
                <?php if($model->stage_type == 1): ?>
                    <li role="tournament_nav" class="active"><a href="<?= Url::to(['view', 'id' => $model->id])?>"><?= Yii::t('app', 'Group Stage') ?></a></li>
                    <li role="tournament_nav"><a href="<?= Url::to(['view', 'id' => $model->id])?>"><?= Yii::t('app', 'Final Stage') ?></a></li>
                <?php endif ?>
                <?php if($model->stage_type == 0): ?>
                    <li role="tournament_nav" class="active"><a href="<?= Url::to(['view', 'id' => $model->id])?>"><?= Yii::t('app', 'Tree') ?></a></li>
                <?php endif ?>
                <li role="tournament_nav"><a href="<?= Url::to(['participant/standings', 'tournament_id' => $model->id]) ?>"><?= Yii::t('app', 'Standings')?></a></li>
                <li role="tournament_nav"><a href="<?= Url::to(['participant/index', 'tournament_id' => $model->id])?>">Participants</a></li>
                <li role="tournament_nav"><a href="<?= Url::to(['update', 'id' => $model->id])?>">Settings</a></li>
                <li role="tournament_nav"><a href="<?= Url::to(['participant/signup', 'tournament_id' => $model->id]) ?>"><?= '<i class="material-icons">plus_one</i> ' .Yii::t('app', 'Signup') ?></a>
            </ul>

        </div>


        <div class="col-md-10">
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
