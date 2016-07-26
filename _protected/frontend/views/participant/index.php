<?php

use frontend\models\Tournament;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ParticipantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $tournament frontend\models\Tournament */
/* @var $model frontend\models\Participant */
/* @var $source array */
/* @var $bulk frontend\models\Bulk */


$this->title = $tournament->name . " " . Yii::t('app', 'Participants');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tournaments'), 'url' => ['tournament/index']];
$this->params['breadcrumbs'][] = ['label' => $tournament->name, 'url' => ['tournament/view', 'id' => $tournament->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Participants');
?>
<div class="participant-index">

    <h1><?= Html::encode($this->title);
        ?>
        <div class="pull-right">
            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['tournament/index'], ['class' => 'btn btn-default']) ?>
        </div>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-2">
            <?php echo $this->render(Url::to('/tournament/nav'), ['model' => $tournament, 'active' => Tournament::ACTIVE_PARTICIPANTS]); ?>
        </div>
        <div class="col-md-10">
            <?= Html::a('<i class="material-icons">shuffle</i> ' . Yii::t('app', 'Shuffle Seeds'), ['shuffle-seeds', 'tournament_id' => $tournament->id], ['class' => 'btn btn-info']) ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'tournament_id',
                    //'signup',
                    //'checked_in',
                    'name',
                    'seed',
                    // 'updated_at',
                    // 'created_at',
                    // 'rank',
                    // 'user_id',
                    // 'team_id',
                    // 'removed',
                    // 'on_waiting_list',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php if (Yii::$app->user->can('updateTournament', ['model' => $tournament])): ?>
                <div class="row">
                    <div class="col-md-6">

                        <div class="well">
                            <?= $this->render('_adminForm', [
                                'model' => $model,
                                'source' => $source,
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="well">
                            <?= $this->render('_bulkForm', [
                                'bulk' => $bulk,
                            ]) ?>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>

</div>