<?php

use frontend\models\Tournament;
use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ParticipantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$tournament = Tournament::find()->where(['id' => $_GET['tournament_id']])->one();
$this->title = $tournament->name . " " . Yii::t('app', 'Standings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tournaments'), 'url' => ['tournament/index']];
$this->params['breadcrumbs'][] = ['label' => $tournament->name, 'url' => ['tournament/view', 'id' => $tournament->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Standings');
?>
<div class="participant-standings">

    <h1><?= Html::encode($this->title);
        ?>
        <div class="pull-right">

            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['tournament/index'], ['class' => 'btn btn-default']) ?>
        </div>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-2 col-xs-3">
            <?php echo $this->render('../tournament/nav', ['model' => $tournament, 'active' => Tournament::ACTIVE_STANDINGS]); ?>
        </div>
        <div class="col-md-7 col-xs-9">
            <table width="100%">
                <tr>
                    <th>
                        <?= Yii::t('app', 'Name') ?>
                    </th>
                    <th>
                        <?= Yii::t('app', 'Seed') ?>
                    </th>
                    <th>
                        <?= Yii::t('app', 'Achieved') ?>
                    </th>
                    <th>
                        <?= Yii::t('app', 'Match Wins') ?>
                    </th>
                    <th>
                        <?= Yii::t('app', 'Match Losses') ?>
                    </th>
                </tr>
                <?= ListView::widget([
                    'summary' => false,
                    'dataProvider' => $dataProvider,
                    'emptyText' => '<div class="row"><div class="col-lg-12"><div class="well">' . Yii::t('app', 'Standings are not finished.') . '</div></div></div>',
                    'itemOptions' => ['class' => 'item'],
                    'itemView' => function ($model, $key, $index, $widget) {
                        return $this->render('_standings', ['model' => $model]);
                    },
                ]) ?>

            </table>
        </div>
    </div>
</div>
