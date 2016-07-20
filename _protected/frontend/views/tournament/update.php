<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Tournament */

$this->title = $model->name . " ". Yii::t('app', 'Settings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tournaments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Settings');
?>
<div class="tournament-update">

    <h1><?= Html::encode($this->title);
        ?>
        <div class="pull-right">
            <?php if (Yii::$app->user->can('member')): ?>
                <?= Html::a('<i class="material-icons">add</i> ' . Yii::t('app', 'Signup'), ['participant/create', 'tournament_id' => $model->id], ['class' => 'btn btn-info']) ?>
            <?php endif ?>
            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked">
                <?php if($model->stage_type == 1): ?>
                    <li role="tournament_nav"><a href="<?= Url::to(['view', 'id' => $model->id])?>"><?= Yii::t('app', 'Group Stage') ?></a></li>
                    <li role="tournament_nav"><a href="<?= Url::to(['view', 'id' => $model->id])?>"><?= Yii::t('app', 'Final Stage') ?></a></li>
                <?php endif ?>
                <?php if($model->stage_type == 0): ?>
                    <li role="tournament_nav"><a href="<?= Url::to(['view', 'id' => $model->id])?>"><?= Yii::t('app', 'Tree') ?></a></li>
                <?php endif ?>
                <li role="tournament_nav"><a href="<?= Url::to(['participant/standings', 'tournament_id' => $model->id]) ?>"><?= Yii::t('app', 'Standings')?></a></li>
                <li role="tournament_nav"><a href="<?= Url::to(['participant/index', 'tournament_id' => $model->id])?>">Participants</a></li>
                <li role="tournament_nav" class="active"><a href="#">Settings</a></li>
                <li role="tournament_nav"><a href="<?= Url::to(['participant/signup', 'tournament_id' => $model->id]) ?>"><?= '<i class="material-icons">plus_one</i> ' .Yii::t('app', 'Signup') ?></a>
            </ul>

        </div>


        <div class="col-md-10">
            <div class="well">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>

            </div>
        </div>
    </div>
</div>
