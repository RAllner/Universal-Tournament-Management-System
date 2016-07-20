<?php

use frontend\models\Tournament;
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model frontend\models\Participant */
$tournament = Tournament::find()->where(['id' => $model->tournament_id])->one();

$this->title = Yii::t('app', 'Signup');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tournaments'), 'url' => ['tournament/index']];
$this->params['breadcrumbs'][] = ['label' => $tournament->name, 'url' => ['tournament/view', 'id' => $tournament->id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="participant-signup">

    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">
        <?= Html::a('<i class="material-icons">arrow_back</i> ' . Yii::t('app', 'Back'), ['tournament/view', 'id' => $tournament->id], ['class' => 'btn btn-default']) ?>
    </span>

    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked">
                <?php if ($tournament->stage_type == 1): ?>
                    <li role="tournament_nav"><a
                            href="<?= Url::to(['tournament/view', 'id' => $tournament->id]) ?>"><?= Yii::t('app', 'Group Stage') ?></a>
                    </li>
                    <li role="tournament_nav"><a
                            href="<?= Url::to(['tournament/view', 'id' => $tournament->id]) ?>"><?= Yii::t('app', 'Final Stage') ?></a>
                    </li>
                <?php endif ?>
                <?php if ($tournament->stage_type == 0): ?>
                    <li role="tournament_nav"><a
                            href="<?= Url::to(['tournament/view', 'id' => $tournament->id]) ?>"><?= Yii::t('app', 'Tree') ?></a>
                    </li>
                <?php endif ?>
                <li role="tournament_nav"><a href="<?= Url::to(['standings', 'tournament_id' => $tournament->id]) ?>"><?= Yii::t('app', 'Standings')?></a></li>
                <li role="tournament_nav"><a href="<?= Url::to(['index', 'tournament_id' => $tournament->id]) ?>"><?= Yii::t('app', 'Participants')?></a>
                <li role="tournament_nav"><a href="<?= Url::to(['tournament/update', 'id' => $tournament->id]) ?>"><?= Yii::t('app', 'Settings')?></a>
                <li role="tournament_nav" class="active"><a href="<?= Url::to(['signup', 'tournament_id' => $tournament->id]) ?>"><?= '<i class="material-icons">plus_one</i> ' .Yii::t('app', 'Signup') ?></a>
                </li>
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
