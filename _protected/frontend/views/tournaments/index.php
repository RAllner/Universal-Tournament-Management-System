<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TournamentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tournaments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tournaments-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Tournaments'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idtournaments',
            'name',
            'begin',
            'end',
            'location',
            // 'sports_idsports',
            // 'description:ntext',
            // 'url:url',
            // 'max_participants',
            // 'third_place',
            // 'format',
            // 'status',
            // 'created_at',
            // 'updated_at',
            // 'has_sets',
            // 'tournamentscol',
            // 'user_id',
            // 'organisation_idorganisation',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
