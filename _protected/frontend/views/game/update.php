<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Game */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Game',
    ]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Games'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="game-update">


    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">
                        <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['index'], ['class' => 'btn btn-default']) ?>

        </span>
    </h1>
    <div class="row">
        <div class="col-lg-8">
            <div class="well">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>

            </div>
        </div>
    </div>
</div>
