<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Team */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Team',
    ]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="team-update">

    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">
        <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['index'], ['class' => 'btn btn-default']) ?>
    </span>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-8">
            <div class="well bs-component">
                <?= $this->render('_form', ['model' => $model]) ?>
            </div>
        </div>
    </div>

</div>
