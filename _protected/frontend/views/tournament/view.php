<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Tournament */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tournaments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tournament-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

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
            'first_stage',
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
