<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Videos */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Videos',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Videos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="videos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-lg-8 well bs-component">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>