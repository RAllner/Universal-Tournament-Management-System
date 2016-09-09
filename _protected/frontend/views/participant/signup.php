<?php

use frontend\models\Tournament;
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model frontend\models\Participant */
$tournament = Tournament::find()->where(['id' => $model->tournament_id])->one();

$this->title = $tournament->name . ' '. Yii::t('app', 'Signup');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tournaments'), 'url' => ['tournament/index']];
$this->params['breadcrumbs'][] = ['label' => $tournament->name, 'url' => ['tournament/view', 'id' => $tournament->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Signup');

?>
<div class="participant-signup">

    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">
            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['tournament/index'], ['class' => 'btn btn-default']) ?>
    </span>

    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-xs-12">
            <?php echo $this->render('../tournament/nav', ['model' => $tournament, 'active' => -1]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10">

            <div class="well">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
            </div>
        </div>
    </div>
</div>
