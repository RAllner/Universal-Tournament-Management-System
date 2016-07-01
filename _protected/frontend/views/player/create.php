<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Player */

$this->title = Yii::t('app', 'Create Player');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Players'), 'url' => ['own-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="player-create">

    <h1><?= Html::encode($this->title) ?>
        <div class="pull-right">
            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['own-index'], ['class' => 'btn btn-default']) ?>
        </div>
    </h1>
    <div class="clearfix"></div>

    <div class="col-lg-4 well bs-component">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
    
</div>
