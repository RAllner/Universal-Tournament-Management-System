<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TournamentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tournaments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tournament-index">

    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">
        <?php if (Yii::$app->user->can('premium')): ?>
            <?= Html::a('<i class="material-icons">create</i> ' . Yii::t('app', 'Create Tournament'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif ?>
        <?php if (Yii::$app->user->can('premium')): ?>
            <?= Html::a(Yii::t('app', 'Admin'), ['admin'], ['class' => 'btn btn-warning']) ?>
        <?php endif ?>
            </span>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-6">
            <div class="well">
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="well">

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],


                        'name',
                        'game_id',
                        'begin',
                        // 'end',
                        'location',
                        // 'description:ntext',
                        // 'url:url',
                        // 'max_participants',
                        // 'status',
                        // 'created_at',
                        // 'updated_at',
                        // 'has_sets',
                        // 'participants_count',
                        // 'stage_type',
                        // 'first_stage',
                        // 'fs_format',
                        // 'fs_third_place',
                        // 'fs_de_grand_finals',
                        // 'fs_rr_ranked_by',
                        // 'fs_rr_ppmw',
                        // 'fs_rr_ppmt',
                        // 'fs_rr_ppgw',
                        // 'fs_rr_ppgt',
                        // 'fs_s_ppb',
                        // 'participants_compete',
                        // 'participants_advance',
                        // 'gs_format',
                        // 'gs_rr_ranked_by',
                        // 'gs_rr_ppmw',
                        // 'gs_rr_ppmt',
                        // 'gs_rr_ppgw',
                        // 'gs_rr_ppgt',
                        // 'gs_tie_break1',
                        // 'gs_tie_break2',
                        // 'quick_advance',
                        // 'gs_tie_break3',
                        // 'gs_tie_break1_copy1',
                        // 'gs_tie_break2_copy1',
                        // 'gs_tie_break3_copy1',
                        // 'notifications',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
